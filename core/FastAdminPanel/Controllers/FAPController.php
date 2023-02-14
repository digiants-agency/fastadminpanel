<?php 

namespace App\FastAdminPanel\Controllers;

use App\User;
use Auth;
use Hash;
use DB;

class FAPController extends \App\Http\Controllers\Controller
{
	public function admin()
	{
		$languages = DB::table('languages')->get();
		$custom_components_path = resource_path('views/fastadminpanel/components/custom');
		$custom_components_files = scandir($custom_components_path);
		$custom_components = [];

		foreach ($custom_components_files as $custom_component) {
			$pathinfo = pathinfo($custom_component);
			if ($pathinfo['extension'] == 'php') {
				$custom_components[] = [
					'name'	=>	$pathinfo['filename'],
					'path'	=> 'fastadminpanel/components/custom/'.$pathinfo['filename'],
				];
			}
		}

		return view('fastadminpanel.pages.admin')->with([
			'languages'			=> $languages,
			'custom_components'	=> $custom_components,
		]);
	}

	public function login()
	{
		return view('fastadminpanel.pages.login')->with([]);
	}

	public function signIn()
	{
		$request = request();

		$email = $request->get('email');
		$password = $request->get('password');

		if (Auth::attempt(['email' => $email, 'password' => $password], $request->get('remember') === 'true')) {

			return redirect('/admin');
		}

		setcookie('password', 'incorrect', time() + 3600 * 5);

		return redirect('/login');
	}

	public function logout()
	{
		$request = request();

		Auth::logout();

		// setcookie('password', 'incorrect', time() + 3600 * 5);

		// $request->session()->invalidate();

		// $request->session()->regenerateToken();

		return redirect('/login');
	}
}