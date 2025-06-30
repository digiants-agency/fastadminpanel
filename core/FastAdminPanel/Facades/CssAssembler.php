<?php

namespace App\FastAdminPanel\Facades;

use Illuminate\Support\Facades\Facade;

class CssAssembler extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'cssassembler';
	}
}