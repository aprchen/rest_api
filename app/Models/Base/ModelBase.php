<?php

namespace App\Models\Base;

use Phalcon\Mvc\Model;

/**
 * Class ModelBase
 * @package App\Models
 *
 */
class ModelBase extends Model
{
    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(type="datetime", nullable=false)
     */
    public $gmtCreate;
    /**
     *
     * @var integer
     * @Column(type="datetime", nullable=false)
     */
    public $gmtModified;

    public function getSource()
    {
        $arr = explode('\\', get_class($this));
        $string = end($arr);
        $arr = preg_split("/(?=[A-Z])/", $string);
        $string = implode('_', $arr);
        return $this->getDI()->get('config')->database->prefix . strtolower($string);
    }

    public function beforeCreate()
    {
        $this->gmtCreate = date('Y-m-d H:i:s');
        $this->gmtModified = $this->gmtCreate;
    }

    public function beforeUpdate()
    {
        $this->gmtModified = date('Y-m-d H:i:s');
    }
}
