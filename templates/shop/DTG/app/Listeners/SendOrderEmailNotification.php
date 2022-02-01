<?php

namespace App\Listeners;

use App\Events\Order;
use App\FastAdminPanel\Models\Menu;
use App\Helpers\MailSender;
use App\Models\Delivery;
use App\Models\Order as ModelsOrder;
use App\Models\OrderProducts;
use App\Models\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DB;

class SendOrderEmailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Order  $event
     * @return void
     */
    public function handle(Order $event)
    {

        $order_model = new ModelsOrder();
        $order_table = $order_model->getTable();
        
        $menu = new Menu();
        $titles = $menu->get_titles_menu_by_table($order_table);
        $fields_titles = $titles['fields_titles'];
        $subject = $titles['menu_title'];

        $order_items = $event->order->toArray();
        
        $message = '';
        foreach ($fields_titles as $key => $field_title){

            if ($key != 'delivery' && $key != 'payment' && $key != 'users' && $key != 'orders_status' && $key != 'orders_product'){

                if ($order_items[$key] === 0)
                    $order_items[$key] = 'нет';
                elseif ($order_items[$key] === 1)
                    $order_items[$key] = 'да';
            }

            if ($key == 'delivery'){
                $order_items[$key] = $event->order->delivery->title;
            }

            if ($key == 'payment'){
                $order_items[$key] = $event->order->payment->title;
            }

            if ($key != 'users' && $key != 'orders_status' && $key != 'orders_product')
                $message .= $field_title.': '.$order_items[$key].PHP_EOL;
        }

        $message .= PHP_EOL.PHP_EOL;

        $order_products_model = new OrderProducts();
        $order_products_table = $order_products_model->getTable();
        

        $menu = new Menu();
        $titles = $menu->get_titles_menu_by_table($order_products_table);
        $fields_titles = $titles['fields_titles'];

        $order_products_items = $event->order_products;
        $message .= 'Товары:'.PHP_EOL;

        foreach ($order_products_items as $order_product){

            foreach ($fields_titles as $key => $field_title){

                if ($key == 'slug'){
                    $order_product[$key] = route('product', $order_product[$key], true);
                }

                if ($key != 'image')
                    $message .= $field_title.': '.$order_product[$key].PHP_EOL;

            }

            $message .= PHP_EOL;
        }

        $event->order->calculate_sum();
        
        $message .= 'Сума: '.$event->order->sum;

        $mail_sender = new MailSender();
        $mail_sender->send('pa@digiants.com.ua', $subject, $message);

    }
}
