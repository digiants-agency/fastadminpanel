<?php

namespace App\FastAdminPanel\Services\Api;

class CustomFilter
{
    public function filter($entity, $method, $crud)
    {
        $method = ucfirst($method);
        $tableName = ucfirst($crud->table_name);

        $filterClass = "\App\FastAdminPanel\Api\Filter\\{$method}{$tableName}Filter";

        if (! class_exists($filterClass)) {

            return;
        }

        $filter = app()->make($filterClass);

        $filter->change($entity, $crud);
    }
}
