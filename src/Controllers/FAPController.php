<?php 

namespace Digiants\FastAdminPanel\Controllers;

use App\User;
use Auth;
use Hash;
use DB;

class FAPController extends \App\Http\Controllers\Controller {

    public function admin () {

        $languages = DB::table('languages')->get();

        $data = array(
            'languages' => $languages,
		);

        return view('fastadminpanel.pages.admin')->with($data);
    }

    public function login () {


        $data = array(
		);

		return view('fastadminpanel.pages.login')->with($data);
    }

    public function sign_in () {

        $request = request();

        $email = $request->get('email');
        $password = $request->get('password');

        if (Auth::attempt(['email' => $email, 'password' => $password], $request->get('remember') === 'true')) {

            return redirect('/admin');
        }
        setcookie('password', 'incorrect', time() + 3600 * 5);
		return redirect('/login');
    }
}