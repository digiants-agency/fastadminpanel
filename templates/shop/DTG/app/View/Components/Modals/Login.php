<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;
use Single;

class Login extends Component
{
    public $fields;

    public function __construct()
    {
        $s = new Single('Модальные окна (логин)', 10, 2);

        $this->fields = [
            'title'         => $s->field('Войти', 'Заголовок', 'text', true, 'Войти'),
            'input_1'       => $s->field('Войти', 'E-mail (поле для ввода)', 'text', true, 'E-mail'),
            'input_2'       => $s->field('Войти', 'Пароль (поле для ввода)', 'text', true, 'Пароль'),
            'privacy'       => $s->field('Войти', 'Условия использования', 'ckeditor', true, 'Я принимаю Условия использования и Политику конфиденциальности'),
            'button_text'   => $s->field('Войти', 'Текст кнопки', 'text', true, 'Войти'),
            'forgot_text'   => $s->field('Войти', 'Забыли пароль', 'text', true, 'Забыли пароль?'),
            'register_text' => $s->field('Войти', 'Зарегистрироваться', 'text', true, 'Зарегистрироваться'),
            'error'         => $s->field('Войти', 'Неправильный e-mail или пароль', 'text', true, 'Неправильный e-mail или пароль'),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modals.login');
    }
}
