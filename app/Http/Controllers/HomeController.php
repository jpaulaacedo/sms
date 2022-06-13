<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Messengerial;
use App\Vehicle;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function feed_calendar()
    {
        $msg_calendar = Messengerial::leftjoin('messengerial_items', 'messengerial.id', 'messengerial_items.messengerial_id')->where('status', "For Pickup")->orwhere('status', "Out For Delivery")->orwhere('status', "Accomplished")->get();
        $msg_my_array = [];

        foreach ($msg_calendar as $data) {
            $title = $data->control_num;

            array_push(
                $msg_my_array,
                [
                    "title" => $title,
                    "start" => $data->due_date,
                    "allDay" => false,
                    "backgroundColor" => "#eb4034",
                    "textColor" => "#ffffff",
                    "eventColor" => "#ffffff",
                    "url" => URL::to('/messengerial/calendar_recipient/' . $data->id)

                ]
            );
        }

        $vhl_calendar = Vehicle::select('vehicle.*','users.*','vehicle.id as vehicle_id')
        ->leftjoin('users', 'vehicle.user_id', 'users.id')->where('status', "For Pickup")->orwhere('status', "On The Way")->orwhere('status', "Accomplished")->get();

        foreach ($vhl_calendar as $data) {
            $title = $data->name;
            array_push(
                $msg_my_array,
                [
                    "title" => $title,
                    "start" => $data->date_needed,
                    "allDay" => false,
                    "backgroundColor" => "#218551",
                    "textColor" => "#000000",
                    "eventColor" => "#ffffff",
                    "url" => URL::to('/vehicle/calendar_trip/' . $data->vehicle_id)

                ]
            );
        }
        return json_encode($msg_my_array);
    }

    public function vehicle_calendar($vehicle_id)
    {
        $trip = Vehicle::where('vehicle_id', $vehicle_id)
            ->orderBy('id', 'desc')
            ->get();
        return view('vehicle.vehicle', compact('trip'));
    }
}
