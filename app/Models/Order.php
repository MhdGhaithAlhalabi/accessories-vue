<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Order extends Model
{
    use HasFactory;
    protected $table= 'orders';
    protected $fillable =['product_id','cart_id','qty','color','has_name','has_measure','created_at'];
    public function cart()
    {
        return $this->belongsTo(Cart::class,'cart_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
