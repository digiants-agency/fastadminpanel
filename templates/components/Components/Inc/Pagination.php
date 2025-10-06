<?php

namespace App\View\Components\Inc;

use App\FastAdminPanel\Helpers\SEO;
use Illuminate\View\Component;

// TODO: refactor
class Pagination extends Component
{
    public $pagination;

    public $showmore;

    public $fields;

    public function __construct($count, $pagesize, $page, $paglink, $showmore = false)
    {
        $this->pagination = $this->makePagination($count, $pagesize, $page, $paglink);
        $this->showmore = $showmore;

        $this->fields = [
            'showmore' => 'Show more',
        ];
    }

    public function render()
    {
        return view('components.inc.pagination', [
            'pagination' => $this->pagination,
            'showmore' => $this->showmore,
            'fields' => $this->fields,
        ])->render();
    }

    protected function makePagination($count, $perPage, $curr, $link)
    {
        $obj = [];

        $page_count = ceil($count / $perPage);

        if ($count != 0) {

            if ($curr > $page_count) {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: '.$link.'?page='.$page_count);
                exit();
            }

            if ($curr == 0 || request()->get('page') == 1) {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: '.$link);
                exit();
            }
        }

        if (empty($curr)) {
            $curr = 1;
        }

        if ($page_count > 1) {

            if ($curr > 1) {
                $obj['arrow_left'] = $curr - 1;
                $obj['arrow_first'] = 1;
            }

            if ($page_count > 7) {

                $obj['first'] = 1;
                $obj['middle'] = [];

                if ($curr == 1) {

                    $obj['middle'] = [2, -1];
                } elseif ($curr == 2) {

                    $obj['middle'] = [2, 3, -1];
                } elseif ($curr == 3) {

                    $obj['middle'] = [2, 3, 4, -1];
                } elseif ($curr == $page_count) {

                    $obj['middle'] = [-1, $curr - 1];
                } elseif ($curr == $page_count - 1) {

                    $obj['middle'] = [-1, $curr - 1, $curr];
                } elseif ($curr == $page_count - 2) {

                    $obj['middle'] = [-1, $curr - 1, $curr, $curr + 1];
                } else {

                    $obj['middle'] = [-1, $curr - 1, $curr, $curr + 1, -1];
                }
                $obj['last'] = $page_count;
            } elseif ($page_count == 2) {

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

        if (isset($obj['arrow_left'])) {
            $href = $obj['link'];
            $href .= ($obj['arrow_left'] != 1) ? $obj['separator'].'page='.$obj['arrow_left'] : '';

            SEO::linkPrev($href);
        }

        if (isset($obj['arrow_right'])) {
            $href = $obj['link'].$obj['separator'].'page='.$obj['arrow_right'];
            SEO::linkNext($href);
        }

        return $obj;
    }
}
