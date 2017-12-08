<?php
namespace App\Models;
use App\Component\ApiException;
use App\Constants\ErrorCode;
use App\Constants\Services;
use App\Plugins\RegVerify;
use Phalcon\Di;
use Phalcon\Validation;
use Phalcon\Validation\Message;

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

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $nickName;

    /**
     *
     * @var string
     */
    protected $userName;

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
            'nick_name' => 'nickName',
            'user_name' => 'userName',
            'password' => 'password',
            'real_name' => 'realName',
            'mobile_phone' => 'mobilePhone',
            'is_active' => 'isActive',
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
        if ($this->phone) {
            if(!$this->isMobile($this->phone)){
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
            'userName',
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
    public function setUserName(string $name)
    {
        if(!$this->isUserName($name)){
            throw new ApiException(ErrorCode::DATA_FAILED,'用户名由6-24位字母、数字组成，首位不能是数字');
        }
        $this->userName = $name;
    }

}