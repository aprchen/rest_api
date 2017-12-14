<?php

namespace App\Transformers;


use App\Models\Wechat;
use App\Transformers\Base\ModelTransformer;

class WecahtTransformer extends ModelTransformer
{
    protected $modelClass = Wechat::class;

}