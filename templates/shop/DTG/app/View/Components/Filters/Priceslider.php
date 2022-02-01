<?php

namespace App\View\Components\Filters;

use Illuminate\View\Component;
use Single;

class Priceslider extends Component
{
    public $minprice;
    public $maxprice;
    public $priceto;
    public $pricefrom;
    public $fields;

    public function __construct($minprice, $maxprice, $pricefrom, $priceto){

        $this->minprice = $minprice;
        $this->maxprice = $maxprice;
        $this->priceto = $priceto;
        $this->pricefrom = $pricefrom;

        $s = new Single('Каталог', 10, 1); 
        $this->fields = [
            'price_title'    => $s->field('Ценовой слайдер', 'Заголовок', 'text', true, 'Цена'),
            'price_from'    => $s->field('Ценовой слайдер', 'От', 'text', true, 'От'),
            'price_to'      => $s->field('Ценовой слайдер', 'До', 'text', true, 'До'),
        ];
    }

    public function render(){
        return view('components.filters.priceslider');
    }
}
