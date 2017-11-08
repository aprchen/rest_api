<?php

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/11/7
 * Time: 下午5:48
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
class MysqlTask
{
    protected  $db;
    function __construct()
    {
        $db = new MysqliDb ('host', 'username', 'password', 'databaseName');
        $this->db = $db;
    }

    public function task1($num)
    {

//删除上次的插入数据
        //$this->db->query('delete from `t_account`');
//开始计时
        $start_time = time();
        $sum = 1000000;
// 测试选项
        if ($num == 1){
            // 单条插入
            for($i = 0; $i < $sum; $i++){
                $this->db->query(
                    "insert into 
                    `t_account` (`nShopID`,`nAccountID`,`nAccountType`,`sAccountName`,`fAccountValue`,`nDateTime`,`nUserID`,`sText`,`nUpdateFlag`)
                    values 
                    ($i,$i,1,1,1,1,1,1,1)"
                );
            }
        } elseif ($num == 2) {
            // 批量插入，为了不超过max_allowed_packet，选择每10万插入一次
            for ($i = 0; $i < $sum; $i++) {
                if ($i == $sum - 1) { //最后一次
                    if ($i%100000 == 0){
                        $values = "($i,$i,1,1,1,1,1,1,0)";
                        $this->db->query("insert into 
                    `t_account` (`nShopID`,`nAccountID`,`nAccountType`,`sAccountName`,`fAccountValue`,`nDateTime`,`nUserID`,`sText`,`nUpdateFlag`)
                    values $values");
                    } else {
                        $values = "($i,$i,1,1,1,1,1,1,1)";
                        $this->db->query("insert into 
                    `t_account` (`nShopID`,`nAccountID`,`nAccountType`,`sAccountName`,`fAccountValue`,`nDateTime`,`nUserID`,`sText`,`nUpdateFlag`)
                    values $values");
                    }
                    break;
                }
                if ($i%100000 == 0) { //平常只有在这个情况下才插入
                    if ($i == 0){
                        $values = "($i,$i,1,1,1,1,1,1,1)";
                    } else {
                        $this->db->query("insert into `test` (`id`, `name`) values $values");
                        $values = "($i,$i,1,1,1,1,1,1,1)";
                    }
                } else {
                    $values .= "($i,$i,1,1,1,1,1,1,0)";
                }
            }
        } elseif ($num == 3) {
            // 事务插入
            $this->db->beginTransaction();
            for($i = 0; $i < $sum; $i++){
                $this->db->query("insert into 
                    `t_account` (`nShopID`,`nAccountID`,`nAccountType`,`sAccountName`,`fAccountValue`,`nDateTime`,`nUserID`,`sText`,`nUpdateFlag`)
                    values 
                    ($i,$i,1,1,1,1,1,1,1)"
                );
            }
            $this->db->commit();
        } elseif ($num == 4) {
            // 文件load data
            $filename = dirname(__FILE__).'/../db/test.sql';
            $fp = fopen($filename, 'w');
            for($i = 0; $i < $sum; $i++){
                fputs($fp, "$i,$i,1,1,1,1,1,1,1 \r\n");
            }
            $this->db->exec("load data infile '$filename' into table t_account fields terminated by ','");
        }

        $end_time = time();
        echo "总耗时", ($end_time - $start_time), "秒\n";
        echo "峰值内存", round(memory_get_peak_usage()/1000), "KB\n";

    }
}