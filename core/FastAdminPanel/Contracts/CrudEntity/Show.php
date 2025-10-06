<?php

namespace App\FastAdminPanel\Contracts\CrudEntity;

interface Show
{
    public function get($tableName, $entityId);
}
