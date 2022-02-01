<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;
use Single;

class Forgot extends Component
{
    public $fields;

    public function __construct()
    {
        $s = new Single('Модальные окна (логин)', 10, 2);

        $this->fields = [
            'title'                 => $s->field('Восстановить пароль', 'Заголовок', 'text', true, 'Восстановить пароль'),
            
            'form_1_description'    => $s->field('Восстановить пароль', 'Описание №1', 'textarea', true, 'Введите адрес электронной почты чтобы восстановить пароль. Вы получите письмо с инструкциями.'),
            'form_1_input'          => $s->field('Восстановить пароль', 'E-mail (поле для ввода)', 'text', true, 'E-mail'),
            'form_1_button_text'    => $s->field('Восстановить пароль', 'Текст кнопки #1', 'text', true, 'Отправить'),
            'form_1_error'          => $s->field('Восстановить пароль', 'E-mail не существует', 'text', true, 'E-mail не существует, зарегестрируйтесь'),

            'form_2_description'    => $s->field('Восстановить пароль', 'Описание №2', 'textarea', true, 'Введите полученный код:'),
            'form_2_input'          => $s->field('Восстановить пароль', 'Код (поле для ввода)', 'text', true, 'Код'),
            'form_2_button_text'    => $s->field('Восстановить пароль', 'Текст кнопки #2', 'text', true, 'Отправить'),
            'form_2_error'          => $s->field('Восстановить пароль', 'Неправильный код', 'text', true, 'Неправильный код'),
            
            'form_3_input_1'        => $s->field('Восстановить пароль', 'Новый пароль (поле для ввода)', 'text', true, 'Новый пароль'),
            'form_3_input_2'        => $s->field('Восстановить пароль', 'Повторите пароль (поле для ввода)', 'text', true, 'Повторите пароль'),
            'form_3_button_text'    => $s->field('Восстановить пароль', 'Текст кнопки #3', 'text', true, 'Отправить'),
            'form_3_error'          => $s->field('Восстановить пароль', 'Пароли не совадают', 'text', true, 'Пароли не совадают'),

            'login_text'            => $s->field('Восстановить пароль', 'Войти', 'text', true, 'Войти'),
            'register_text'         => $s->field('Восстановить пароль', 'Зарегистрироваться', 'text', true, 'Зарегистрироваться'),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modals.forgot');
    }
}
