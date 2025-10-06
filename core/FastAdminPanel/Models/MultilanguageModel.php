<?php

namespace App\FastAdminPanel\Models;

use App\FastAdminPanel\Facades\Lang;
use Illuminate\Database\Eloquent\Model;

class MultilanguageModel extends Model
{
    public function __construct($lang = '', $attributes = [])
    {
        if ($lang == '') {

            $lang = Lang::get();
        }

        parent::__construct($attributes);

        $this->table .= '_'.$lang;
    }
}
