<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Digiants\FastAdminPanel\Helpers\Lang;

class SitemapController extends Controller
{
	private $domain = 'https://digiantsshop.digiants.agency';

	public function index() {

		$sitemap = $this->set_header();

		$this->add_url($sitemap, '', '1.0');

		$products = DB::table('product_ru')->select('slug')->get();

		 foreach ($products as $elm)
		 	$this->add_url($sitemap, '/'.$elm->slug, '0.5');

		$this->set_footer($sitemap);

		$response = Response::make($sitemap);
		$response->header('Content-Type', 'text/xhtml+xml; charset=utf-8');
		return $response;
	}

	private function add_url(&$map, $url, $priority) {

		if (Lang::get_langs()->count() > 1) {

			foreach (Lang::get_langs() as $l) {
				$map .= '<url>
							<loc>'.Lang::get_url($l->tag, $this->domain.$url).'</loc>
							<priority>'.$priority.'</priority>';

				foreach (Lang::get_langs() as $lang) {

					$map .= '<xhtml:link
								rel="alternate"
								hreflang="'.$lang->tag.'"
								href="'.Lang::get_url($lang->tag, $this->domain.$url).'"/>';
				}
				$map .= '</url>';
			}

		} else {

			$map .= '<url>
						<loc>'.Lang::get_url('ru', $this->domain.$url).'</loc>
						<priority>'.$priority.'</priority>'.
					'</url>';
		}
	}

	private function add_doc(&$map, $url, $priority) {
		$map .= '<url>
					<loc>'.$this->domain.$url.'</loc>
					<priority>'.$priority.'</priority>
				</url>';
	}

	private function set_header() {
		return '<?xml version="1.0" encoding="UTF-8"?>
				<urlset
					  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
					  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
					  xmlns:xhtml="http://www.w3.org/1999/xhtml"
					  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
							http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
	}

	private function set_footer(&$sitemap) {
		$sitemap .= '</urlset>';
	}
}
