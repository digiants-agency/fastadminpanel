<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\MultilanguageModel;
use Lang;
use DB;

class AttributesCounter extends MultilanguageModel
{
    protected $table = 'attributes_counter';

}
