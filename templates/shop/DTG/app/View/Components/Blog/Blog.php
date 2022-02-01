<?php

namespace App\View\Components\Blog;

use Illuminate\View\Component;
use Single;

class Blog extends Component
{
    public $index;
    public $fields;
    public $title;
    public $articles;

    public function __construct($articles = [], $index = false, $title = ''){

        $this->index = $index;
        $this->title = $title;
        $this->articles = $articles;

        $s = new Single('Блог', 10, 1);
        $this->fields = [
            'title'          => $s->field('Блог', 'Заголовок', 'textarea', true, 'Статьи'),
        ];
    }

    
    public function render(){
        
        return view('components.blog.blog', [
            'fields'    => $this->fields,
            'articles'  => $this->articles,
            'index'     => $this->index
        ])->render();
    }
}
