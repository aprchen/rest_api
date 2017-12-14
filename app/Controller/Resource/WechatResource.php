<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/10
 * Time: 下午7:07
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller\Resource;

use App\Component\ApiException;
use App\Constants\ErrorCode;
use App\Controller\ControllerBase;
use App\Models\Wechat;
use App\Transformers\WecahtTransformer;

/**
 * Class UsersResource
 * @package App\Controller\Resource
 * @group(path="/resources/wechat",name='wx_r')
 */
class WechatResource extends ControllerBase
{
    /**
     * @point(path='/',method='post',scopes={super_user})
     */
    public function add()
    {
        $appId = $this->request->getPost('appId', 'string','');
        $token = $this->request->getPost('token','string','');
        $name = $this->request->getPost('name','string','');
        $appSecret = $this->request->getPost('appSecret','string','');
        $aesKey = $this->request->getPost('aesKey','string','');
        $type = $this->request->getPost('type','string','');
        $isActive = $this->request->getPost('isActive','string','');
        $wechat =new Wechat();
        $wechat->aesKey = $aesKey;
        $wechat->appId = $appId;
        $wechat->token = $token;
        $wechat->name = $name;
        $wechat->userId = $this->getUserId();
        $wechat->appSecret = $appSecret;
        $wechat->type = $type;
        $wechat->isActive = $isActive;
        if(!$wechat->save()){
            foreach ($wechat->getMessages() as $message){
                throw new ApiException(ErrorCode::DATA_FAILED,$message);
            }
        }
        return $this->createOkResponse();
    }

    /**
     * @point(path='/',method='get',scopes={super_user})
     */
    public function getAll()
    {
        $data = $this->getUriBuilder(Wechat::class)->getQuery()->execute();
        return $this->createCollectionResponse($data, new WecahtTransformer(),'data');
    }

    /**
     * @point(path='/{id}',method='put',scopes={super_user})
     */
    public function update($id){
        $id = $this->filter->sanitize($id,'int') ?? null;
        if(!$id){
            throw new ApiException(ErrorCode::POST_DATA_INVALID,'id 无效');
        }
        $appId = $this->request->getPost('appId', 'string','');
        $token = $this->request->getPost('token','string','');
        $name = $this->request->getPost('name','string','');
        $appSecret = $this->request->getPost('appSecret','string','');
        $aesKey = $this->request->getPost('aesKey','string','');
        $type = $this->request->getPost('type','string','');
        $isActive = $this->request->getPost('isActive','string','');
        $wechat =Wechat::findFirst([
            'conditions'=>'id = :id:',
            'bind'=>['id'=>$id]
        ]);
        if(!$wechat){
            throw new ApiException(ErrorCode::DATA_NOT_FOUND);
        }
        if($appId){
            $wechat->appId = $appId;
        }
        if($aesKey){
            $wechat->aesKey = $aesKey;
        }
        if($token){
            $wechat->token = $token;
        }
        if($name){
            $wechat->name = $name;
        }
        if(empty($wechat->userId)){
            $wechat->userId = $this->getUserId();
        }
        if($appSecret){
            $wechat->appSecret = $appSecret;
        }
        if($type){
            $wechat->type = $type;
        }
        if($isActive){
            $wechat->isActive = $isActive;
        }
        if(!$wechat->update()){
            foreach ($wechat->getMessages() as $message){
                throw new ApiException(ErrorCode::DATA_FAILED,$message);
            }
        }
        return $this->createOkResponse();
    }
}