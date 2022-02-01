<?php

namespace App\View\Components\Inc;

use Illuminate\View\Component;

class Content extends Component
{
    public $type;

    public function __construct($type = "default"){
        $this->type = $type;
    }

    
    public function render(){
        return view('components.inc.content');
    }
}
