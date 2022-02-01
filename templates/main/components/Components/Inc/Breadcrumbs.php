<?php

namespace App\View\Components\Inc;

use Illuminate\View\Component;
use Lang;
use Single;

class Breadcrumbs extends Component
{
	public $APP_URL;
	public $actual_link;
    public $breadcrumbs;
    public $breadcrumbs_first;
    public $json;
    public $type;

    public function __construct($breadcrumbs, $type = ''){
        
        $this->APP_URL = env('APP_URL');
        $this->actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        $this->breadcrumbs_first = 'Main';
        // $s = new Single('Хлебные крошки', 10, 2);
        // $this->breadcrumbs_first = $s->field('Хлебные крошки', 'Главная хлебная крошка', 'text', true, 'Главная');

        $this->breadcrumbs = $this->make_breadcrumbs($breadcrumbs);
        $this->json = $this->make_json($this->breadcrumbs);
        $this->type = $type;
    }

    protected function make_breadcrumbs($breadcrumbs){

        $result = [
            [
                'full_link' => $this->APP_URL,
                'link'      => Lang::link('/'),
                'title'     => $this->breadcrumbs_first,
            ],
        ];

        foreach ($breadcrumbs as $link){
            $result[] = [
                'full_link'  => $this->APP_URL . '/' . $link['link'],
                'link'  => $link['link'],
                'title' => $link['title'],
            ];
        }

        $result[sizeof($result) - 1]['full_link'] = $this->actual_link;

        return $result;
    }

    protected function make_json($breadcrumbs){

        $result = [
            "@context"			=> "http://schema.org",
            "@type"				=> "BreadcrumbList", 
        ];

        $bread = [];

        foreach ($breadcrumbs as $index => $link){
            $bread[] = [
                "@type"		=> "ListItem",
                "position"	=> $index + 1,
                "name"		=> $link['title'],
                "item"		=> $link['full_link'],
            ]; 
        }

        $result["itemListElement"] = $bread;

        return $result;
    }

    public function render(){
        return view('components.inc.breadcrumbs');
    }
}
