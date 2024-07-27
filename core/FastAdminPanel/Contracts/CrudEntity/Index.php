<?php

namespace App\FastAdminPanel\Contracts\CrudEntity;

interface Index
{
	public function get($crud, $data);
}