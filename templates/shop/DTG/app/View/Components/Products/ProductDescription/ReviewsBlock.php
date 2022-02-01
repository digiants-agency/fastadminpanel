<?php

namespace App\View\Components\Products\ProductDescription;

use Illuminate\View\Component;
use Single;

class ReviewsBlock extends Component
{
    public $fields;
    public $reviews;

    public function __construct($reviews = []){

        $this->reviews = $reviews;

        $s = new Single('Страница товара', 10, 1);

        $this->fields = [
            'review_answer'     => $s->field('Отзывы', 'Ответ от собственника', 'text', true, 'Ответ от собственника'),
            'reviews_none'     => $s->field('Отзывы', 'Отзывов пока нет', 'text', true, 'Отзывов пока нет. Вы можете оставить отзыв первым.'),
        ];
    }

    public function render(){
        return view('components.products.product-description.reviews-block',[
            'fields'    => $this->fields,
            'reviews'   => $this->reviews,
        ])->render();
    }
}
