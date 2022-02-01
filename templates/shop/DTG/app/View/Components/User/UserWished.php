<?php

namespace App\View\Components\User;

use App\Models\Product;
use App\Models\Saved\SavedHandler;
use Illuminate\View\Component;
use Single;

class UserWished extends Component
{
    public $fields;
    public $active;
    public $saved;

    public function __construct($active = false)
    {
        $s = new Single('Страница товара', 10, 1);
        $currency = $s->field('Карточка товара', 'Валюта', 'text', true, 'грн');
        $this->active = $active;

        $saved_model = new SavedHandler();
        $product_model = new Product();
        
        $products_ids = $saved_model->get();

        $this->saved = $product_model->whereIn('id', $products_ids->pluck('id_products'))->get();

        $s = new Single('Личный кабинет', 10, 1);

        $this->fields = [
            'title'             => $s->field('Ваш список желаний', 'Заголовок', 'text', true, 'Ваш список желаний'),
            'empty'             => $s->field('Ваш список желаний', 'Вы еще ничего не добавили', 'text', true, 'Вы еще ничего не добавили'),
            'clear_title'       => $s->field('Ваш список желаний', 'Очистить', 'text', true, 'Очистить'),
            'currency'          => $currency,
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.user.user-wished', [
            'fields'    => $this->fields,
            'active'    => $this->active,
            'saved'     => $this->saved,
        ])->render();
    }
}
