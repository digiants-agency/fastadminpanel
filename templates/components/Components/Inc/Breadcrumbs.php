<?php

namespace App\View\Components\Inc;

use App\FastAdminPanel\Facades\Lang;
use Illuminate\View\Component;

class Breadcrumbs extends Component
{
	public $APP_URL;
	public $actualLink;
    public $breadcrumbs;
    public $breadcrumbsFirst;
    public $json;
    public $type;

    public function __construct($breadcrumbs, $type = '')
	{
        $this->APP_URL = config('app.url');
        $this->actualLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        $this->breadcrumbsFirst = 'Main';

        $this->breadcrumbs = $this->makeBreadcrumbs($breadcrumbs);
        $this->json = $this->makeJson($this->breadcrumbs);
        $this->type = $type;
    }

    protected function makeBreadcrumbs($breadcrumbs)
	{
        $result = [
            [
                'full_link' => $this->APP_URL,
                'link'      => Lang::link('/'),
                'title'     => $this->breadcrumbsFirst,
            ],
        ];

        foreach ($breadcrumbs as $link) {
            $result[] = [
                'full_link'  => $this->APP_URL . '/' . $link['link'],
                'link'  => $link['link'],
                'title' => $link['title'],
            ];
        }

        $result[sizeof($result) - 1]['full_link'] = $this->actualLink;

        return $result;
    }

    protected function makeJson($breadcrumbs)
	{
        $result = [
            "@context"			=> "http://schema.org",
            "@type"				=> "BreadcrumbList", 
        ];

        $bread = [];

        foreach ($breadcrumbs as $index => $link) {
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

    public function render()
	{
        return view('components.inc.breadcrumbs');
    }
}
