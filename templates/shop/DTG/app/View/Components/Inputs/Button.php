<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Button extends Component
{
   
    public $type;
    public $size;
    public $href;
    public $action;

    public function __construct($type = "default", $href = "", $size = "normal", $action = ''){

        $types = explode(' ', $type);
        foreach ($types as &$item){
            $item = 'btn-'.$item;
        }
        
        $this->type = implode(' ', $types);
        $this->href = $href;
        $this->size = $size;
        $this->action = $action;

    }

    public function render(){

        return view('components.inputs.button');
    }
}
