<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\VehicleFile;
use App\VehiclePassenger;
use App\User;
use App\Mail\vhlCreateTicket;
use App\Mail\vhlApproved;
use App\Mail\vhlAccomplished;
use App\Mail\vhlConfirmed;
use App\Mail\vhlAssigned;
use App\Mail\vhlOnTheWay;
use Illuminate\Support\Facades\Mail;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Http\Request;
use Auth;
use Dotenv\Result\Success;
use Illuminate\Support\Facades\URL;
use Vonage\Message\Shortcode\Alert;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vehicle = Vehicle::orderBy('id', 'desc')->get(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row
        return view('vehicle.vehicle', compact('vehicle')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
    }

    public function all_vehicle()
    {
        $vehicle = Vehicle::orderBy('id', 'desc')->get(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row
        return view('vehicle.all_vehicle', compact('vehicle')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
    }
    public function vehicle_store(Request $request)
    {
        try {
            if ($request->vehicle_id != null) {
                $save = Vehicle::where('id', $request->vehicle_id)->first();
            } else {
                $save = new Vehicle; //model
                $save->status = 'Filing';
                $save->user_id = Auth::user()->id;
            }
            $save->date_needed = $request->date_needed; //$save->dbcolumn = $request->input name fr blade
            $save->purpose = $request->purpose;
            $save->destination = $request->destination;
            $save->save();

            return redirect()->back()->with('message', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function get_trip($vehicle_id)
    {
        $vehicle = Vehicle::where('id', $vehicle_id)->first(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row

        $trip = Vehicle::where('vehicle_id', $vehicle_id)
            ->orderBy('id', 'desc')
            ->get();
        $count_trip = count($trip);
        $vehicle->count_rec = $count_trip;
        $vehicle->save();
        return view('vehicle.trip', compact('trip', 'vehicle')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
    }


    public function calendar_trip($vehicle_id)
    {
        $vehicle = Vehicle::where('id', $vehicle_id)->get();
        $passenger = VehiclePassenger::where('vehicle_id', $vehicle_id)->get();
        return view('vehicle.calendar_trip', compact('vehicle', 'passenger')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
    }

    // EDIT VEHICLE
    public function edit_vehicle(Request $request)
    {
        $edit = Vehicle::where('id', $request->data_id)->first();
        $due_date = date("Y-m-d", strtotime($edit->date_needed));
        $due_time = date("H:i", strtotime($edit->date_needed));

        $edit->date_needed = $due_date . "T" . $due_time;
        return json_encode($edit);
    }

    // DELETE VEHICLE REC
    public function delete_vehicle(Request $request)
    {
        try {
            Vehicle::where('id', $request->data_id)->delete(); //model
            return json_encode('deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function store_trip(Request $request)
    {
        try {

            if ($request->vehicle_id != null) {
                $save = Vehicle::where('id', $request->vehicle_id)->first();
            } else {
                $save = new Vehicle(); //model
            }
            $save->date_needed = $request->date_needed; //$save->dbcolumn = $request->input name fr blade
            $save->purpose = $request->purpose;
            $save->destination = $request->destination;
            $save->passenger = $request->passenger;
            $save->vehicle_id = $request->vehicle_id;
            $save->save();

            return redirect()->back()->with('message', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    // EDIT TRIP TICKET
    public function edit_trip(Request $request)
    {
        $edit = Vehicle::where('id', $request->data_id)->first();
        $due_date = date("Y-m-d", strtotime($edit->date_needed));
        $due_time = date("H:i", strtotime($edit->date_needed));

        $edit->date_needed = $due_date . "T" . $due_time;

        return json_encode($edit);
    }

    // DELETE TRIP
    public function delete_trip(Request $request)
    {
        try {
            Vehicle::where('id', $request->data_id)->delete(); //model
            return json_encode('deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function submit_vehicle(Request $request)
    {
        try {
            $update = Vehicle::where('id', $request->data_id)->first(); //model
            $division = Auth::user()->division;
            $user = User::where('id', $update->user_id)->first();
            $user_type = $user->user_type;
            if ($user_type == 2 || $user_type == 4 || $user_type == 6) {
                $update->status = "For Assignment";
            } elseif ($user_type != 2 && $division == "Finance and Administrative Division" || $division == "Office of the Executive Director") {
                $update->status = "For Assignment";
            } else {
                $update->status = "For DC Approval"; //$update->dbcolumn = $request->input name fr blade 
            }
            $update->save();
            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();
            $dc = User::select('name', 'email')->where('division', $employee->division)->where('user_type', '2')->orwhere('user_type', '4')->first();
            $cao = User::select('name', 'email')->where('user_type', '6')->first();
            // if ($user_type == 4 && $employee->division == "Office of the Executive Director") {
            //     $data = array(
            //         'dc_name' => $cao->name,
            //         'emp_name' => $employee->name,
            //         'purpose' => $update->purpose,
            //         'link'  =>  URL::to('/vehicle/cao/approval')
            //     );
            // } elseif ($employee->division != "Finance and Administrative Division") {
            $data = array(
                'dc_name' => $dc->name,
                'emp_name' => $employee->name,
                'status' => $update->status,
                'purpose' => $update->purpose,
                'dc_link'  =>  URL::to('/vehicle/dc/approval'),
                'link'  =>  URL::to('/vehicle/dc/approval')
            );
            // } else {
            //     $data = array(
            //         'dc_name' => $cao->name,
            //         'emp_name' => $employee->name,
            //         'purpose' => $update->purpose,
            //         'link'  =>  URL::to('/vehicle/cao/approval')
            //     );
            // }

            // if ($dc_true == 1) {
            //     Mail::to($dc->email)->cc([$employee->email])->send(new msgCreateTicket($data));
            // } else {
            //     Mail::to($cao->email)->cc([$employee->email])->send(new msgCreateTicket($data));
            // }
            if ($update->status == "For DC Approval") {
                Mail::to("paula.acedo@psrti.gov.ph")->send(new vhlCreateTicket($data));
            }

            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function assign_vehicle(Request $request)
    {
        try {
            $update = Vehicle::where('id', $request->data_id)->first();
            $user = User::where('id', $update->user_id)->first();
            $user_type = $user->user_type;
            if ($user_type == 4 || $user_type == 6) {
                $update->status = "Confirmed";
                $today = date("Y-m-d H:i:s");
                $update->approvedcao_date = $today;
            } else {
                $update->status = "For CAO Approval";
            }
            $update->driver = $request->driver;
            $update->assigned_pickupdate = $request->assigned_pickupdate;
            $update->save();

            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();
            $agent = User::select('name', 'email')->where('user_type', '3')->first();
            $cao = User::select('name', 'email')->where('user_type', '6')->first();

            $data = array(
                'emp_name' => $employee->name,
                'purpose' => $update->purpose,
                'driver' => $update->driver,
                'agent' => $agent->name,
                'cao_name' => $cao->name,
                'status' => $update->status,
                'link'  =>  URL::to('/vehicle'),
                'agent_link'  =>  URL::to('/vehicle/accomplish'),
                'cao_link'  =>  URL::to('/vehicle/cao/approval'),
            );

            // Mail::to([$employee->email])->send(new msgApproved($data));
            if ($update->status == "Confirmed") {
                Mail::to("paula.acedo@psrti.gov.ph")->send(new vhlConfirmed($data));
            } else {
                Mail::to("paula.acedo@psrti.gov.ph")->send(new vhlCreateTicket($data));
                Mail::to("paula.acedo@psrti.gov.ph")->send(new vhlAssigned($data));
            }

            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    // DC APPROVAL
    public function dc_approval_vehicle()
    {
        $vehicle = Vehicle::orderBy('id', 'desc')->get(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row
        return view('vehicle.dc_approval_vehicle', compact('vehicle')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
    }

    // APPROVE DC APPROVAL
    public function approveDC_vehicle(Request $request)
    {
        try {
            $update = Vehicle::where('id', $request->data_id)->first();
            $update->status = "For Assignment";
            $today = date("Y-m-d H:i:s");
            $update->approveddc_date = $today;
            $update->save();

            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();
            $cao = User::select('name', 'email')->where('user_type', '6')->first();
            $dc = User::select('name', 'email')->where('division', $employee->division)->where('user_type', '2')->orwhere('user_type', '4')->first();

            $data = array(
                'dc_name' => $cao->name,
                'emp_name' => $employee->name,
                'purpose' => $update->purpose,
                'status' => $update->status,
                'link'  =>  URL::to('/vehicle/cao/approval'),
                'dc' => $dc->name,
                'dc_approved_link'  =>  URL::to('/vehicle'),

            );

            // Mail::to($cao->email)->cc([$employee->email])->send(new vhlCreateTicket($data));
            // Mail::to([$employee->email])->send(new vhlApproved($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new vhlApproved($data));

            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    // CAO APPROVAL
    public function cao_approval_vehicle()
    {
        $vehicle = Vehicle::orderBy('id', 'desc')->get(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row
        return view('vehicle.cao_approval_vehicle', compact('vehicle')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
    }

    // APPROVE CAO APPROVAL
    public function approveCAO_vehicle(Request $request)
    {
        try {
            $update = Vehicle::where('id', $request->data_id)->first();
            $update->status = "Confirmed";
            $today = date("Y-m-d H:i:s");
            $update->approvedcao_date = $today;
            $update->save();

            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();
            $agent = User::select('name', 'email')->where('user_type', '3')->first();
            $cao = User::select('name', 'email')->where('user_type', '6')->first();

            $data = array(
                'agent' => $agent->name,
                'emp_name' => $employee->name,
                'cao' => $cao->name,
                'driver' => $update->driver,
                'purpose' => $update->purpose,
                'status' => $update->status,
                'link'  =>  URL::to('/vehicle/accomplish'),
                'agent_link'  =>  URL::to('/vehicle/accomplish'),
                'cao_approved_link'  =>  URL::to('/vehicle')
            );

            // Mail::to($agent->email)->cc([$employee->email])->send(new msgCreateTicket($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new vhlConfirmed($data));
            // Mail::to([$employee->email])->send(new msgApproved($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new vhlApproved($data));

            $chosen_driver = $update->driver;

            if ($chosen_driver == "Elmo") {
                $num = "09171259293";
            } else {
                $num = "09171259293";
            }
            // $this->itexmo($num, "A new vehicle ticket is confirmed. Kindly contact Percs for more details.", "TR-PAULA259293_25NMQ", "7&6k!wqg}e");

            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function to_accomplish_vehicle()
    {
        $vehicle = Vehicle::orderBy('id', 'desc')->get(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row
        return view('vehicle.to_accomplish_vehicle', compact('vehicle')); //return view('folder.blade',compact('variable','variable2', 'variable....'));

    }

    // ON THE WAY
    public function otw_vehicle(Request $request)
    {
        try {
            $update = Vehicle::where('id', $request->data_id)->first();
            $update->status = "On The Way";
            $update->otw_pickupdate = $request->otw_pickupdate;

            $update->save();

            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();

            $data = array(
                'emp_name' => $employee->name,
                'purpose' => $update->purpose,
                'driver' => $update->driver,
                'link'  =>  URL::to('/vehicle'),
            );

            // Mail::to($agent->email)->cc([$employee->email])->send(new msgCreateTicket($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new vhlOnTheWay($data));

            // send SMS Notif
            // Nexmo::message()->send([
            //     'to' => '639224847673',
            //     'from' => '639224847673',
            //     'text' => "A new ticket is ready for service vehicle. Kindly contact Admin Aide IV for more details."
            // ]);

            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    function itexmo($number, $message, $apicode, $passwd)
    {
        try {
            $ch = curl_init();
            $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
            curl_setopt($ch, CURLOPT_URL, "https://www.itexmo.com/php_api/api.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($itexmo));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            return curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function vehicle_mark_accomplish(Request $request)
    {
        try {
            $update = Vehicle::where('id', $request->data_id)->first();
            $update->status = "Accomplished";
            $update->accomplished_date = $request->accomplished_date;  // $update->save();
            $update->save();
            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();

            $data = array(
                'emp_name' => $employee->name,
                'purpose' => $update->purpose,
                'driver' => $update->driver,
                'pickup_date' => $update->otw_pickupdate,
                'accomplished_date' => $update->accomplished_date,
                'link'  =>  URL::to('/vehicle'),
            );

            // Mail::to([$employee->email])->send(new vhlAccomplished($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new vhlAccomplished($data));

            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }
    public function vhl_mark_accomplish_modal(Request $request)
    {
        $view = Vehicle::where('id', $request->data_id)->first();
        $due_date = date("Y-m-d", strtotime($view->otw_pickupdate));
        $due_time = date("H:i", strtotime($view->otw_pickupdate));

        $view->otw_pickupdate = $due_date . "T" . $due_time;

        return json_encode($view);
    }

    // vehicle ATTACHMENT
    public function vehicle_attachment(Request $request)
    {
        try {
            $edit = Vehicle::where('id', $request->data_id)->first();
            return json_encode($edit);
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    // public function load_destination(Request $request)
    // {
    //     $load = Vehicle::where('id', $request->vehicle_id)->get();
    //     return json_encode($load);
    // }

    public function vehicle_load_file(Request $request)
    {
        $load = VehicleFile::where('vehicle_id', $request->vehicle_id)->get();
        return json_encode($load);
    }

    public function vehicle_submit_file(Request $request)
    {
        try {
            $insert = new VehicleFile;
            $insert->vehicle_id = $request->vehicle_id;
            $insert->remarks = $request->remarks;
            $file = $request->file('attachment');

            if ($file == '') {
                $new_name_file = '';
            } else {
                $new_name_file = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)  . "-" .  time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/vehicle'), $new_name_file);
            }
            $insert->attachment = $new_name_file;
            $insert->save();
            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function vehicle_delete_file(Request $request)
    {
        try {
            $delete = VehicleFile::where('id', $request->vehiclefile_id)->first();
            $delete->delete();
            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function cancel_vehicle(Request $request)
    {
        try {
            $cancel = Vehicle::where('id', $request->vehicle_id)->first();
            $cancel->status = "Cancelled";
            $cancel->cancel_reason = $request->cancel_reason;
            $cancel->save();

            return redirect()->back()->with('message', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function cancel_reason_vehicle(Request $request)
    {
        $load = Vehicle::where('id', $request->vcl_cancel_id)->first();
        return json_encode($load);
    }

    public function report_vehicle()
    {

        $vehicle = Vehicle::orderBy('id', 'desc')->get();
        return view('vehicle.report_vehicle', compact('vehicle'));
    }

    public function vehicle_monthly_report($month, $year)
    {
        $vehicle = Vehicle::whereYear('accomplished_date', $year)
            ->whereMonth('accomplished_date', $month)
            ->get();

        $my_date = date("M Y", strtotime($vehicle[0]["accomplished_date"]));

        $kmd_cnt = Vehicle::select('vehicle.*', 'users.*', 'vehicle.id as vehicle_id')
            ->leftjoin('users', 'vehicle.user_id', 'users.id')
            ->where('status', 'Accomplished')
            ->where('division', 'Knowledge Management Division')
            ->whereYear('accomplished_date', $year)
            ->whereMonth('accomplished_date', $month)
            ->get();
        $kmd_count = count($kmd_cnt);

        $oed_cnt = Vehicle::select('vehicle.*', 'users.*', 'vehicle.id as vehicle_id')
            ->leftjoin('users', 'vehicle.user_id', 'users.id')
            ->where('status', 'Accomplished')
            ->where('division', 'Office of the Executive Director')
            ->whereYear('accomplished_date', $year)
            ->whereMonth('accomplished_date', $month)
            ->get();
        $oed_count = count($oed_cnt);

        $td_cnt = Vehicle::select('vehicle.*', 'users.*', 'vehicle.id as vehicle_id')
            ->leftjoin('users', 'vehicle.user_id', 'users.id')
            ->where('status', 'Accomplished')
            ->where('division', 'Training Division')
            ->whereYear('accomplished_date', $year)
            ->whereMonth('accomplished_date', $month)
            ->get();
        $td_count = count($td_cnt);

        $rd_cnt = Vehicle::select('vehicle.*', 'users.*', 'vehicle.id as vehicle_id')
            ->leftjoin('users', 'vehicle.user_id', 'users.id')
            ->where('status', 'Accomplished')
            ->where('division', 'Research Division')
            ->whereYear('accomplished_date', $year)
            ->whereMonth('accomplished_date', $month)
            ->get();
        $rd_count = count($rd_cnt);
        
        $fad_cnt = Vehicle::select('vehicle.*', 'users.*', 'vehicle.id as vehicle_id')
            ->leftjoin('users', 'vehicle.user_id', 'users.id')
            ->where('status', 'Accomplished')
            ->where('division', 'Finance and Administrative Division')
            ->whereYear('accomplished_date', $year)
            ->whereMonth('accomplished_date', $month)
            ->get();
        $fad_count = count($fad_cnt);

        return view('vehicle.vehicle_monthly_report', compact('vehicle', 'my_date', 'kmd_count', 'oed_count' , 'td_count' , 'rd_count' , 'fad_count'));
    }

    public function vehicle_check_monthly_report(Request $request)
    {
        $vehicle = Vehicle::whereYear('accomplished_date', $request->year)
            ->whereMonth('accomplished_date', $request->month)
            ->get();
        return json_encode(count($vehicle));
    }


    public function add_passenger(Request $request)
    {
        $passenger = VehiclePassenger::where('vehicle_id', $request->vehicle_id)->get();
        if (count($passenger) >= 1) {
            return json_encode($passenger);
        } else {
            return json_encode("null");
        }
    }

    public function view_passenger(Request $request)
    {
        $passenger = VehiclePassenger::where('vehicle_id', $request->vehicle_id)->get();
        if (count($passenger) >= 1) {
            return json_encode($passenger);
        } else {
            return json_encode("null");
        }
    }

    public function view_vehicle(Request $request)
    {
        $vehicle = Vehicle::where('id', $request->vehicle_id)->first();
        $due_date = date("F j, Y g:i A", strtotime($vehicle->created_at));
        $vehicle->created_at = $due_date;
        return json_encode($vehicle);
    }

    public function passengertolist(Request $request)
    {
        try {
            $insert = new VehiclePassenger;
            $insert->vehicle_id = $request->vehicle_id;
            $insert->passenger = $request->passenger;
            $insert->save();
            return json_encode("success");
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function del_passengertolist(Request $request)
    {
        try {
            $delete = VehiclePassenger::where('id', $request->passenger_id)->first();
            $delete->delete();
            return json_encode("success");
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }
    public function print_vehicle($vehicle_id)
    {
        $vehicle = Vehicle::where('id', $vehicle_id)->first();

        $vehicle_file = VehicleFile::where('vehicle_id', $vehicle_id)
            ->orderBy('id', 'desc')
            ->get();

        $passenger = VehiclePassenger::where('vehicle_id', $vehicle_id)
            ->orderBy('id', 'desc')
            ->get();
        $countpsg = count($passenger);
        $vehicle->count_psg = $countpsg;
        $vehicle->save();
        return view('vehicle.print_vehicle', compact('passenger', 'vehicle_file', 'vehicle'));
    }
}
