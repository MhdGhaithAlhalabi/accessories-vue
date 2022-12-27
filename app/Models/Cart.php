<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Cart extends Model
{
    use HasFactory;
    protected $table= 'carts';
    protected $fillable =['customer_id','amount','status','address','created_at'];
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function order()
    {
        return $this->hasMany(Order::class,'cart_id');
    }
}
