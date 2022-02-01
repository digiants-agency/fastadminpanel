<?php

namespace App\View\Components\Errors;

use Illuminate\View\Component;
use Single;

class Error404 extends Component
{
    public $fields;

    public function __construct(){

        $s = new Single('404', 10, 2);
        $this->fields = [
            'image'             => $s->field('404', 'Изображение {564x315}', 'photo', false, '/images/404.png'),
            'text'              => $s->field('404', 'Текст', 'text', true, 'Извините, страница не найдена'),
            'button_text'       => $s->field('404', 'Кнопка (текст)', 'text', true, 'На главную'),
            'button_link'       => $s->field('404', 'Кнопка (ссылка)', 'text', true, '/'),
            
        ];
    }

    public function render(){
        return view('components.errors.error404');
    }
}
