<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:41
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller;

use App\Component\Auth\Manager;
use App\Component\Auth\TokenParsers\JWTTokenParser;
use App\Component\Http\Request;
use App\Component\Http\Response;
use App\Constants\Services;
use App\Fractal\Query\QueryParsers\PhqlQueryParser;
use App\Fractal\Query\QueryParsers\UrlQueryParser;
use App\User\Service;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Phalcon\Cache\Backend\Redis;
use Phalcon\Config;
use Phalcon\Mvc\Controller;

/**
 *
 * Class ControllerBase
 *
 * @package App\Component\Core
 * @property Request $request
 * @property Response $response
 * @property JWTTokenParser $tokenParser
 * @property Manager $authManager
 * @property Config $config
 * @property Service $userService
 * @property phqlQueryParser $phqlQueryParser
 * @property urlQueryParser $urlQueryParser
 * @property Redis $redis
 *
 */
class ControllerBase extends Controller
{
    /**
     * @param $model
     * @param string $primaryKey
     * @return \Phalcon\Mvc\Model\Query\Builder
     * $this->getUriBuilder(User::class,'')->getQuery()->execute()
     */
    public function getUriBuilder($model, $primaryKey = '')
    {
        $query = $this->request->getQuery();
        $arr = $this->urlQueryParser->createQuery($query);
        $builder = $this->phqlQueryParser->fromQuery($arr, $model, $primaryKey);

        return $builder;
    }


    /** @var \League\Fractal\Manager */
    protected $fractal;

    public function onConstruct()
    {
        $this->fractal = $this->di->get(Services::FRACTAL_MANAGER);
    }

    protected function getUser()
    {
        return $this->userService->getDetails();
    }

    protected function getUserId()
    {
        return (int)$this->userService->getIdentity();
    }

    protected function createArrayResponse($array, $key)
    {
        $response = [$key => $array];

        return $this->createResponse($response);
    }

    protected function createResponse($response)
    {
        return $response;
    }

    protected function createOkResponse()
    {
        $response = ['result' => 'OK'];

        return $this->createResponse($response);
    }

    protected function createItemOkResponse($item, $transformer, $resourceKey = null, $meta = null)
    {
        $response = ['result' => 'OK'];
        $response += $this->createItemResponse($item, $transformer, $resourceKey, $meta);

        return $this->createResponse($response);
    }

    protected function createItemResponse($item, $transformer, $resourceKey = null, $meta = null)
    {
        $resource = new Item($item, $transformer, $resourceKey);
        $data = $this->fractal->createData($resource)->toArray();
        $response = array_merge($data, $meta ? $meta : []);

        return $this->createResponse($response);
    }

    protected function createCollectionResponse($collection, $transformer, $resourceKey = null, $meta = null)
    {
        $resource = new Collection($collection, $transformer, $resourceKey);
        $data = $this->fractal->createData($resource)->toArray();
        $response = array_merge($data, $meta ? $meta : []);

        return $this->createResponse($response);
    }
}