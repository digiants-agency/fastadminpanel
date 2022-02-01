<?php

namespace App\View\Components\Index;

use App\FastAdminPanel\Helpers\Platform;
use Illuminate\View\Component;
use Single;
use ResizeImg;

class Banner extends Component
{
    public $fields = [];
    public function __construct(){

        $s = new Single('Главная', 10, 1);

        $image = ResizeImg::get($s->field('Баннер', 'Изображение {1440x558}', 'photo', false, '/images/banner1.png'), 2000, 775);
        $image_mobile = ResizeImg::get($s->field('Баннер', 'Изображение (mobile) {320x470}', 'photo', false, '/images/banner1.png'), 640, 940);

        $this->fields = [
            'title'          => $s->field('Баннер', 'Заголовок', 'textarea', true, 'Студия интерьерного дизайна<br>и текстиля "Design Textile Group"'),
            'description'    => $s->field('Баннер', 'Описание', 'textarea', true, 'Студия интерьерного текстиля и декора,<br>создаём уют с помошью тканей, цвета и дизайна'),
            'image'          => $image,
            'image_mobile'   => $image_mobile,
            'button_text'    => $s->field('Баннер', 'Кнопка (текст)', 'text', true, 'Заказать дизайн'),
        ];
    }

    public function render(){
        return view('components.index.banner');
    }
}
