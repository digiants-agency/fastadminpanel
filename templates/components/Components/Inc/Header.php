<?php

namespace App\View\Components\Inc;

use Single;
use Illuminate\View\Component;

class Header extends Component
{
    public function __construct()
	{

    }

    public function render(){
        return view('components.inc.header');
    }
}
