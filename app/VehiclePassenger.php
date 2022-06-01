<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehiclePassenger extends Model
{
    protected $table="vehicle_passenger";

    public static function get_passenger($vehicle_id)
    {
        $passenger = Self::where('vehicle_id', $vehicle_id)->get();
        return $passenger;
    }

}
