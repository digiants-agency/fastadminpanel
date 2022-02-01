<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    protected $table = 'orders';

    public function __construct(){
        parent::__construct();
    }


    protected static function booted(){

        static::addGlobalScope('products', function (Builder $builder) {
            $builder->with('products');
        });

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->with('status');
        });

        static::addGlobalScope('delivery', function(Builder $builder){
            $builder->with('delivery');
        });

        static::addGlobalScope('payment', function(Builder $builder){
            $builder->with('payment');
        });
    }


    public function products(){
        return $this->hasMany(OrderProducts::class, 'id_orders');
    }

    public function status(){
        return $this->belongsTo(OrderStatus::class, 'id_orders_status');
    }

    public function delivery(){
        return $this->belongsTo(Delivery::class, 'id_delivery');
    }

    public function payment(){
        return $this->belongsTo(Payment::class, 'id_payment');
    }
    

    public function calculate_sum(){

        $sum = 0;

        foreach($this->products as $product){
            $sum += intval($product->price) * $product->count;
        }

        $this->sum = $sum + intval($this->delivery->price);

    } 

}
