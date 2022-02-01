<?php

namespace App\View\Components\Elements;

use Illuminate\View\Component;
use Single;

class FilterButton extends Component
{
    public $count;
    public $fields;

    public function __construct($count = 0)
    {
        $this->count = $count;
        
        $s = new Single('Каталог', 10, 1);
        $this->fields = [
            'filter_title' => $s->field('Каталог', 'Фильтр', 'text', true, 'Фильтр'),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.elements.filter-button');
    }
}
