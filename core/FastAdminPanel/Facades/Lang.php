<?php

namespace App\FastAdminPanel\Facades;

use Illuminate\Support\Facades\Facade;

class Lang extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'lang';
    }
}
