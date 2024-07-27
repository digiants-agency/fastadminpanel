<?php

namespace App\FastAdminPanel\Contracts\CrudEntity;

interface Copy
{
	public function copy($crud, $entityId);
}