<?php

namespace App\View\Components\Products;

use Illuminate\View\Component;
use Single;

class ProductDescription extends Component
{
    public $fields;
    public $product;

    public function __construct($product = []){

        $this->product = $product;

        $s = new Single('Страница товара', 10, 1);

        $this->fields = [
            'characteristics_title'     => $s->field('Информация', 'Заголовок Характеристики', 'text', true, 'Характеристики'),
            'description_title'         => $s->field('Информация', 'Заголовок Описание', 'text', true, 'Описание'),
            'reviews_title'             => $s->field('Информация', 'Заголовок Отзывы', 'text', true, 'Отзывы'),
        ];
    }

    public function render(){
        return view('components.products.product-description');
    }
}
