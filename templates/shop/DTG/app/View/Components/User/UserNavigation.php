<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use Single;

class UserNavigation extends Component
{
    public $fields;
    public $route;

    public function __construct($route = 'user')
    {
        $s = new Single('Личный кабинет', 10, 1);

        $this->route = $route;

        $this->fields = [
            'nav_item_1'    => $s->field('Личная информация', 'Меню (заголовок)', 'text', true, 'Личные данные'),
            'nav_item_2'    => $s->field('История покупок', 'Меню (заголовок)', 'text', true, 'История покупок'),
            'nav_item_3'    => $s->field('Ваш список желаний', 'Меню (заголовок)', 'text', true, 'Избранное'),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.user.user-navigation', [
            'fields'    => $this->fields,
            'route'     => $this->route,
        ])->render();
    }
}
