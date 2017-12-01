<?php

namespace App\Models;
use Phalcon\Mvc\Model;

class Account extends Model
{
    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $shopID;

    /**
     *
     * @var integer
     */
    public $accountId;
    /**
     *
     * @var string
     */
    public $accountType;
    public $accountName;

    public $accountValue;
    /**
     *
     * @var string
     */
    public $dateTime;
    /**
     *
     * @var integer
     */
    public $userId;
    /**
     *
     * @var integer
     */
    public $text;
    /**
     *
     * @var integer
     */
    public $updateFlag;

    public function getSource()
    {
        $arr = explode('\\',get_class($this));
        return $this->getDI()->get('config')->database->prefix.strtolower(end($arr));
    }


    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function  columnMap()
    {
        return array(
            '_id' => 'id',
            'nShopID' => 'shopId',
            'nAccountID' => 'accountId',
            'nAccountType' => 'accountType',
            'fAccountValue' => 'accountValue',
            'sAccountName' => 'accountName',
            'nDateTime' => 'dateTime',
            'nUserID' => 'userId',
            'sText' => 'text',
            'nUpdateFlag' => 'updateFlag',
        );
    }

    public function beforeCreate()
    {
        $this->dateTime = date('Y-m-d H:i:s');
    }
}
