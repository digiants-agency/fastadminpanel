<?php

namespace App\View\Components\Products;

use Illuminate\View\Component;
use Single;

class ProductCard extends Component
{
    
    public $product;
    public $fields;

    public function __construct($product = []){
        $this->product = $product;

        $s = new Single('Страница товара', 10, 1);

        $this->fields = [
            'from'          => $s->field('Карточка товара', 'От', 'text', true, 'от'),
            'currency'      => $s->field('Карточка товара', 'Валюта', 'text', true, 'грн/м²'),
            'button_more'   => $s->field('Карточка товара', 'Кнопка Детальнее (текст)', 'text', true, 'Детальнее'),
            'button_order'  => $s->field('Карточка товара', 'Кнопка Заказать (текст) ', 'text', true, 'Заказать'),
            'not_available' => $s->field('Информация', 'Не в наличии', 'text', true, 'Не в наличии'),
        ];
    }

    public function render(){
        return view('components.products.product-card');
    }
}
