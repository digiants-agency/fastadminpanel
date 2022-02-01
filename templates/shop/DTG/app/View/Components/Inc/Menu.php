<?php

namespace App\View\Components\Inc;

use Illuminate\View\Component;
use App\Models\Category;
use Single;

class Menu extends Component
{
    public $fields;

    public function __construct(Category $category_model){

        $s = new Single('Хедер', 10, 2);

        $menu = $s->field('Меню', 'Меню', 'repeat', true);
        $menu_items = [];
        foreach ($menu as $elm){
            $menu_items [] = [
                $elm->field('Название', 'text', ''), 
                $elm->field('Ссылка', 'text', ''), 
            ];
            $elm->end();
        }

        $categories = $category_model->get_menu_categories();
        $catalog = $category_model->get_catalog();
        
        $this->fields = [
            
            'catalog_title'     => $s->field('Меню', 'Каталог', 'text', true, 'Каталог'),
            'menu'              => $menu_items,
            'categories'        => $categories,
            'catalog'           => $catalog,
        ];
        
    }

    public function render(){
        return view('components.inc.menu');
    }
}
