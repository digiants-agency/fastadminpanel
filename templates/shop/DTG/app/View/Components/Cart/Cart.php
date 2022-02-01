<?php

namespace App\View\Components\Cart;

use App\Models\Cart\CartHandler;
use Illuminate\View\Component;
use Single;

class Cart extends Component
{
    public $ismodal;
    public $fields;
    public $products;
    public $cartCountProducts;
    public $total;
    public $delivery;

    public function __construct($ismodal = false, $delivery = 0)
    {
        $this->ismodal = $ismodal;

        $s = new Single('Страница товара', 10, 1);
        $currency = $s->field('Карточка товара', 'Валюта', 'text', true, 'грн');

        $s = new Single('Оформление заказа', 10, 4);
        $this->fields = [
            'cart_title'        => $s->field('Корзина', 'Заголовок', 'text', true, 'Корзина'),
            'sum_count_title'   => $s->field('Корзина', 'Стоимость (ед. на сумму)', 'text', true, 'ед. на сумму'),
            'delivery_title'    => $s->field('Корзина', 'Стоимость доставки', 'text', true, 'Стоимость доставки'),
            'total_title'       => $s->field('Корзина', 'Всего', 'text', true, 'Всего'),
            'currency'          => $currency,
        ];


        $cart = new CartHandler();
        $this->products = $cart->products();
        $this->cartCountProducts = $cart->count();
        $this->total = $cart->total();
        $this->delivery = $delivery;
        
    }

    
    public function render()
    {
        return view('components.cart.cart', [
            'fields'            => $this->fields,
            'ismodal'           => $this->ismodal,
            'products'          => $this->products,
            'cartCountProducts' => $this->cartCountProducts,
            'total'             => $this->total,
            'delivery'          => $this->delivery,
        ])->render();
    }
}
