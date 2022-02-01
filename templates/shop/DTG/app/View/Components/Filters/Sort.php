<?php

namespace App\View\Components\Filters;

use Illuminate\View\Component;
use Single;

class Sort extends Component
{
    public $fields;
    public $sort;

    public function __construct($sort)
    {
        $s = new Single('Каталог', 10, 1);

        $this->sort = $sort;

        $sort = $s->field('Сортировка', 'Сортировка', 'repeat', true);
        $sort_items = [];
        foreach ($sort as $elm){
            $sort_items [] = [
                $elm->field('Название', 'text', ''),
                $elm->field('Ссылка', 'text', ''), 
            ];
            $elm->end();
        }

        $this->fields = [
            'title'         => $s->field('Категории', 'Сортировка', 'text', true, 'Сортировать'),
            'sort_items'   => $sort_items,
        ];
    }

    public function render()
    {
        return view('components.filters.sort', [
            'sort'      => $this->sort,
            'fields'    => $this->fields,
        ])->render();
    }
}
