<?php

namespace App\View\Components\Inc;

use App\Models\Cart\CartHandler;
use Single;
use Illuminate\View\Component;
use Auth; 

class Header extends Component
{
    public $fields;
    public $is_user_login;
    public $cartCount;

    public function __construct(){

        $s = new Single('Хедер', 10, 2);
        $sc = new Single('Контактная информация', 10, 2);

        $phones = $sc->field('Контактная информация', 'Номера телефона', 'repeat', true);
        $phones_items = [];
        foreach ($phones as $elm){
            $phones_items [] = [
                $elm->field('Номер телефона', 'text', ''), 
            ];
            $elm->end();
        }

        $user = Auth::user();
        $this->is_user_login = false;
        if(!empty($user)){
            $this->is_user_login = true;
        }

        $cart = new CartHandler();
        $this->cartCount = $cart->count();

        $this->fields = [
            'search_text'       => $s->field('Поиск', 'Текст', 'text', true, 'Введите свой запрос'),
            'non_search_text'   => $s->field('Поиск', 'Ничего не найдено', 'text', true, 'По Вашему запросу ничего не найдено!'),
            'phones'            => $phones_items,
            'button_text'       => $s->field('Поиск', 'Кнопка (текст)', 'text', true, 'Заказать дизайн'),
        ];
    }

    public function render(){
        return view('components.inc.header');
    }
}
