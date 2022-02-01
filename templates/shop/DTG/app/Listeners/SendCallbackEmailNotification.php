<?php

namespace App\Listeners;

use App\Events\Callback;
use App\FastAdminPanel\Models\Menu;
use App\Helpers\MailSender;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DB;

class SendCallbackEmailNotification
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
     * @param  Callback  $event
     * @return void
     */
    public function handle(Callback $event)
    {
        $table = $event->callback->getTable();

        $menu = new Menu();
        $titles = $menu->get_titles_menu_by_table($table);
        $fields_titles = $titles['fields_titles'];
        
        $callback_items = $event->callback->toArray();
        $message = '';

        foreach ($fields_titles as $key => $field_title){
            $message .= $field_title.': '.$callback_items[$key].PHP_EOL;
        }

        $mail_sender = new MailSender();
        $mail_sender->send('pa@digiants.com.ua', $titles['menu_title'], $message);

    }
}
