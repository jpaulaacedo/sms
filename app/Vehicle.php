<?php

namespace App;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Vehicle extends Model
{
    //protected $table="<db table name>";
    protected $table = "vehicle";

    public static function get_vehicle($vehicle_id)
    {
        $vehicle = Self::where('id', $vehicle_id)->get();
        return $vehicle;
    }

    public static function staff_vehicle()
    {
        $ctr = 0;
        $vehicle = Self::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->get();

        foreach ($vehicle as $data) {
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

    public static function agent_vehicle()
    {
        $status = array("For Assignment", "For CAO Approval", "For Rescheduling", "Confirmed", "Cancelled", "Out For Delivery", "Accomplished", "To Rate");
        $ctr = 0;
        $vehicle = Self::orderBy('id', 'desc')->whereIn('status', $status)->get();

        foreach ($vehicle as $data) {
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

    public static function cao_vehicle()
    {
        $ctr = 0;
        $vehicle = Self::orderBy('id', 'desc')->get();

        foreach ($vehicle as $data) {
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

    public static function dc_vehicle()
    {

        $ctr = 0;
        $staff_div = User::select('id')->where('division', Auth::user()->division)->get();
        $vehicle = Self::orderBy('id', 'desc')->whereIn('user_id', $staff_div)->get();
        foreach ($vehicle as $data) {
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
        $vehicle = Self::whereDate('date_needed', $my_date_start)->whereIn('status', $status)->get();
        if (count($vehicle) >= 2) {
            return "same";
        }else{
            return "";
        }
    }

    public static function count_rate(){
        $vehicle = Vehicle::orderBy('id', 'desc')->get(); 
        $ctr = 0;
        foreach($vehicle as $check){
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
