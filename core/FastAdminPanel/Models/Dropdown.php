<?php

namespace App\FastAdminPanel\Models;

use App\FastAdminPanel\Models\File\JsonModel;

class Dropdown extends JsonModel
{
    public $timestamps = false;

    protected $table = 'dropdowns';

    protected static $fileName = 'dropdowns';

    protected static $jsonPrimaryKey = 'slug';

    protected $fillable = [
        'slug',
        'title',
        'sort',
        'icon',
    ];
}
