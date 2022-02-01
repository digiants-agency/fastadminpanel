<?php

namespace App\View\Components\Inc;

use App\FastAdminPanel\Helpers\Platform;
use Illuminate\View\Component;
use Single;

class Horizontal extends Component
{
    public $fields = [];

    public function __construct(){
        
        $s = new Single('Горизонтальная форма', 10, 2);

        $image = $s->field('Горизонтальная форма', 'Изображение {1240x265}', 'photo', false, '/images/horizontal.png');
        $image_mobile = $s->field('Горизонтальная форма', 'Изображение (mobile) {290х318}', 'photo', false, '/images/horizontal.png');


        $this->fields = [
            'title'          => $s->field('Горизонтальная форма', 'Заголовок', 'textarea', true, 'Студия интерьерного дизайна<br>и текстиля "Design Textile Group"'),
            'description'    => $s->field('Горизонтальная форма', 'Описание', 'textarea', true, 'Студия интерьерного текстиля и декора,<br>создаём уют с помошью тканей, цвета и дизайна'),
            'image'          => $image,
            'image_mobile'   => $image_mobile, 
            'input_1'        => $s->field('Горизонтальная форма', 'Ваше имя', 'text', true, 'Ваше имя'),
            'input_2'        => $s->field('Горизонтальная форма', 'Ваш номер телефона', 'text', true, 'Ваш номер телефона'),
            'button_text'    => $s->field('Горизонтальная форма', 'Позвоните мне', 'text', true, 'Позвоните мне'),
            'message_1'      => $s->field('Горизонтальная форма', 'Спасибо', 'text', true, 'Спасибо! Ваша заявка успешно отправлена'),
            'message_2'      => $s->field('Горизонтальная форма', 'Ошибка', 'text', true, 'Ошибка! Ваша заявка не отправлена'),
        ];
    }

    public function render(){
        return view('components.inc.horizontal');
    }
}
