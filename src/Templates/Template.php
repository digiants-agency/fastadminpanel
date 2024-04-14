<?php

namespace Digiants\FastAdminPanel\Templates;

class Template
{	
    protected function addFolder($path)
	{
		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}
	}
}