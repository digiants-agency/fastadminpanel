<?php

namespace App\View\Components\Index;

use App\FastAdminPanel\Helpers\Platform;
use Illuminate\View\Component;
use Single;

class HorizontalBanner extends Component
{
    public $fields = [];
    
    public function __construct(){

        $s = new Single('Оплата частями', 10, 2);
        
        $image = $s->field('Оплата частями', 'Изображение {1240x265}', 'photo', false, '/images/horizontal-payment.png');
        $image_mobile = $s->field('Оплата частями', 'Изображение (mobile) {290х318}', 'photo', false, '/images/horizontal-payment.png');

        $this->fields = [
            'title'          => $s->field('Оплата частями', 'Заголовок', 'text', true, 'Оплата частями'),
            'description'    => $s->field('Оплата частями', 'Описание', 'textarea', true, 'Дизайнерские шторы в рассрочку без переплат!'),
            'image'          => $image,
            'image_mobile'   => $image_mobile,
            'button_text'    => $s->field('Оплата частями', 'Кнопка (текст)', 'text', true, 'Побробнее'),
            'button_link'    => $s->field('Оплата частями', 'Кнопка (ссылка)', 'text', false, '/about'),
        ];
    }

    public function render(){
        return view('components.index.horizontal-banner');
    }
}
