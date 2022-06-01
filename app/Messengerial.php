<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messengerial extends Model
{
    protected $table = "messengerial";

    public static function get_status($user_id)
    {
        $messengerial = Self::where('id', $user_id)->first();
        return $messengerial->division;
    }
}
