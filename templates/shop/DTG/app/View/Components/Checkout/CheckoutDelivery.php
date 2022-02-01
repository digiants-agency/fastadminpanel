<?php

namespace App\View\Components\Checkout;

use Illuminate\View\Component;
use Single;

class CheckoutDelivery extends Component
{
    public $fields;

    public function __construct()
    {
        $s = new Single('Оформление заказа', 10, 4);

        $this->fields = [
            'title'     => $s->field('Адрес доставки', 'Заголовок', 'text', true, 'Адрес доставки'),
            'label_1'   => $s->field('Адрес доставки', 'Город (заголовок)', 'text', true, 'Город*'),
            'input_1'   => $s->field('Адрес доставки', 'Город (поле для ввода)', 'text', true, 'Город'),
            'label_2'   => $s->field('Адрес доставки', 'Область (заголовок)', 'text', true, 'Область*'),
            'input_2'   => $s->field('Адрес доставки', 'Область (поле для ввода)', 'text', true, 'Область'),
        ];
    }

    
    public function render()
    {
        return view('components.checkout.checkout-delivery');
    }
}
