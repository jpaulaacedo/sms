<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public static function get_driver($user_id)
    {
        $messengerial = Self::where('id', $user_id)->first();
        return $messengerial->driver;
    }

    public static function get_star($user_id)
    {
        $messengerial = Self::where('id', $user_id)->first();
        return $messengerial->star;
    }

    public static function get_feedback($user_id)
    {
        $messengerial = Self::where('id', $user_id)->first();
        return $messengerial->feedback;
    }

    public static function staff_messengerial()
    {
        $ctr = 0;
        $messengerial = Self::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->get();

        foreach ($messengerial as $data) {
            if (($data->status == "Filing" || $data->status == "For Rescheduling" || $data->status == "Confirmed" || $data->status == "Accomplished") && $data->feedback == "") {
                $ctr++;
            }
        }
        if ($ctr >= 1) {
            return $ctr;
        } else {
            return "";
        }
    }

    public static function agent_messengerial()
    {
        $status = array("For Assignment", "For CAO Approval", "For Rescheduling", "Confirmed", "Cancelled", "Out For Delivery", "Accomplished", "To Rate");
        $ctr = 0;
        $messengerial = Self::orderBy('id', 'desc')->whereIn('status', $status)->get();

        foreach ($messengerial as $data) {
            if ($data->status != "Filing" && $data->status != "For CAO Approval" && $data->status != "Cancelled" && $data->status != "Accomplished" && $data->status != "To Rate") {
                $ctr++;
            }
        }
        if ($ctr >= 1) {
            return $ctr;
        } else {
            return "";
        }
    }

    public static function cao_messengerial()
    {
        $ctr = 0;
        $messengerial = Self::orderBy('id', 'desc')->get();

        foreach ($messengerial as $data) {
            if ($data->status == "For CAO Approval") {
                $ctr++;
            }
        }
        if ($ctr >= 1) {
            return $ctr;
        } else {
            return "";
        }
    }

    public static function dc_messengerial()
    {

        $ctr = 0;
        $staff_div = User::select('id')->where('division', Auth::user()->division)->get();
        $messengerial = Self::orderBy('id', 'desc')->whereIn('user_id', $staff_div)->get();
        foreach ($messengerial as $data) {
            if ($data->status == "For DC Approval") {
                $ctr++;
            }
        }
        if ($ctr >= 1) {
            return $ctr;
        } else {
            return "";
        }
    }


    public static function same_date($date)
    {

        $my_date = Carbon::parse($date);
        $status = array("For Assignment", "For CAO Approval", "For Rescheduling", "Confirmed", "Out For Delivery");
        $my_date_start = $my_date->format("Y-m-d");
        $messengerial = Self::whereDate('date_needed', $my_date_start)->whereIn('status', $status)->get();
        if (count($messengerial) >= 2) {
            return "same";
        }else{
            return "";
        }
    }

    public static function count_rate(){
        $messengerial = Messengerial::orderBy('id', 'desc')->get(); 
        $ctr = 0;
        foreach($messengerial as $check){
            if($check->status =='Accomplished' && $check->feedback == ""){
                $ctr++;
            }
        }
        if($ctr >= 1){
            return "disabled";
        }else{
            return "";
        }
    }
}
