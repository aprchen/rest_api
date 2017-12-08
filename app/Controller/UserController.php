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
use App\Component\Auth\Manager;
use App\Constants\Acl\Scopes;
use App\Constants\ErrorCode;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Plugins\RegVerify;

/**
 * Class UsersController
 * @package App\Controller
 * @group(path="/users",name=user)
 */
class UserController extends ControllerBase
{
    use RegVerify;
    /**
     *
     * @point(path="/authenticate",method="get",scopes={unauthorized})
     */
    public function authenticate(){
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
        $data = $this->userService->getDetails();
        $response = [
            'token' => $session->getToken(),
            'expires' => $session->getExpirationTime(),
            'user'=>$data
        ];
        return $this->response->setJsonContent($response);
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
            $type = 'user';
        }
        return $type;
    }

    /**
     * @point(path="/me",name='me',scopes={super_user,manager_user})
     */
    public function me(){
        $this->responseItem($this->userService->getDetails());
    }

    /**
     * 添加管理用户用
     * @point(path='/admin',method='get',scopes={unauthorized})
     */
    public function addAdmin(){
        $this->db->begin();
        $admin = new User();
        $admin->setPassword('123456');
        $admin->setUserName("sladmin");
        $admin->mobilePhone = '12345678901';
        $admin->isActive = User::ACTIVE;
        if(!$admin->save()){
            $this->db->rollback();
            foreach ($admin->getMessages() as $message){
                echo $message;
            }
        }
        $role = new Role();
        $role->name = Scopes::SCOPES_SUPER_USERS;
        $role->description = "管理员";
        $role->isActive = Role::ACTIVE;
        if(!$role->save()){
            $this->db->rollback();
            foreach ($role->getMessages() as $message){
                echo $message;
            }
        }
        $userRole = new UserRole();
        $userRole->userId = $admin->id;
        $userRole->roleId = $role->id;
        if(!$userRole->save()){
            $this->db->rollback();
            foreach ($userRole->getMessages() as $message){
                echo $message;
            }
        }
        $this->db->commit();
        return $this->responseOk();
    }
}