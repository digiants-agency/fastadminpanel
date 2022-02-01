<?php

namespace App\View\Components\Products\ProductDescription;

use Illuminate\View\Component;
use Single;
class Reviews extends Component
{
    public $title;
    public $fields;
    public $product;
    public function __construct($title = '', $product = []){

        $this->title = $title;
        $this->product = $product;

        $s = new Single('Страница товара', 10, 1);

        $this->fields = [
            'button_text'     => $s->field('Отзывы', 'Кнопка Показать больше (текст)', 'text', true, 'Показать больше'),
        ];

    }

    public function render(){
        return view('components.products.product-description.reviews');
    }
}
