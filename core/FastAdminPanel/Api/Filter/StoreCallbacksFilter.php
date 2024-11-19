<?php

namespace App\FastAdminPanel\Api\Filter;

use Illuminate\Http\Request;

class StoreCallbacksFilter
{
	public function change($entity, $crud)
	{
		$entity->date = now();
		$entity->save();

		// for example, here you can send the email notification
	}
}