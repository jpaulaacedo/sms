<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function get_user($user_id)
    {
        $data = Self::where('id', $user_id)->first();
        return $data->name;
    }

    public static function get_division($user_id)
    {
        $data = Self::where('id', $user_id)->first();
        return $data->division;
    }

    public static function get_user_type($user_id)
    {
        $data = Self::where('id', $user_id)->first();
        return $data->user_type;
    }
}
