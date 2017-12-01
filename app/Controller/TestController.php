<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午9:01
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller;
use App\Models\Account;
use App\Mvc\SwooleClient;

/**
 * Class RoomController
 * @package App\Controller
 * @url_prefix(value = "/test")
 */
class TestController extends ControllerBase
{
    /**
     * @Mapping(path = "/",method ="post")
     * @ScopesPublic 公开
     */
    public function addOne(){
        /**
         * 请用 form data 形式上传数据
         */
        $accountId = $this->request->getPost('accountId','int');
        if($accountId){
            $account = new Account();
            $account->accountId =$accountId;
            $account->accountType = 1;
            $account->shopID =1;
            $account->accountName = "sc";
            $account->userId = 1;
            $account->text = "hello";
            $account->updateFlag = 1;
            if(!$account->save()){
                foreach ($account->getMessages() as $message){
                    echo $message;
                }
                exit();
            }
           return $this->responseOk();
        }
    }

    /**
     * @Mapping(path = "/mysql/{n:[0-9]+}",method="get")
     *
     * 使用swoole 进行异步处理,需启动TCPServer 中的swoole 服务
     * php cli.php
     */
    public function mysql($n)
    {
        $client = new SwooleClient();
        $client->send("mysql_test",$n);
        $res = $client->get();
        echo $res;
    }

    /**
     *@Mapping(path = "/ping",method="get")
     * swoole 心跳测试
     */
    public function ping(){
        $client = new SwooleClient();
        $client->send("ping");
        $res = $client->get();
        echo $res;
    }

    /**
     * @Mapping(path = "/{id:[0-9]+}",method="get")
     */
    public function getId($id){
        $res = Account::findFirst($id);
        return $res;
    }

    /**
     * @Mapping(path = "/export")
     */
    public function export(){

    }

    /**
     * @Mapping(path= "/maopao")
     */
    public function maoAction(){
        //echo rand(1,500);
        $source = [];
        for ($i=0;$i<100;$i++){
            $source[] =rand(1,1000);
        }
        $str = implode(" ,",$source);
        echo "随机数, {$str} \n";
        echo "<br/>";
        $len = count($source);
        for($k=0;$k<=$len;$k++)
        {
            for($j=$len-1;$j>$k;$j--){
                if($source[$j]<$source[$j-1]){
                    $temp = $source[$j];
                    $source[$j] = $source[$j-1];
                    $source[$j-1] = $temp;
                }
            }
        }
        $str2 = implode(" ,",$source);
        echo "排序后 : {$str2}";
    }

}