<?php
use Phalcon\Cli\Task;

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午1:00
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 *
 * https://wiki.swoole.com/wiki/page/683.html
 * @property Phalcon\Config config
 */
class MainTask extends Task
{
    public function mainAction()
    {
        /**
         * 配置文件
         */
        $config = $this->config->server;
        /**
         * 新建swoole服务
         */
        $serv = new swoole_server($config->host, $config->prot);
        //设置task_worker_num
        $serv->set([
            'worker_num' => $config->worker_num,
            'task_worker_num' => $config->task_worker_num,
        ]);
        //客户端链接回调
        $serv->on('Connect', function ($serv, $fd) {
            echo "new client connected.\n";
        });
        //接受客户端数据，使用 task
        $serv->on('Receive', function ($serv, $fd, $fromId, $data) {
            echo "worker received data: {$data}\n";
            // 投递一个任务到task进程中
            $arr = json_decode($data);
            if(!empty($arr)){
                $name = $arr->name ?? '';
                $msg = $arr->message ?? '';
                if($name == "ping"){
                    $serv->send($fd, 'pong'.PHP_EOL.date("Y-m-d h:i:sa"));
                }elseif ($name == "mysql_test"){
                    $serv->task($msg);
                    // 通知客户端server收到数据了
                    $serv->send($fd, 'mysql_test_success');
                }
            }
            // 为了校验task是否是异步的，这里和task进程内都输出内容，看看谁先输出
            echo "worker continue run.\n";
        });

        /**
         * $serv swoole_server
         * $taskId 投递的任务id,因为task进程是由worker进程发起，所以多worker多task下，该值可能会相同
         * $fromId 来自那个worker进程的id
         * $data 要投递的任务数据
         */
        $serv->on('Task', function ($serv, $taskId, $fromId, $data) {
            echo "task start. --- from worker id: {$fromId}.\n";
            echo $data;
            $msyql = new MysqlTask();
            $msyql->task1($data);
            return "task end";
        });
        /**
         * 只有在task进程中调用了finish方法或者return了结果，才会触发finish
         */
        $serv->on('Finish', function ($serv, $taskId, $data) {
            echo "finish received data '{$data}'\n";
        });
        //关闭连接
        $serv->on('Close', function ($serv, $fd) {
            echo "Client {$fd} close connection\n";
        });
        //执行
        $serv->start();
    }

    /**
     *
     * $this->console->handle(
     *   [
     *      "task"   => "main",
     *       "action" => "test",
     *  ]);
     *
     */
    public function testAction(){
        echo "hello";
    }

}