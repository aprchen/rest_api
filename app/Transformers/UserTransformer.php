<?php

namespace App\Transformers;

use App\Models\User;
use App\Transformers\Base\ModelTransformer;

class UserTransformer extends ModelTransformer
{
    protected $modelClass = User::class;

    /**
     * @return array
     * 隐藏数据
     */
    protected function excludedProperties()
    {
        return ['password'];
    }

    public function transform($item)
    {
        if ($item == null) {
            return null;
        }
        $result = [];
        $keyMap = $this->keyMap();
        foreach ($this->getResponseProperties() as $property) {
            $fieldName = array_key_exists($property, $keyMap) ? $keyMap[$property] : $property;
            $result[$fieldName] = $this->getFieldValue($item, $property, $fieldName);
        }
        $combinedResult = array_merge($result, $this->additionalFields($item));
        return $combinedResult;
    }

}