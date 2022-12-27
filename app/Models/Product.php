<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($p)
 */
class Product extends Model
{
    use HasFactory;
    protected $table= 'products';
    protected $fillable =['type_id','name','price','details','rate','priceSale','status','category_id','has_name','has_measure'];
    public function rate()
    {
        return $this->hasMany(Rate::class);
    }
    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function type()
    {
        return $this->belongsTo(Type::class,'type_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function menu()
    {
        return $this->hasOne(Menu::class);
    }
    public function color()
    {
        return $this->hasMany(Color::class);
    }
    protected $appends = ['created_at_diff'];
    public function getCreatedAtDiffAttribute():string
    { return $this->created_at->diffForHumans(); }
}
