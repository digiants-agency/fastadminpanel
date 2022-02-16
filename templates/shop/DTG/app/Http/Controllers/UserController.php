<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FastAdminPanel\Helpers\Lang;
use App\Models\User;
use App\View\Components\User\UserHistory;
use App\View\Components\User\UserInfo;
use App\View\Components\User\UserNavigation;
use App\View\Components\User\UserWished;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Validator;

class UserController extends Controller
{

	public function user(Request $r) {

		$route = $r->route()->getName();

		$user = Auth::user();

		if (!$user) {
			abort(404);
		}

		if ($r->isMethod('post')){

			$component_navigation = new UserNavigation($route);

			if ($route == 'userwished') {
				$component = new UserWished(true);
			} elseif ($route == 'userhistory') {
				$component = new UserHistory(true);
			} else {
				$component = new UserInfo($user, true);
			}

			return $this->response([
				'content'		=> $component->render(),
				'navigation'	=> $component_navigation->render(),
			]);
		}

		return view('pages.user', [
			'route'	=> $route,
			'user'	=> $user,
		]);
	}

	public function edit (Request $r){

		$name = $r->get('name');
		$surname = $r->get('surname') ?? '';
		$login = $r->get('login') ?? '';
		$email = $r->get('email');
		$phone = $r->get('phone');
		$password = $r->get('password');
		// $password_confirmation = $r->get('password_confirmation');

		if (!empty($password)) {

			$credentials = Validator::make($r->all(), [
				'password' => [
					'min:8'
				],
				'password_confirmation' => [
					'same:password'
				]
			]);
	
			if($credentials->fails()) {
	
				return $this->error($credentials->errors());
			}
		}

		$credentials = Validator::make($r->all(), [
			'email' => [
				'email', 
			],
		]);

		if($credentials->fails()) {
	
			return $this->error($credentials->errors());
		}

		$user = User::where('id', Auth::id())
		->first();

		$user->name = $name;
		$user->surname = $surname;
		$user->email = $email;
		$user->phone = $phone;
		$user->login = $login;

		if (!empty($password)){
			$user->password = bcrypt($password);
		}

		$user->save();


		return $this->response();

	} 

}