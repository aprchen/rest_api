<?php
namespace App\Models;
use App\Component\ApiException;
use App\Constants\ErrorCode;
use App\Constants\Services;
use App\Models\Base\CacheBase;
use App\Models\Base\ModelBase;
use App\Models\Behavior\Blamable;
use App\Plugins\RegVerify;
use Phalcon\Di;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Validation;

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/28
 * Time: 下午7:14
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

class User extends ModelBase
{
    use RegVerify;

    const ACTIVE = 1;
    const EMAIL_VERIFIED =1;
    const MAN = 1;
    const WOMAN =0 ;
    const DELETED     = '1';
    const NOT_DELETED = '0';
    /**
     *
     * @var string
     */
    public $nickname;

    /**
     *
     * @var string
     */
    protected $username;

    /**
     *
     * @var string
     */
    public $realName;

    /**
     *
     * @var string
     */
    protected $password;

    /**
     *
     * @var integer
     */
    public $sex;

    /**
     *
     * @var double
     */
    public $money;

    /**
     *
     * @var double
     */
    public $frozenMoney;

    /**
     *
     * @var string
     */
    public $mobilePhone;


    /**
     *
     * @var integer
     */
    public $isActive;

    /**
     *
     * @var integer
     */
    public $isMobilePhoneVerified;
    /**
     *
     * @var string
     */
    public $isEmailVerified;

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'nick_name' => 'nickname',
            'user_name' => 'username',
            'password' => 'password',
            'real_name' => 'realName',
            'mobile_phone' => 'mobilePhone',
            'is_active' => 'isActive',
            'is_deleted' => 'isDeleted',
            'email' => 'email',
            'sex' => 'sex',
            'is_email_verified' => 'isEmailVerified',
            'money' => 'money',
            'frozen_money' => 'frozenMoney',
            'is_mobile_phone_verified' => 'isMobilePhoneVerified',
            'gmt_create' => 'gmtCreate',
            'gmt_modified' => 'gmtModified'
        );
    }

    public function validation()
    {
        if ($this->mobilePhone) {
            if(!$this->isMobile($this->mobilePhone)){
                $message = new Message(
                    '号码格式错误',
                    'mobilePhone',
                    'MyType'
                );
                $this->appendMessage($message);
                return false;
            }
        }
        if ($this->email) {
            if(!$this->isEmail($this->email)){
                $message = new Message(
                    '邮箱格式错误',
                    'email',
                    'MyType'
                );
                $this->appendMessage($message);
                return false;
            }
        }
        $validation = new Validation();
        $validation->add(
            'username',
            new Validation\Validator\Uniqueness(
                [
                    'message' => ' username 必须是唯一的',
                ]
            )
        )->add('mobilePhone',
            new Validation\Validator\Uniqueness(
                [
                    'message' => ' mobilePhone 必须是唯一的',
                ]
            )
        )->add('email',new Validation\Validator\Uniqueness(
            [
                'message' => ' email 必须是唯一的',
            ]
        ));
        return $this->validate($validation);
    }

    public function initialize()
    {
        $this->addBehavior(
            new SoftDelete(
                [
                    'field' => 'isDeleted',
                    'value' => User::DELETED,
                ]
            )
        );
        $this->addBehavior(new Blamable());//操作日志
        $this->hasMany(
            'id', 'App\Models\UserRole', 'userId', array(
            'alias' => 'userRole'
        ));
    }

    /**
     * @param string $password
     * @return bool
     * 密码校验
     */
    public function verifyPassWord(string $password):bool
    {
        /** @var \Phalcon\Security $security */
        $security = Di::getDefault()->get(Services::SECURITY);
        return $security->checkHash($password,$this->password);
    }

    /**
     * @param string $password
     * @throws ApiException
     * 密码由6-16位大小写字母、数字和下划线组成
     * 设置密码
     */
    public function setPassword(string $password)
    {
        if(!$this->isPassword($password)){
            throw new ApiException(ErrorCode::DATA_FAILED,'密码由6-16位大小写字母、数字和下划线组成');
        }
        /** @var \Phalcon\Security $security */
        $security = Di::getDefault()->get(Services::SECURITY);
        $this->password = $security->hash($password);
    }


    /**
     * @param string $name
     * @throws ApiException
     */
    public function setUsername(string $name)
    {
        if(!$this->isUserName($name)){
            throw new ApiException(ErrorCode::DATA_FAILED,'用户名由6-24位字母、数字组成，首位不能是数字');
        }
        $this->username = $name;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

}