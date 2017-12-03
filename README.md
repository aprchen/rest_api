# vhome_api
使用 phalcon Micro 搭建 restfuapi
需安装phalcon 扩展 3.2
MIT 协议

路由配置:默认路由参数可以看
```$xslt
/**
 * @group(path="/users")
 */
class UsersController extends ControllerBase
{
}
```
```$xslt
    /**
     * @point(path="/{id}",method ="get")
     */
    public function get($id){
        $res =["hello"];
        return $this->response->setJsonContent($res);
    }
```

对应路由为
对应为
```$xslt
http://localhost/users/{$id}
```
QQ:2639454373