<?php

namespace App\View\Components\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Single;

class UserInfo extends Component
{

    public $fields;

    public $user;
    public $active;

    public function __construct($active = false)
    {
        $s = new Single('Личный кабинет', 10, 1);

        $this->user = Auth::user();

        $this->active = $active;

        $this->fields = [
            'title'         => $s->field('Личная информация', 'Заголовок', 'text', true, 'Личная информация'),
            'label_1'       => $s->field('Личная информация', 'Имя (заголовок)', 'text', true, 'Имя*'),
            'input_1'       => $s->field('Личная информация', 'Имя (поле для ввода)', 'text', true, 'Ваше имя'),
            'label_2'       => $s->field('Личная информация', 'Фамилия (заголовок)', 'text', true, 'Фамилия*'),
            'input_2'       => $s->field('Личная информация', 'Фамилия (поле для ввода)', 'text', true, 'Ваша фамилия'),
            'label_3'       => $s->field('Личная информация', 'Отображаемое имя (заголовок)', 'text', true, 'Отображаемое имя*'),
            'input_3'       => $s->field('Личная информация', 'Отображаемое имя (поле для ввода)', 'text', true, 'example'),
            'remark_3'      => $s->field('Личная информация', 'Отображаемое имя (сноска)', 'text', true, 'Так ваше имя будет отображаться на сайте'),
            'label_4'       => $s->field('Личная информация', 'E-mail (заголовок)', 'text', true, 'E-mail*'),
            'input_4'       => $s->field('Личная информация', 'E-mail (поле для ввода)', 'text', true, 'example@gmail.com'),
            'label_5'       => $s->field('Личная информация', 'Номер телефона (заголовок)', 'text', true, 'Номер телефона*'),
            'input_5'       => $s->field('Личная информация', 'Номер телефона (поле для ввода)', 'text', true, '+380681234567'),
            'label_6'       => $s->field('Личная информация', 'Новый пароль (заголовок)', 'text', true, 'Новый пароль'),
            'input_6'       => $s->field('Личная информация', 'Новый пароль (поле для ввода)', 'text', true, ''),
            'remark_6'      => $s->field('Личная информация', 'Новый пароль (сноска)', 'text', true, 'Не заполняйте, чтобы оставить прежний'),
            'label_7'       => $s->field('Личная информация', 'Подтвердите новый пароль (заголовок)', 'text', true, 'Подтвердите новый пароль'),
            'input_7'       => $s->field('Личная информация', 'Подтвердите новый пароль (поле для ввода)', 'text', true, ''),
            'button_text'   => $s->field('Личная информация', 'Кнопка (текст)', 'text', true, 'Сохранить'),
            'message_1'     => $s->field('Личная информация', 'Сообщение (успешно)', 'text', true, 'Ваши данные успешно сохранены'),
            'message_2'     => $s->field('Личная информация', 'Сообщение (неуспешно)', 'text', true, 'Ваши данные не сохранены'),
            
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.user.user-info', [
            'user'      => $this->user,
            'active'    => $this->active,
            'fields'    => $this->fields,
        ])->render();
    }
}
