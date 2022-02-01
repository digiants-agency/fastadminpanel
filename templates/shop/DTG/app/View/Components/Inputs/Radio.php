<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Radio extends Component
{
    public $value;
    public $name;
    public $checked;
    public $title;
    public $description;
    public $price;


    public function __construct($value = '', $name = '', $checked = false, $title = '', $description = '', $price = '')
    {
        $this->value = $value;
        $this->name = $name;
        $this->checked = $checked;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.inputs.radio');
    }
}
