<?php

namespace App\Models;

class UserRole extends ModelBase
{
    /**
     *
     * @var integer
     */
    public $userId;

    public $roleId;



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
            'role_id' => 'roleId',
            'user_id' => 'userId',
            'gmt_create' => 'gmtCreate',
            'gmt_modified' => 'gmtModified'
        );
    }

    public function initialize()
    {
        $this->belongsTo('roleId', 'App\Models\Role', 'id', array('alias' => 'role'));
        $this->belongsTo('userId', 'App\Models\User', 'id', array('alias' => 'user'));
    }

}
