<?php

namespace App\Http\Controllers;

use App\FastAdminPanel\Helpers\Lang;
use App\FastAdminPanel\Helpers\Single;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function createorder()
    {


        return view('pages.order', [

        ]);
    }

    public function ajaxcreateorder()
    {
        $data1 = json_decode($_POST['orderdata'], true);
        $data2 = json_decode($_POST['cartdata'], true);

        $orderdata = [
            'name' => 'Не указан',
            'email' => 'Не указан',
            'tel' => 'Не указан',
            'country' => 'Не указан',
            'region' => 'Не указан',
            'city' => 'Не указан',
            'adress' => 'Не указан',
            'deltype' => 'Не указан',
            'paytype' => 'Не указан',
            'paystatus' => 0,
            'status' => 'Новый'
        ];

        foreach ($data1 as $k => $d) {
            if ($d['value'] != '') $orderdata[$d['name']] = $d['value'];
        }

        $items = [];
        foreach ($data2 as $k => $item) {
            foreach ($item as $kk => $i) {
                $items[$k][$kk] = $i;
            }
        }

        $orderid = DB::table('orders')->insertGetId($orderdata);

        $orderproducts = [];
        foreach ($items as $k => $i) {
            $orderproducts[$k]['title'] = $i['title'];
            $orderproducts[$k]['attributes'] = $i['attributes'][0];
            $orderproducts[$k]['price'] = $i['sale_price'] ? $i['sale_price'] : $i['price'];
            $orderproducts[$k]['count'] = $i['count'];
            $orderproducts[$k]['link'] = $i['slug'];
            $orderproducts[$k]['img'] = $i['image'];
            $orderproducts[$k]['id_orders'] = $orderid;
        }

        $message = '';
        foreach ($orderdata as $k => $o) {
            $message .= $k . ' - ' . $o . "\n\r";
        }


        foreach ($orderproducts as $k => $o) {
            foreach ($o as $kk => $oo) {
                $message .= $kk . ' - ' . $oo . "\n\r";
            }
        }


        if (DB::table('orders_product')->insert($orderproducts)) echo('success add items');


        echo('success create');
        die();
    }


    public function callback()
    {
        $data1 = json_decode($_POST['orderdata'], true);

        $orderdata['email'] = 'Не указан';
        $orderdata['title'] = 'Не указан';
        $orderdata['tel'] = 'Не указан';
        $orderdata['note'] = 'Не указан';
        $orderdata['link'] = 'Не указан';
        foreach ($data1 as $k => $d) {
            if ($d['value'] != '') $orderdata[$d['name']] = $d['value'];
        }


        if (DB::table('callback')->insert($orderdata)) echo('success add');

        die();

    }

    public function wishlist()
    {
     if(Auth::check()) {
         $user = Auth::user();
         $data = [];
         $data['id_users'] = $user->id;
         $data['title'] = $_POST['title'];
         $data['price'] = $_POST['price'];
         $data['sale_price'] = $_POST['sale_price'];
         $data['img'] = $_POST['img'];
         $data['slug'] = $_POST['slug'];
         $data['attr'] = $_POST['modtitle'];
         if (DB::table('wishlist')->insert($data)) echo('success add');

     } else
         echo('error auth');

     die();
    }

    public function buyoneclick()
    {
        $data1 = json_decode($_POST['orderdata'], true);

        $orderdata = [
            'name' => 'Покупка в один клик',
            'email' => 'Покупка в один клик',
            'tel' => 'Не указан',
            'country' => 'Не указан',
            'region' => 'Не указан',
            'city' => 'Не указан',
            'adress' => 'Не указан',
            'deltype' => 'Не указан',
            'paytype' => 'Не указан',
            'paystatus' => 0,
            'status' => 'Новый',
            'nonrecall' => '-',
        ];

        $productid = 0;

        foreach ($data1 as $k => $d) {
            if ($d['value'] != '' && $d['name'] != 'id') $orderdata[$d['name']] = $d['value'];
            if ($d['name'] == 'id') $productid = $d['value'];
        }

        if($orderdata['nonrecall']=='on') $orderdata['nonrecall'] = 'Не перезванивать!';
        $orderid = DB::table('orders')->insertGetId($orderdata);

        $items = DB::table('product_' . Lang::get())->where('id', $productid)->get();

        $orderproducts = [];

        foreach ($items as $k => $i) {
            $orderproducts[$k]['title'] = $i->title;
            $orderproducts[$k]['attributes'] = 'Не указан';
            $orderproducts[$k]['price'] = $i->sale_price ? $i->sale_price : $i->price;
            $orderproducts[$k]['count'] = 1;
            $orderproducts[$k]['link'] = $i->slug;
            $orderproducts[$k]['img'] = $i->image;
            $orderproducts[$k]['id_orders'] = $orderid;
        }

        $message = '';
        foreach ($orderdata as $k => $o) {
            $message .= $k . ' - ' . $o . "\n\r";
        }


        foreach ($orderproducts as $k => $o) {
            foreach ($o as $kk => $oo) {
                $message .= $kk . ' - ' . $oo . "\n\r";
            }
        }


            if (DB::table('orders_product')->insert($orderproducts)) echo('success add items');


            echo('success create');
            die();
        }


}
