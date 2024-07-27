<?php

namespace App\FastAdminPanel\Models;

use Illuminate\Database\Eloquent\Model;

class SinglePage extends Model
{
	public $timestamps = false;

	protected $table = 'single_pages';

	protected $fillable = [
		'title',
		'slug',
		'sort',
		'icon',
		'dropdown_slug',
	];

	public function blocks()
	{
		return $this->hasMany(SingleBlock::class, 'single_page_id');
	}
}