<?php

namespace App\View\Components\Products;

use Illuminate\View\Component;
use Single;

class ProductInfo extends Component
{
    public $fields;
    public $product;

    public function __construct($product = []){

        $this->product = $product;

        $s = new Single('Страница товара', 10, 1);

        $this->fields = [
            'available'     => $s->field('Информация', 'В наличии', 'text', true, 'В наличии'),
            'not_available' => $s->field('Информация', 'Не в наличии', 'text', true, 'Не в наличии'),
            'button_text'   => $s->field('Информация', 'Кнопка заказать (текст)', 'text', true, 'Заказать'),
            'from'          => $s->field('Карточка товара', 'От', 'text', true, 'от'),
            'currency'      => $s->field('Карточка товара', 'Валюта', 'text', true, 'грн/м²'),
        ];
    }

    public function render(){
        return view('components.products.product-info');
    }
}
