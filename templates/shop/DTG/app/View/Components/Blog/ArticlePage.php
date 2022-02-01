<?php

namespace App\View\Components\Blog;

use Illuminate\View\Component;

class ArticlePage extends Component
{
    public $article;

    public function __construct($article){
        $this->article = $article;
    }

    public function render(){
        return view('components.blog.article-page');
    }
}
