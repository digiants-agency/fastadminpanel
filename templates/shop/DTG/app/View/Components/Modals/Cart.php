<?php

namespace App\View\Components\Modals;

use App\Models\Cart\CartHandler;
use Illuminate\View\Component;
use Single;

class Cart extends Component
{
    public $fields;
    public $total;

    public function __construct()
    {

        $s = new Single('Страница товара', 10, 1);
        $currency = $s->field('Карточка товара', 'Валюта', 'text', true, 'грн');


        $s = new Single('Модальная корзина', 10, 2);

        $this->fields = [
            'to_buy'        => $s->field('Модальная корзина', 'К покупкам', 'text', true, 'К покупкам'),
            'submit_text'   => $s->field('Модальная корзина', 'Оформить заказ', 'text', true, 'Оформить заказ'),
            'currency'      => $currency,
        ];

		$cart = new CartHandler();
        $this->total = $cart->total();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modals.cart');
    }
}
