<?php

namespace App\FastAdminPanel\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

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