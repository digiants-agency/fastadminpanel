<?php

namespace App\Http\Controllers;

use App\FastAdminPanel\Facades\Lang;
use Illuminate\Support\Facades\Response;

// TODO: refactor
class SitemapController extends Controller
{
    protected $domain;

    protected $sitemap;

    public function __construct()
    {
        $this->sitemap = collect([]);
        $this->domain = config('app.url');
    }

    public function index()
    {
        $this->addUrl('');

        /* examples */

        // $this->addUrl('/about');
        // $this->addUrl('/contacts');

        // $products = DB::table('products_en')->select('slug')->get();
        // foreach ($products as $elm) {
        //	$this->addUrl("/products/{$elm->slug}");
        // }

        $view = view('pages.sitemap', [
            'sitemap' => $this->sitemap,
        ])->render();

        $response = Response::make($view);
        $response->header('Content-Type', 'application/xml');

        return $response;
    }

    // it is a blunder, move this to a service
    protected function addUrl($url, $isMultilanguage = true)
    {
        $this->sitemap[] = [
            'url' => $this->domain.$url,
            'isMultilanguage' => $isMultilanguage && Lang::count() > 1,
        ];
    }
}
