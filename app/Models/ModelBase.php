<?php

namespace App\Models;

use Phalcon\Mvc\Model;

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
        $this->createdAt = time();
        $this->updatedAt = $this->createdAt;
    }

    public function beforeUpdate()
    {
        $this->updatedAt = time();
    }


}
