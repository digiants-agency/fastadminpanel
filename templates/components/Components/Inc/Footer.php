<?php

namespace App\View\Components\Inc;

use Illuminate\View\Component;

class Footer extends Component
{
    public function __construct()
	{

    }

    public function render()
	{
        return view('components.inc.footer');
    }
}
