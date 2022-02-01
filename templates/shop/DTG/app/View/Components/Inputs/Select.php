<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Select extends Component
{
    public $items;
    public $current;
    public $action;

    public function __construct($items = [], $current = '', $action = ''){

        $this->action = $action; 
        
        $collection_items = collect();

        foreach ($items as $item){
            
            if ($item[1] == $current){
                $this->current = $item[0];
                $item[2] = true;

            } else {
                $item[2] = false;
            }
            
            $collection_items->push([
                'title'     => $item[0],
                'value'     => $item[1],
                'active'    => $item[2],
            ]);
        }

        $this->items = $collection_items;

    }

    public function render()
    {
        return view('components.inputs.select');
    }
}
