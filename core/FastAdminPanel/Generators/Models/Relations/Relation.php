<?php

namespace App\FastAdminPanel\Generators\Models\Relations;

interface Relation
{
    /**
     * @return string
     */
    public function name();

    /**
     * @return string
     */
    public function body();

    /**
     * @return string
     */
    public function returnType();
}
