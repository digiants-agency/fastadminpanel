<?php

namespace App\View\Components\Checkout;

use App\Models\Payment;
use Illuminate\View\Component;
use Single;

class CheckoutPayment extends Component
{
    public $fields;
    public $payment;

    public function __construct(Payment $payment_model)
    {
        $s = new Single('Оформление заказа', 10, 4);

        $this->payment = $payment_model->orderBy('sort', 'DESC')
        ->get();

        $this->fields = [
            'title'     => $s->field('Способ оплаты', 'Заголовок', 'text', true, 'Способ оплаты'),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checkout.checkout-payment');
    }
}
