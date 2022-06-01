<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessengerialItem extends Model
{
    protected $table = "messengerial_items";

    public static function get_recipient($messengerial_id)
    {
        $recipient = Self::where('messengerial_id', $messengerial_id)->get();
        return $recipient;
    }
}
