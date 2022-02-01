<?php

namespace App\View\Components\Checkout;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Single;

class CheckoutPersonal extends Component
{
    public $fields;

    public $user;

    public function __construct()
    {
        
        $s = new Single('Оформление заказа', 10, 4);

        $this->fields = [
            'title'     => $s->field('Личная информация', 'Заголовок', 'text', true, 'Личная информация'),
            'label_1'   => $s->field('Личная информация', 'Имя и фамилия (заголовок)', 'text', true, 'Имя и фамилия*'),
            'input_1'   => $s->field('Личная информация', 'Имя и фамилия (поле для ввода)', 'text', true, 'Имя и фамилия'),
            'label_2'   => $s->field('Личная информация', 'Номер телефона (заголовок)', 'text', true, 'Номер телефона*'),
            'input_2'   => $s->field('Личная информация', 'Номер телефона (поле для ввода)', 'text', true, '+380681234567'),
            'label_3'   => $s->field('Личная информация', 'E-mail (заголовок)', 'text', true, 'E-mail для подтверждения заказа*'),
            'input_3'   => $s->field('Личная информация', 'E-mail (поле для ввода)', 'text', true, 'example@gmail.com'),
        ];

        $this->user = Auth::user();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checkout.checkout-personal');
    }
}
