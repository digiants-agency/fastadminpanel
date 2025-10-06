<?php

namespace App\FastAdminPanel\Contracts\CrudEntity;

interface InsertOrUpdate
{
    public function save($input);
}
