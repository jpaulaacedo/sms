<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //protected $table="<db table name>";
    protected $table="vehicle";
    
    public static function get_vehicle($vehicle_id)
    {
        $vehicle = Self::where('id', $vehicle_id)->get();
        return $vehicle;
    }
}
