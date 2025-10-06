<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    public $metaTitle;

    public $metaDescription;

    public $javascript;

    public function __construct($metaTitle = '', $metaDescription = '', $javascript = '')
    {
        $this->metaTitle = $metaTitle;
        $this->metaDescription = $metaDescription;
        $this->javascript = $javascript;
    }

    public function render()
    {
        return view('components.layout');
    }
}
