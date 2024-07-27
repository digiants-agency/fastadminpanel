<?php

namespace App\FastAdminPanel\Facades;

use Illuminate\Support\Facades\Facade;

class Platform extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'platform';
	}
}