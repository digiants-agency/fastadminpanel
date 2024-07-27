<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Requests\Auth\SignInRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
	public function ping()
	{
		$user = Auth::user();

		return Response::json($user);
	}

	public function signIn(SignInRequest $request)
	{
		$data = $request->validated();

		$authData = ['email' => $data['email'], 'password' => $data['password']];

		$isAuth = Auth::attempt($authData, $data['is_remember']);

		if ($isAuth) {

			$user = Auth::user();

			return Response::json($user);
		}

		return Response::json([], 422);
	}

	public function signOut()
	{
		Auth::logout();

		return Response::json();
	}
}