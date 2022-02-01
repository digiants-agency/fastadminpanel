<?php

namespace App\View\Components\Filters;

use Illuminate\View\Component;
use Single;

class Filters extends Component
{
    public $fields;
    public $filters;
    public $link;
    public $minprice;
    public $maxprice;
    public $pricefrom;
    public $priceto;
    

    public function __construct($filters = [], $link = '', $minprice = 0, $maxprice = 1000, $pricefrom = 0, $priceto = 1000){

        $this->filters = $filters; 
        $this->link = $link;
        $this->minprice = $minprice;
        $this->maxprice = $maxprice;
        $this->pricefrom = $pricefrom;
        $this->priceto = $priceto;

        $s = new Single('Каталог', 10, 1); 
        $this->fields = [
            'clear_filters' => $s->field('Каталог', 'Сбросить все', 'text', true, 'Сбросить все'),
            'filter_title' => $s->field('Каталог', 'Фильтр', 'text', true, 'Фильтр'),
        ];
    }

    public function render(){
        return view('components.filters.filters', [
            'filters'   => $this->filters,
            'link'      => $this->link,
            'minprice'  => $this->minprice,
            'maxprice'  => $this->maxprice,
            'pricefrom' => $this->pricefrom,
            'priceto'   => $this->priceto,
            'fields'    => $this->fields,
        ])->render();
    }
}
