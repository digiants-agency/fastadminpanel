<?php

namespace App\View\Components\Checkout;

use App\Models\Delivery;
use Illuminate\View\Component;
use Single;

class CheckoutTypeDelivery extends Component
{
    public $fields;
    public $delivery;

    public function __construct(Delivery $delivery_model)
    {
        $s = new Single('Оформление заказа', 10, 4);

        $this->delivery = $delivery_model->orderBy('sort', 'DESC')
        ->get();

        $this->fields = [
            'title'     => $s->field('Способ доставки', 'Заголовок', 'text', true, 'Способ доставки'),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checkout.checkout-type-delivery');
    }
}
