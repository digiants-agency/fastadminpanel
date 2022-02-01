<?php

namespace App\Http\Controllers;

use App\Helpers\MailSender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Lang;
use Validator;
use Single;

class AuthController extends Controller
{
	
	public function login(Request $r) {
		
		$email = $r->get('email');
		$password = $r->get('password');
		
		if (Auth::attempt(['email' => $email, 'password' => $password])) {

			return $this->response([
				'redirect'	=> route('user', '', false),
			]);
		}
		
		return $this->error();
	}

	public function logout() {
		
		Auth::logout();

		return $this->response();
	}

	public function register(Request $r) {

		$name = $r->get('name');
		$email = $r->get('email');
		$phone = $r->get('phone');
		$password = $r->get('password');

		$credentials = Validator::make($r->all(), [
            'email' => [
				'required', 
				'email', 
				'unique:users,email'
			],
            'phone' => [
				'required', 
				'unique:users,phone'
			],
            'password' => [
				'required', 
				'min:8'
			],
        ]);

		if($credentials->fails()) {

			return $this->error($credentials->errors());
		}

		$user = User::create([
			'name'		=> $name,
			'surname'	=> '',
			'id_roles'	=> 2,
			'email'		=> $email,
			'password'	=> bcrypt($password),
			'phone'		=> $phone,
			'login'		=> '',
			'code'		=> '',
		]);

		Auth::login($user);

		return $this->response([
			'redirect'	=> route('user', '', false),
		]);

	}

	public function sendcode(Request $r) {

		$email = $r->get('email');

		$user = User::where('email', $email)
		->first();

		if (empty($user))
			return $this->error([]);

		$code = $user->set_code();

		$user->save();

        $s = new Single('Модальные окна (логин)', 10, 2);

		$message = $s->field('Восстановить пароль', 'Ваш код (текст E-mail)', 'text', true, 'Ваш код:');
		$message .= $code;

		$mail_sender = new MailSender();
		$mail_sender->send($email, $r->get('title'), $message);

		return $this->response([]);

	}
	
	public function checkcode(Request $r) {

		$email = $r->get('email');
		$code = $r->get('code');
		
		$user = User::where('email', $email)
		->where('code', $code)
		->first();

		if (empty($user))
			return $this->error([]);

		return $this->response([]);

	}

	public function changepassword(Request $r) {

		$email = $r->get('email');
		$code = $r->get('code');
		$password = $r->get('password');

		$user = User::where('email', $email)
		->where('code', $code)
		->first();

		if (empty($user))
			return $this->error([]);
			

		$credentials = Validator::make($r->all(), [
			'email' => [
				'email', 
			],
			'password' => [
				'required', 'min:8'
			],
			'password_confirmation' => [
				'same:password'
			]
		]);

		if($credentials->fails()) {

			return $this->error($credentials->errors());
		}

		$user->password = bcrypt($password);
		$user->clear_code();
		$user->save();

		return $this->response([]);
	
	}
}