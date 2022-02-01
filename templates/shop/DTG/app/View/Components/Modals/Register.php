<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;
use Single;

class Register extends Component
{
    public $fields;

    public function __construct()
    {
        $s = new Single('Модальные окна (логин)', 10, 2);

        $this->fields = [
            'title'         => $s->field('Зарегистрироваться', 'Заголовок', 'text', true, 'Зарегистрироваться'),
            'input_1'       => $s->field('Зарегистрироваться', 'Имя (поле для ввода)', 'text', true, 'Имя'),
            'input_2'       => $s->field('Зарегистрироваться', 'E-mail (поле для ввода)', 'text', true, 'E-mail'),
            'input_3'       => $s->field('Зарегистрироваться', 'Номер телефона (поле для ввода)', 'text', true, 'Номер телефона'),
            'input_4'       => $s->field('Зарегистрироваться', 'Пароль (поле для ввода)', 'text', true, 'Пароль'),
            'privacy'       => $s->field('Зарегистрироваться', 'Условия использования', 'ckeditor', true, 'Я принимаю Условия использования и Политику конфиденциальности'),
            'button_text'   => $s->field('Зарегистрироваться', 'Текст кнопки', 'text', true, 'Зарегистрироваться'),
            'already_text'  => $s->field('Зарегистрироваться', 'Уже зарегистрированы', 'text', true, 'Уже зарегистрированы?'),
            'login_text'    => $s->field('Зарегистрироваться', 'Войти', 'text', true, 'Войти'),
            'error'         => $s->field('Зарегистрироваться', 'Такой e-mail уже существует', 'text', true, 'Неправильный e-mail или пароль'),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modals.register');
    }
}
