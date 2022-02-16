<?php

namespace App\View\Components\Contacts;

use Illuminate\View\Component;
use Single;

class Contacts extends Component
{
    
    public $fields;

    public function __construct(){

        $s = new Single('Контакты', 10, 1); 
        $sc = new Single('Контактная информация', 10, 2);

        $phones = $sc->field('Контактная информация', 'Номера телефона', 'repeat', true);
        $phones_items = [];
        foreach ($phones as $elm){
            $phones_items [] = [
                $elm->field('Номер телефона', 'text', ''), 
            ];
            $elm->end();
        }

        $time = $sc->field('Контактная информация', 'Время работы', 'textarea', true, 'Пн-Вс 9.00-18.00');
        $email = $sc->field('Контактная информация', 'E-mail', 'text', true, 'info@designtextile.com.ua');
        $address = $sc->field('Контактная информация', 'Адрес', 'textarea', true, 'бульвар Перова, 14, г. Киев');
        
        $social = $sc->field('Контактная информация', 'Социальные сети', 'repeat', true);
        $social_items = [];
        foreach ($social as $elm){
            $social_items [] = [
                $elm->field('Ссылка', 'text', ''), 
                $elm->field('Иконка (закрашеная) {32x32}', 'photo', ''), 
                $elm->field('Иконка (маленькая) {15x15}', 'photo', ''), 
                $elm->field('Иконка (разноцветная) {32x32}', 'photo', ''), 
                $elm->field('Название', 'text', ''), 
            ];
            $elm->end();
        }

        $this->fields = [
            'title'         => $s->field('Контакты', 'Заголовок', 'text', true, 'Контакты'),
            'phones'        => $phones_items,
            'time'          => $time,
            'email'         => $email,
            'address'       => $address,
            'social'        => $social_items,
            'form_title'    => $s->field('Форма', 'Заголовок', 'text', true, 'Форма обратной связи'),
            'form_image'    => $s->field('Форма', 'Изображение {903x663}', 'photo', true, '/images/contacts-form.png'),
            'form_input_1'  => $s->field('Форма', 'Ваше имя', 'text', true, 'Ваше имя'),
            'form_input_2'  => $s->field('Форма', 'Ваш номер телефона', 'text', true, 'Форма обратной связи'),
            'form_input_3'  => $s->field('Форма', 'Ваш е-mail', 'text', true, 'Ваш е-mail'),
            'form_input_4'  => $s->field('Форма', 'Сообщение', 'text', true, 'Сообщение'),
            'button_text'   => $s->field('Форма', 'Кнопка (текст)', 'text', true, 'Отправить'),
            'message_1'     => $s->field('Форма', 'Спасибо', 'text', true, 'Спасибо! Ваша заявка успешно отправлена'),
            'message_2'     => $s->field('Форма', 'Ошибка', 'text', true, 'Ошибка! Ваша заявка не отправлена'),
        ];

        

    }

    public function render(){
        return view('components.contacts.contacts');
    }
}
