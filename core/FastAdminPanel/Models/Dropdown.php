<?php

namespace App\FastAdminPanel\Models;

use App\FastAdminPanel\Models\File\JsonModel;
use Illuminate\Database\Schema\Blueprint;

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