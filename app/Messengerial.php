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
    public static function get_del_item($user_id)
    {
        $messengerial = Self::where('id', $user_id)->first();
        return $messengerial->delivery_item;
    }

    public static function get_agency($user_id)
    {
        $messengerial = Self::where('id', $user_id)->first();
        return $messengerial->agency;
    }
    public static function get_dest($user_id)
    {
        $messengerial = Self::where('id', $user_id)->first();
        return $messengerial->destination;
    }
}
