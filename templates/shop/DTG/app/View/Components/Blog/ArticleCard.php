<?php

namespace App\View\Components\Blog;

use Illuminate\View\Component;
use Single;

class ArticleCard extends Component
{
    public $fields;
    public $article;

    public function __construct($article = []){
        
        $this->article = $article;

        $s = new Single('Блог', 10, 1);
        $this->fields = [
            'button_text'   => $s->field('Карточка статьи', 'Кнопка (текст)', 'text', true, 'Читать полностью'),
        ];
    }

    public function render(){
        return view('components.blog.article-card');
    }
}
