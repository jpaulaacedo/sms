<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessengerialFile extends Model
{
    //
    protected $table = "messengerial_file";

    public static function get_month($messengerial_id)
    {
        $messengerial = Self::where('messengerial_id', $messengerial_id)->get();
        return $messengerial;
    }
}
