<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:41
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
namespace App\Controller;
use App\Component\ApiException;
use App\Component\Auth\Account\EmailAccountType;
use App\Component\Auth\Account\UsernameAccountType;
use App\Component\Auth\Manager;
use App\Constants\ErrorCode;
use App\Plugins\RegVerify;

/**
 * Class UsersController
 * @package App\Controller
 * @group(path="/oauth",name=user)
 */
class OauthController extends ControllerBase
{
    use RegVerify;
    /**
     * basic auth
     * @point(path="/token",method="post",scopes={unauthorized})
     */
    public function postToken(){
        $username = $this->request->getUsername();
        $password = $this->request->getPassword();
        if(!$username || !$password){
            throw new ApiException(ErrorCode::POST_DATA_NOT_PROVIDED,"Basic Auth:{username,password}");
        }
        $type = $this->typeCheck($username);
        $session = $this->authManager->login($type,[
            Manager::LOGIN_DATA_USERNAME=>$username,
            Manager::LOGIN_DATA_PASSWORD=>$password
        ]);
        $response = [
            'token' => $session->getToken(),
            'expires' => $session->getExpirationTime(),
            'scopes'=> $this->userService->getScopes()
        ];
        return $this->createResponse($response);
    }

    /**
     * @param $username
     * @return string
     */
    protected function typeCheck($username){
        if($this->isEmail($username)){
            $type = EmailAccountType::NAME;
        }elseif ($this->isMobile($username)){
            $type = 'phone';
        }else{
            $type = UsernameAccountType::NAME;
        }
        return $type;
    }


    /**
     * 查询token 信息
     * oauth 2.0
     */
    public function getToken(){

    }

    /**
     * 更新token
     * oauth 2.0
     */
    public function putToken(){

    }

    /**
     * 删除token
     * oauth 2.0
     */
    public function deleteToken(){

    }

}