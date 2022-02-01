<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;
use Single;

class Callback extends Component
{
    public $actual_link;
    public $fields;

    public function __construct(){

        $this->actual_link = request()->fullUrl();

        $s = new Single('Модальное окно', 10, 2);
        
        $this->fields = [
            'title'         => $s->field('Модальное окно', 'Заголовок', 'text', true, 'Заказать'),
            'description'   => $s->field('Модальное окно', 'Описание', 'textarea', true, 'Оставьте свои данные и наш менеджер свяжется с вами для уточнения деталей заказа'),
            'modal_input_1' => $s->field('Модальное окно', 'Ваше имя', 'text', true, 'Ваше имя'),
            'modal_input_2' => $s->field('Модальное окно', 'Ваш номер телефона', 'text', true, 'Ваш номер телефона'),
            'modal_input_3' => $s->field('Модальное окно', 'Ваш комментарий', 'text', true, 'Ваш комментарий'),
            'button_text'   => $s->field('Модальное окно', 'Кнопка (текст)', 'text', true, 'Заказать'),
            'message_1'     => $s->field('Модальное окно', 'Спасибо', 'text', true, 'Спасибо! Ваша заявка успешно отправлена'),
            'message_2'     => $s->field('Модальное окно', 'Ошибка', 'text', true, 'Ошибка! Ваша заявка не отправлена'),
        ];
    }

    public function render(){
        return view('components.modals.callback');
    }
}
