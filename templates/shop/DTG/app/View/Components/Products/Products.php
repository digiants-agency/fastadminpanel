<?php

namespace App\View\Components\Products;

use Illuminate\View\Component;
use Single;

class Products extends Component
{
    
    public $row;
    public $products;
    public $fields;

    public function __construct($row = 3, $products = []){
        
        $s = new Single('Каталог', 10, 1);
        $this->fields = [
            'none_products'     => $s->field('Каталог', 'Товаров не найдено', 'text', true, 'Товаров не найдено'),
        ];

        $this->row = intval($row);
        $this->products = $products;
    }


    public function render(){

        return view('components.products.products', [
            'row'           => $this->row,
            'products'      => $this->products,
            'fields'        => $this->fields,
        ])->render();
    }
}
