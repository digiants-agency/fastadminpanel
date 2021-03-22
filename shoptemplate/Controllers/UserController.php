<?php

namespace App\Http\Controllers;

use Digiants\FastAdminPanel\Helpers\Lang;
use Digiants\FastAdminPanel\Helpers\Single;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class UserController extends Controller
{
	public function view () {
	    if(Auth::check())
        {
            $user = Auth::user();


            $user->fields = DB::table('custom_user')
                ->where('id_users', $user->id)
                ->get();

            $user->fields->tel = empty($user->fields->tel) ? '' : $user->fields->tel;
            $user->fields->last_name = empty($user->fields->last_name) ? '' : $user->fields->last_name;


            $orders = DB::table('orders')
                ->where('email',Auth::user()->email)
                ->get();

            foreach($orders as &$o){
                $o->items = DB::table('orders_product')
                    ->where('id_orders',$o->id)
                    ->get();
            }

            $wishlist = DB::table('wishlist')
                ->where('id_users',$user->id)
                ->get();


	    return view('pages.userinfo', [
	        'user' => $user,
	        'orders' => $orders,
            'wishlist' => $wishlist
        ]);
	    } else {
            return redirect('/');
        }
	}

	public function signin(){
        $request = request();

        $email = $request->get('email');
        $password = $request->get('password');

        if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
            echo('success auth');
        } else {
            echo ('error auth');
        }
    }

    public function signup(){
        $request = request();

        $email = $request->get('email');
        $password = $request->get('password');
        $name = $request->get('name');

        $array = [
            'email' => $email,
            'password' => bcrypt($password),
            'name' => $name,
            'role_id' => 2
        ];

        DB::table('users')->insert($array);
        echo('success');
        die();
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }


    public function clearwish(){
        if(Auth::check()) {
            $user = Auth::user();
            DB::table('wishlist')->where('id_users', $user->id)->delete();
            redirect('/user');
        }
        return redirect('/user');
    }

    public function resavedata(){
        $request = request();

        $name = $request->get('name');
        $surname = $request->get('surname');
        $email = $request->get('email');
        $tel = $request->get('tel');
        $pass = $request->get('pass');
        $onemorepass = $request->get('onemorepass');
    }

    public function changeuserdata()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $request = request();

            $name = $request->get('name');
            $surname = $request->get('surname');
            $email = $request->get('email');
            $telephone = $request->get('telephone');
            $password = $request->get('password');
            $repeatpassword = $request->get('repeatpassword');

            if($name!=''){
                $noncheckedval['name'] = $name;
            }
            if($surname!=''){
                $noncheckedval['surname'] = $surname;
            }
            if($telephone!=''){
                $noncheckedval['telephone'] = $telephone;
            }

            DB::table('users')
                ->where('id', $user->id)
                ->update($noncheckedval);

            if($email!=''){
                if($email!=$user->email){
                    if(DB::table('users')->
                        where('email', $email)
                            ->count()==0) {
                        DB::table('users')
                            ->where('id', $user->id)
                            ->update(array('email'=>$email));
                    } else {echo('error auth'); die();}
                }
            }

            if ($password!=''&&$repeatpassword!=''&&$password==$repeatpassword){
                $hashpass = bcrypt($password);
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(array('password'=>$hashpass));
            }
            $_SESSION['successchangeuserdata'] = 'Данные успешно обновлены!';
            echo('successupd');

        } else echo('error auth');
    }

    public function losspass()
    {
        $request = request();

        $email = $request->get('email');

        $countusers = DB::table('users')->
        where('email', $email)
            ->count();
        if ($countusers == 1) {
            $newpass = $this->getRandomString();
            $hashpass = bcrypt($newpass);
            if (DB::table('users')
                ->where('email', $email)
                ->update(array('password' => $hashpass))) {
                mail($email, 'Восстановление пароля', 'Ваш пароль успешно сброшен. Новый пароль - ' . $newpass);
                echo('success');
            } else echo('error auth 2');
        } else echo('error auth');
    }

    private function getRandomString($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }

}
