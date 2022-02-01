<?php

namespace App\View\Components\Categories;

use App\Models\Category;
use Illuminate\View\Component;
use Single;

class Categories extends Component
{
    public $button;
    public $page;
    public $fields = [];
    public $categories;   

    public function __construct($button = false, $page = false, Category $category_model){

        $this->button = $button;
        $this->page = $page;
        
        $this->categories = $category_model->get_catalog();

        $s = new Single('Каталог', 10, 1);
        $this->fields = [
            'title'          => $s->field('Категории', 'Заголовок', 'text', true, 'Каталог товаров'),
            'description'    => $s->field('Категории', 'Описание', 'textarea', true, 'Эксклюзивные шторы на люверсах станут удачным дополнением к фактически любому дизайну. Они выглядят современно и интересно. Дизайнеры текстиля уверены, что такие гардины будут выглядеть практично, эстетично и привлекательно. '),
            'button_text'    => $s->field('Категории', 'Кнопка (текст)', 'text', true, 'Перейти в каталог'),
            'button_link'    => $s->field('Категории', 'Кнопка (ссылка)', 'text', false, '/catalog'),
        ];
    }

    public function render(){
        return view('components.categories.categories');
    }
}
