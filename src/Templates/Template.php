<?php

namespace Digiants\FastAdminPanel\Templates;

abstract class Template
{
    abstract public function import();

    protected function addFolder($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }
}
