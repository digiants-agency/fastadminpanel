<?php

namespace App\View\Components\Inc;

use Illuminate\Http\Request;
use Illuminate\View\Component;
use SEO;
use Single;

class Pagination extends Component
{
    public $pagination;
	public $showmore;
	public $fields;

    public function __construct($count, $pagesize, $page, $paglink, $showmore = false){
        
		$this->pagination = $this->make_pagination($count, $pagesize, $page, $paglink);
		$this->showmore = $showmore;

		// $s = new Single('Каталог', 10, 1);
		$this->fields = [
			// 'showmore'	=> $s->field('Каталог', 'Кнопка "Показать больше" (текст)', 'text', true, 'Показать больше'),
			'showmore'	=> 'Показать больше',

		];

    }
    
    public function render(){
        return view('components.inc.pagination', [
			'pagination'	=> $this->pagination,
			'showmore'		=> $this->showmore,
			'fields'		=> $this->fields,
		])->render();
    }

	protected function make_pagination ($count, $posts_per_page, $curr, $link) {
		$obj = [];

		$page_count = ceil($count / $posts_per_page);
		
		if ( $count != 0){

			if ($curr > $page_count){
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: ".$link."?page=".$page_count);
				die();
			}
	
			if ($curr == 0 || request()->get('page') == 1){
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: ".$link);
				die();
			}
		}
			
		if (empty($curr))
			$curr = 1;
			
		if ($page_count > 1) {
			
			if ($curr > 1){
				$obj['arrow_left'] = $curr - 1;
				$obj['arrow_first'] = 1;
			} 

			if ($page_count > 7) {
			
				$obj['first'] = 1;
				$obj['middle'] = [];
			
				if ($curr == 1) {

					$obj['middle'] = [2, -1];
				} else if ($curr == 2) {

					$obj['middle'] = [2, 3, -1];
				} else if ($curr == 3) {

					$obj['middle'] = [2, 3, 4, -1];
				} else if ($curr == $page_count) {

					$obj['middle'] = [-1, $curr - 1];
				} else if ($curr == $page_count - 1) {

					$obj['middle'] = [-1, $curr - 1, $curr];
				} else if ($curr == $page_count - 2) {

					$obj['middle'] = [-1, $curr - 1, $curr, $curr + 1];
				} else {

					$obj['middle'] = [-1, $curr - 1, $curr, $curr + 1, -1];
				}
				$obj['last'] = $page_count;
			} else if ($page_count == 2) {

				$obj['first'] = 1;
				$obj['last'] = 2;
			} else {

				$obj['middle'] = [];
				$obj['first'] = 1;
				$obj['last'] = $page_count;
				for ($i = 2; $i < $page_count; $i++) {

					$obj['middle'][] = $i;
				}
			}
			
			if ($page_count > $curr) {
				$obj['arrow_right'] = $curr + 1;
				$obj['arrow_last'] = $page_count;
			} 
			
			$obj['active'] = $curr;
			$obj['link'] = $link;

			$obj['separator'] = '?';
			
			if (strpos($link, '?') !== false) {
				$obj['separator'] = '&';
			}
		}

		if (isset($obj['arrow_left'])){
			$href = $obj['link'];
			$href .= ($obj['arrow_left'] != 1) ? $obj['separator'].'page='.$obj['arrow_left'] : '';

			SEO::link_prev($href);
		}

		if (isset($obj['arrow_right'])){
			$href = $obj['link'].$obj['separator'].'page='.$obj['arrow_right'];
			SEO::link_next($href);
		}

		return $obj;
	}
}
