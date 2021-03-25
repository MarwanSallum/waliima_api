<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use LaratrustUserTrait;

            // Rest omitted for brevity

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
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded =[];

        /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at'
    ];

       /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
