<?php

namespace App\Models;

class Role extends ModelBase
{
    const ACTIVE = 1;
    /**
     *
     * @var string
     */
    public $name;

    public $description;

    public $isActive;


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
            'name' => 'name',
            'description' => 'description',
            'is_active' => 'isActive',
            'gmt_create' => 'gmtCreate',
            'gmt_modified' => 'gmtModified'
        );
    }

    public function initialize()
    {
        $this->hasMany(
            'id', 'App\Models\UserRole', 'roleId', array(
            'alias' => 'useRole'
        ));
    }

}
