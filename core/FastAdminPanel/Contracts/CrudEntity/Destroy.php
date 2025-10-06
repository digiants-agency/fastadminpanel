<?php

namespace App\FastAdminPanel\Contracts\CrudEntity;

interface Destroy
{
    public function destroy($crud, $ids);
}
