<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected function response($result = []) {
		
		$response = [
			'success' => true,
			'data'    => $result,
		];
		
		return response()->json($response, 200);
	}

	protected function error($error_messages = [], $code = 418) {

		$response = [
			'success'	=> false,
			'data'		=> $error_messages,
		];

		return response()->json($response, $code);
	}

	protected function pagination ($count, $posts_per_page, $curr, $link) {
		if (empty($curr))
			$curr = 1;
		$obj = [];

		$page_count = ceil($count / $posts_per_page);
		if ($page_count > 1) {
			if ($curr > 1) $obj['arrow_left'] = $curr - 1;
			if ($page_count > 7) {
				$obj['first'] = 1;
				$obj['middle'] = [];
				if ($curr == 1) {
					$obj['middle'] = [2, -1];
				}
				else if ($curr == 2) {
					$obj['middle'] = [2, 3, -1];
				}
				else if ($curr == 3) {
					$obj['middle'] = [2, 3, 4, -1];
				}
				else if ($curr == $page_count) {
					$obj['middle'] = [-1, $curr - 1];
				}
				else if ($curr == $page_count - 1) {
					$obj['middle'] = [-1, $curr - 1, $curr];
				}
				else if ($curr == $page_count - 2) {
					$obj['middle'] = [-1, $curr - 1, $curr, $curr + 1];
				}
				else {
					$obj['middle'] = [-1, $curr - 1, $curr, $curr + 1, -1];
				}
				$obj['last'] = $page_count;
			}
			else if ($page_count == 2) {
				$obj['first'] = 1;
				$obj['last'] = 2;
			}
			else {
				$obj['middle'] = [];
				$obj['first'] = 1;
				$obj['last'] = $page_count;
				for ($i = 2;$i < $page_count;$i++) {
					$obj['middle'][] = $i;
				}
			}
			if ($page_count > $curr) $obj['arrow_right'] = $curr + 1;
			$obj['active'] = $curr;
			$obj['link'] = $link;

			$obj['separator'] = '?';
			if (strpos($link, '?') !== false) {
				$obj['separator'] = '&';
			}
		}
		return $obj;
	}
}