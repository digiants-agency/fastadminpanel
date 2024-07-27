<?php

namespace App\FastAdminPanel\Casts;

use App\FastAdminPanel\Casts\Entities\Field;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Fields implements CastsAttributes
{
	public function convert($array)
	{
		return collect($array)->map(fn ($field) => new Field($field));
	}

	public function get($model, $key, $value, $attributes)
	{
		return $this->convert(json_decode($value, true));
	}

	public function set($model, $key, $value, $attributes)
	{
		return json_encode($value);
	}
}