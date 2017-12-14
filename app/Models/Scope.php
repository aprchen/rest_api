<?php

namespace App\Models;

use App\Models\Base\ModelBase;

class Scope extends ModelBase
{

    public $name;

    public $description;

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
            'gmt_create' => 'gmtCreate',
            'gmt_modified' => 'gmtModified'
        );
    }

    public function initialize()
    {

    }

}
