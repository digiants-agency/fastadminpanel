<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Input extends Component
{
    public $placeholder;
    public $type;
    public $class;
    public $textarea;
    public $required;

    public function __construct($placeholder = "", $type = "text", $class="default", $textarea = false, $required = false){

        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->class = $class;
        $this->textarea = $textarea;
        $this->required = $required;

    }


    public function render(){
        
        return view('components.inputs.input');
    }
}
