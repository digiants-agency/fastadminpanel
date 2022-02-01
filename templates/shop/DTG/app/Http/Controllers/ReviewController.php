<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Review;
use App\View\Components\Products\ProductDescription\ReviewsBlock;


class ReviewController extends Controller
{
	public function send_review(Request $r){
		$input = $r->all();

		$review = new Review;

		$review->name = $input['name'];
		$review->phone = $input['phone'];
		$review->email = $input['email'];
		$review->message = $input['message'];
		$review->id_products = $input['id_products'];
		$review->answer = '';
		$review->is_show = 0;
		$review->date = date('Y-m-d H:i:s');
		
		$review->save();

		return $this->response();
	}

	public function show_more_reviews(Request $r, Product $product_model){
		$input = $r->all();

		$reviews = $product_model->get_reviews($input['id'], $input['page']);
		$reviews_count = $product_model->get_reviews_count($input['id']);

		$reviews_component = new ReviewsBlock($reviews);
		
		return $this->response([
			'html'	=> $reviews_component->render(),
			'count'	=> $reviews_count,
		]);
	}

}