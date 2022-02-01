<?php

namespace App\View\Components\User;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Single;

class UserHistory extends Component
{
    public $fields;
    public $active;

    public $orders;

    public function __construct($active = false)
    {
        $s = new Single('Страница товара', 10, 1);
        $currency = $s->field('Карточка товара', 'Валюта', 'text', true, 'грн');
        $this->active = $active;

        
        $order_model = new Order();

        $orders = $order_model->where('user_email', Auth::user()->email)
        ->orderBy('date', 'DESC')
        ->get()->each(function (&$order) {
            $order->calculate_sum();        
        });

        $this->orders = $orders;

        $s = new Single('Личный кабинет', 10, 1);

        $this->fields = [
            'title'             => $s->field('История покупок', 'Заголовок', 'text', true, 'История покупок'),
            'order_title'       => $s->field('История покупок', 'Заказ (заголовок)', 'text', true, 'Заказ'),
            'sum_title'         => $s->field('История покупок', 'Сумма (заголовок)', 'text', true, 'Сумма'),
            'count_currency'    => $s->field('История покупок', 'шт', 'text', true, 'шт'),
            'delivery_title'    => $s->field('История покупок', 'Способ доставки (заголовок)', 'text', true, 'Способ доставки'),
            'payment_title'     => $s->field('История покупок', 'Способ оплаты', 'text', true, 'Способ оплаты'),
            'address_title'     => $s->field('История покупок', 'Адрес доставки', 'text', true, 'Адрес доставки'),
            'phone_title'       => $s->field('История покупок', 'Номер телефона', 'text', true, 'Номер телефона'),
            'currency'          => $currency,
            'empty'             => $s->field('История покупок', 'Вы еще ничего не купили', 'text', true, 'Вы еще ничего не купили'),

        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.user.user-history', [
            'fields'    => $this->fields,
            'active'    => $this->active,
            'orders'    => $this->orders,
        ])->render();
    }
}
