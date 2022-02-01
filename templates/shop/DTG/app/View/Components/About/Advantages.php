<?php

namespace App\View\Components\About;

use Illuminate\View\Component;
use Single;

class Advantages extends Component
{
    public $fields;

    public function __construct(){
        $s = new Single('О компании', 10, 1);

        $title = $s->field('Наши преимущества', 'Заголовок', 'text', true, 'Наши преимущества');
        $advantages = $s->field('Наши преимущества', 'Наши преимущества', 'repeat', true);
        
        $advantages_items = [];
        foreach ($advantages as $elm){
            $advantages_items [] = [
                $elm->field('Заголовок', 'text', ''), 
                $elm->field('Описание', 'textarea', ''),
                $elm->field('Иконка {50x50}', 'photo', ''),
            ];
            $elm->end();
        }

        $this->fields = [
            'title'         => $title,
            'advantages'    => $advantages_items,
        ];
    }

    public function render(){
        return view('components.about.advantages');
    }
}
