<?php

namespace App\View\Components\Products\ProductDescription;

use Illuminate\View\Component;
use Single;

class ReviewsForm extends Component
{
    public $fields;
    public $id;

    public function __construct($id = 0){

        $this->id = $id;

        $s = new Single('Страница товара', 10, 1);

        $this->fields = [
            'title'         => $s->field('Отзывы (форма)', 'Заголовок', 'text', true, 'Оставить отзыв'),
            'description'   => $s->field('Отзывы (форма)', 'Описание', 'text', true, 'Нам будет приятно услышать ваше мнение'),
            'form_input_1'  => $s->field('Отзывы (форма)', 'Ваше имя', 'text', true, 'Ваше имя'),
            'form_input_2'  => $s->field('Отзывы (форма)', 'Ваш номер телефона', 'text', true, 'Ваш номер телефона'),
            'form_input_3'  => $s->field('Отзывы (форма)', 'Ваш е-mail', 'text', true, 'Ваш е-mail'),
            'form_input_4'  => $s->field('Отзывы (форма)', 'Ваш отзыв', 'text', true, 'Ваш отзыв'),
            'button_text'   => $s->field('Отзывы (форма)', 'Кнопка (текст)', 'text', true, 'Отправить'),
            'message_1'     => $s->field('Отзывы (форма)', 'Спасибо', 'text', true, 'Спасибо! Ваша заявка успешно отправлена'),
            'message_2'     => $s->field('Отзывы (форма)', 'Ошибка', 'text', true, 'Ошибка! Ваша заявка не отправлена'),
            'actual_link'   => url()->current(), 
        ];
    }


    public function render(){
        return view('components.products.product-description.reviews-form');
    }
}
