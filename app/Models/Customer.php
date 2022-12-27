<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * @method static create(array $array)
 * @method static findOrFail($customer_id)
 */
class Customer extends Authenticatable  implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $table= 'customers';
    protected $fillable =['name','phone','password','city'];

    public function rate()
    {
        return $this->hasMany(Rate::class);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


}
