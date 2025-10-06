<?php

namespace App\FastAdminPanel\Api\Filter;

class StoreCallbacksFilter
{
    public function change($entity, $crud)
    {
        $entity->date = now();
        $entity->save();

        // for example, here you can send the email notification
    }
}
