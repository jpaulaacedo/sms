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
        $msg_calendar = Messengerial::get();
        $msg_my_array = [];

        foreach ($msg_calendar as $data) {
            $title = $data->control_num;

            array_push(
                $msg_my_array,
                [
                    "id" => 'msg',
                    "title" => $title,
                    "start" => $data->approvedcao_date,
                    "allDay" => false,
                    "backgroundColor" => "#eb4034",
                    "textColor" => "#ffffff",
                    "eventColor" => "#ffffff",
                    "url" => URL::to('/messengerial/recipient/' . $data->id)

                ]
            );
        }

        $vhl_calendar = Vehicle::leftjoin('users', 'vehicle.user_id', 'users.id')->get();
        $vhl_my_array = [];

        foreach ($vhl_calendar as $data) {
            $title = $data->name;
            array_push(
                $msg_my_array,
                [
                    "id" => 'vhl',
                    "title" => $title,
                    "start" => $data->approvedcao_date,
                    "allDay" => false,
                    "backgroundColor" => "#18f53d",
                    "textColor" => "#000000",
                    "eventColor" => "#ffffff",
                    "url" => URL::to('/vehicle/calendar/view/' . $data->id)

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
        return view('vehicle.vehicle_calendar', compact('trip'));
    }
}
