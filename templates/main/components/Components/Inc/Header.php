<?php

namespace App\View\Components\Inc;

use Single;
use Illuminate\View\Component;

class Header extends Component
{
    // public $fields;

    public function __construct(){

        // $s = new Single('Хедер', 10, 2);

        // $this->fields = [
        //     'search_text'       => $s->field('Поиск', 'Текст', 'text', true, 'Введите свой запрос'),
        // ];
    }

    public function render(){
        return view('components.inc.header');
    }
}
