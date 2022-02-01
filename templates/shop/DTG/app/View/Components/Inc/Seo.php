<?php

namespace App\View\Components\Inc;

use Illuminate\View\Component;

class Seo extends Component
{
    public $title;
    public $content;

    public function __construct($title = '', $content = ''){

        $this->title = $title;
        $this->content = $content;  
    }

    public function render(){
        return view('components.inc.seo');
    }
}
