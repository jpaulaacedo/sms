<?php

namespace App\Http\Controllers;

use App\Messengerial;
use App\MessengerialItem;
use App\MessengerialFile;
use Auth;
use App\User;
use App\Mail\msgCreateTicket;
use App\Mail\msgConfirmed;
use App\Mail\msgApproved;
use App\Mail\msgForAssignment;
use App\Mail\msgResched;
use App\Mail\msgAccomplished;
use App\Mail\msgOutForDel;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use LengthException;

class MessengerialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $messengerial = Messengerial::orderBy('id', 'desc')->get(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row
        return view('messengerial.messengerial', compact('messengerial')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
    }


    public function messengerial_store(Request $request)
    {
        try {
            if ($request->msg_id != null) {
                $save = Messengerial::where('id', $request->msg_id)->first();
            } else {
                $save = new Messengerial; //model
                $save->status = 'Filing';
                $save->user_id = Auth::user()->id;
                $save->remarks = "";
                $save->attachment = "";
                $current_rec = Messengerial::count('id');
                $new_num = $current_rec + 1;
                $new_rec = '';
                if ($new_num <= 9) {
                    $new_rec = "000" . $new_num;
                } elseif ($new_num <= 99 && $new_num >= 10) {
                    $new_rec = "00" . $new_num;
                } elseif ($new_num <= 999 && $new_num >= 100) {
                    $new_rec = "0" . $new_num;
                } else {
                    $new_rec = $new_num;
                }
                $save->control_num = date("Y-m") . "-" . $new_rec;
            }
            $save->recipient = $request->recipient; //$save->dbcolumn = $request->input name fr blade
            $save->destination = $request->destination;
            $save->date_needed = $request->due_date;
            $save->agency = $request->agency; //$save->dbcolumn = $request->input name fr blade
            $save->contact = $request->contact;
            $save->urgency = $request->urgency;
            $save->delivery_item = $request->delivery_item;
            $save->instruction = $request->instruction;
            $save->save();

            return redirect()->back()->with('message', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }


    public function calendar_recipient($messengerial_id)
    {
        $messengerial = Messengerial::where('id', $messengerial_id)->first(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row

        return view('messengerial.calendar_recipient', compact('messengerial')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
    }

    public function print_messengerial($messengerial_id)
    {
        $messengerial = Messengerial::where('id', $messengerial_id)->first();
        $messengerial_file = MessengerialFile::where('messengerial_id', $messengerial_id)
            ->orderBy('id', 'desc')
            ->get();
        $countfile = count($messengerial_file);
        $messengerial->count_file = $countfile;
        $messengerial->save();
        $recipient = MessengerialItem::where('messengerial_id', $messengerial_id)
            ->orderBy('id', 'desc')
            ->get();
        return view('messengerial.print_messengerial', compact('recipient', 'messengerial_file', 'messengerial'));
    }


    public function submit_messengerial(Request $request)
    {
        try {
            $update = Messengerial::where('id', $request->data_id)->first(); //model
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

            // if ($user_type == 4 && $employee->division == "Office of the Executive Director") {
            //     $data = array(
            //         'dc_name' => $cao->name,
            //         'driver' => $update->driver,
            //         'emp_name' => $employee->name,
            //         'recipient' => $update->recipient,
            //         'link'  =>  URL::to('/messengerial/cao/approval')
            //     );
            // } elseif ($employee->division != "Finance and Administrative Division") {
            $data = array(
                'dc_name' => $dc->name,
                'status' => $update->status,
                'emp_name' => $employee->name,
                'recipient' => $update->recipient,
                'agency' => $update->agency,
                'delivery_item' => $update->delivery_item,
                'dc_link'  =>  URL::to('/messengerial/dc/approval')
            );
            // } else {
            //     $data = array(
            //         'dc_name' => $cao->name,
            //         'emp_name' => $employee->name,
            //         'recipient' => $update->recipient,
            //         'driver' => $update->driver,
            //         'link'  =>  URL::to('/messengerial/cao/approval')
            //     );
            // }
            if ($update->status == "For DC Approval") {
                Mail::to("paula.acedo@psrti.gov.ph")->send(new msgCreateTicket($data));
            }
            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function submitResched_messengerial(Request $request)
    {
        try {
            $update = Messengerial::where('id', $request->data_id)->first(); //model
            $update->pref_sched = $request->pref_sched;
            if ($update->pref_sched == "by_agent") {
                $update->status = "For Assignment";
            } else {
                $update->pref_date = $request->pref_date;
            }
            $update->save();
            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();
            $dc = User::select('name', 'email')->where('division', $employee->division)->where('user_type', '2')->orwhere('user_type', '4')->first();

            $data = array(
                'dc_name' => $dc->name,
                'status' => $update->status,
                'emp_name' => $employee->name,
                'recipient' => $update->recipient,
                'agency' => $update->agency,
                'delivery_item' => $update->delivery_item,
                'dc_link'  =>  URL::to('/messengerial/dc/approval')
            );

            // if ($update->status == "For DC Approval") {
            // Mail::to("paula.acedo@psrti.gov.ph")->send(new msgCreateTicket($data));
            // }
            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    // DC  APPROVAL
    public function dc_approval_messengerial()
    {
        $messengerial = Messengerial::orderBy('id', 'desc')->get(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row
        return view('messengerial.dc_approval_messengerial', compact('messengerial')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
    }


    // CAO  APPROVAL
    public function cao_approval_messengerial()
    {
        $messengerial = Messengerial::orderBy('id', 'desc')->get(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row
        return view('messengerial.cao_approval_messengerial', compact('messengerial')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
    }


    // AGENT TO ACCOMPLISH
    public function to_accomplish_messengerial()
    {
        $messengerial = Messengerial::orderBy('id', 'desc')->get(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row
        return view('messengerial.to_accomplish_messengerial', compact('messengerial')); //return view('folder.blade',compact('variable','variable2', 'variable....'));

    }

    // REPORTS
    public function report_messengerial()
    {
        $messengerial = Messengerial::orderBy('id', 'desc')->get();
        return view('messengerial.report_messengerial', compact('messengerial'));
    }

    public function messengerial_monthly_report($month, $year)
    {
        $messengerial = Messengerial::whereYear('accomplished_date', $year)
            ->whereMonth('accomplished_date', $month)
            ->get();

        $my_date = date("M Y", strtotime($messengerial[0]["accomplished_date"]));

        $kmd_cnt = Messengerial::select('messengerial.*', 'users.*', 'messengerial.id as messengerial_id')
            ->leftjoin('users', 'messengerial.user_id', 'users.id')
            ->where('status', 'Accomplished')
            ->where('division', 'Knowledge Management Division')
            ->whereYear('accomplished_date', $year)
            ->whereMonth('accomplished_date', $month)
            ->get();
        $kmd_count = count($kmd_cnt);

        $oed_cnt = Messengerial::select('messengerial.*', 'users.*', 'messengerial.id as messengerial_id')
            ->leftjoin('users', 'messengerial.user_id', 'users.id')
            ->where('status', 'Accomplished')
            ->where('division', 'Office of the Executive Director')
            ->whereYear('accomplished_date', $year)
            ->whereMonth('accomplished_date', $month)
            ->get();
        $oed_count = count($oed_cnt);

        $td_cnt = Messengerial::select('messengerial.*', 'users.*', 'messengerial.id as messengerial_id')
            ->leftjoin('users', 'messengerial.user_id', 'users.id')
            ->where('status', 'Accomplished')
            ->where('division', 'Training Division')
            ->whereYear('accomplished_date', $year)
            ->whereMonth('accomplished_date', $month)
            ->get();
        $td_count = count($td_cnt);

        $rd_cnt = Messengerial::select('messengerial.*', 'users.*', 'messengerial.id as messengerial_id')
            ->leftjoin('users', 'messengerial.user_id', 'users.id')
            ->where('status', 'Accomplished')
            ->where('division', 'Research Division')
            ->whereYear('accomplished_date', $year)
            ->whereMonth('accomplished_date', $month)
            ->get();
        $rd_count = count($rd_cnt);

        $fad_cnt = Messengerial::select('messengerial.*', 'users.*', 'messengerial.id as messengerial_id')
            ->leftjoin('users', 'messengerial.user_id', 'users.id')
            ->where('status', 'Accomplished')
            ->where('division', 'Finance and Administrative Division')
            ->whereYear('accomplished_date', $year)
            ->whereMonth('accomplished_date', $month)
            ->get();
        $fad_count = count($fad_cnt);

        return view('messengerial.monthly_report', compact('messengerial', 'my_date', 'kmd_count', 'oed_count', 'td_count', 'rd_count', 'fad_count'));
    }

    public function messengerial_check_monthly_report(Request $request)
    {
        $messengerial = Messengerial::whereYear('accomplished_date', $request->year)
            ->whereMonth('accomplished_date', $request->month)
            ->get();
        return json_encode(count($messengerial));
    }

    public function edit_messengerial(Request $request)
    {
        $edit = Messengerial::where('id', $request->data_id)->first();
        $due_date = date("Y-m-d", strtotime($edit->date_needed));
        $due_time = date("H:i", strtotime($edit->date_needed));

        $edit->date_needed = $due_date . "T" . $due_time;

        return json_encode($edit);
    }

    public function resched_messengerial(Request $request)
    {
        $resched = Messengerial::where('id', $request->data_id)->first();
        $due_date = date("Y-m-d", strtotime($resched->date_needed));
        $due_time = date("H:i", strtotime($resched->date_needed));

        $resched->date_needed = $due_date . "T" . $due_time;

        return json_encode($resched);
    }

    public function rschd_messengerial(Request $request)
    {
        $rschd = Messengerial::where('id', $request->data_id)->first();
        $old_due_date = date("Y-m-d", strtotime($rschd->old_date_needed));
        $old_due_time = date("H:i", strtotime($rschd->old_date_needed));

        $rschd->old_date_needed = $old_due_date . "T" . $old_due_time;

        $due_date = date("Y-m-d", strtotime($rschd->date_needed));
        $due_time = date("H:i", strtotime($rschd->date_needed));

        $rschd->date_needed = $due_date . "T" . $due_time;

        return json_encode($rschd);
    }

    public function view_rschd_messengerial(Request $request)
    {
        $rschd = Messengerial::where('id', $request->data_id)->first();
        $old_due_date = date("Y-m-d", strtotime($rschd->old_date_needed));
        $old_due_time = date("H:i", strtotime($rschd->old_date_needed));

        $rschd->old_date_needed = $old_due_date . "T" . $old_due_time;

        $due_date = date("Y-m-d", strtotime($rschd->date_needed));
        $due_time = date("H:i", strtotime($rschd->date_needed));

        $rschd->date_needed = $due_date . "T" . $due_time;

        if ($rschd->pref_sched == "by_requestor") {
            $pref_due_date = date("Y-m-d", strtotime($rschd->pref_date));
            $pref_due_time = date("H:i", strtotime($rschd->pref_date));

            $rschd->pref_date = $pref_due_date . "T" . $pref_due_time;
        }
        return json_encode($rschd);
    }

    public function view_messengerial(Request $request)
    {
        $view = Messengerial::where('id', $request->data_id)->first();
        $due_date = date("Y-m-d", strtotime($view->date_needed));
        $due_time = date("H:i", strtotime($view->date_needed));

        $view->date_needed = $due_date . "T" . $due_time;

        return json_encode($view);
    }

    public function msg_mark_accomplish_modal(Request $request)
    {
        $view = Messengerial::where('id', $request->data_id)->first();
        return json_encode($view);
    }

    public function msg_acc_accomplish_modal(Request $request)
    {
        $view = Messengerial::where('id', $request->data_id)->first();
        return json_encode($view);
    }

    public function delete_recipient(Request $request)
    {
        try {
            MessengerialItem::where('id', $request->data_id)->delete(); //model
            return json_encode('deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    // public function edit_messengerial(Request $request)
    // {
    //     $edit = Messengerial::where('id', $request->data_id)->first();
    //     return json_encode($edit);
    // }

    public function cancel_messengerial(Request $request)
    {
        try {
            $cancel = Messengerial::where('id', $request->msg_cancel_id)->first();
            $cancel->status = "Cancelled";
            $cancel->cancel_reason = $request->cancel_reason;
            $cancel->save();

            return redirect()->back()->with('message', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function cancel_reason_messengerial(Request $request)
    {
        $load = Messengerial::where('id', $request->msg_cancel_id)->first();
        return json_encode($load);
    }

    public function delete_messengerial(Request $request)
    {
        try {
            Messengerial::where('id', $request->data_id)->delete(); //model
            return json_encode('deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function approveDC_messengerial(Request $request)
    {
        try {
            $update = Messengerial::where('id', $request->data_id)->first();
            $update->status = "For Assignment";
            $today = date("Y-m-d H:i:s");
            $update->approveddc_date = $today;
            $update->save();

            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();
            $cao = User::select('name', 'email')->where('user_type', '6')->first();
            $dc = User::select('name', 'email')->where('division', $employee->division)->where('user_type', '2')->orwhere('user_type', '4')->first();
            $agent = User::select('name', 'email')->where('user_type', '3')->first();

            $data = array(
                'dc_name' => $cao->name,
                'agent' => $agent->name,
                'emp_name' => $employee->name,
                'recipient' => $update->recipient,
                'agency' => $update->agency,
                'delivery_item' => $update->delivery_item,
                'status' => $update->status,
                'dc' => $dc->name,
                'agent_link'  =>  URL::to('/messengerial/accomplish'),
                'dc_approved_link'  =>  URL::to('/messengerial'),

            );

            // Mail::to($cao->email)->cc([$employee->email])->send(new msgCreateTicket($data));
            //approval for CAO
            // Mail::to("paula.acedo@psrti.gov.ph")->send(new msgCreateTicket($data));
            // Mail::to([$employee->email])->send(new msgApproved($data));  
            //notif approved by DC
            Mail::to("paula.acedo@psrti.gov.ph")->send(new msgApproved($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new msgForAssignment($data));

            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function approveCAO_messengerial(Request $request)
    {
        try {
            $update = Messengerial::where('id', $request->data_id)->first();
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
                'driver' => $update->driver,
                'cao' => $cao->name,
                'recipient' => $update->recipient,
                'agency' => $update->agency,
                'delivery_item' => $update->delivery_item,
                'status' => $update->status,
                'agent_link'  =>  URL::to('/messengerial/accomplish'),
                'link'  =>  URL::to('/messengerial')
            );

            // Mail::to($agent->email)->cc([$employee->email])->send(new msgCreateTicket($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new msgConfirmed($data));
            // Mail::to([$employee->email])->send(new msgApproved($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new msgApproved($data));

            $chosen_driver = $update->driver;

            if ($chosen_driver == "Elmo") {
                $num = "09171259293";
            } else {
                $num = "09171259293";
            }
            // $this->itexmo($num, "A messengerial ticket is confirmed. Kindly contact Percs for more details.", "TR-PAULA259293_25NMQ", "7&6k!wqg}e");

            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function outfordel_messengerial(Request $request)
    {
        try {
            $update = Messengerial::where('id', $request->data_id)->first();
            $update->status = "Out For Delivery";
            $today = date("Y-m-d H:i:s");
            $update->outfordel_date = $today;
            $update->save();

            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();

            $data = array(
                'emp_name' => $employee->name,
                'driver' => $update->driver,
                'pickup_date' => $update->outfordel_date,
                'recipient' => $update->recipient,
                'agency' => $update->agency,
                'delivery_item' => $update->delivery_item,
                'link'  =>  URL::to('/messengerial'),
            );

            // Mail::to($agent->email)->cc([$employee->email])->send(new msgCreateTicket($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new msgOutForDel($data));

            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function assign_messengerial(Request $request)
    {
        try {
            $update = Messengerial::where('id', $request->data_id)->first();
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
            $update->save();

            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();
            $agent = User::select('name', 'email')->where('user_type', '3')->first();
            $cao = User::select('name', 'email')->where('user_type', '6')->first();

            $data = array(
                'emp_name' => $employee->name,
                'recipient' => $update->recipient,
                'agency' => $update->agency,
                'delivery_item' => $update->delivery_item,
                'driver' => $update->driver,
                'agent' => $agent->name,
                'cao_name' => $cao->name,
                'status' => $update->status,
                'link'  =>  URL::to('/messengerial'),
                'agent_link'  =>  URL::to('/messengerial/accomplish'),
                'cao_link'  =>  URL::to('/messengerial/cao/approval'),
            );
            // Mail::to([$employee->email])->send(new msgApproved($data));
            if ($update->status == "Confirmed") {
                Mail::to("paula.acedo@psrti.gov.ph")->send(new msgConfirmed($data));
            } else {
                Mail::to("paula.acedo@psrti.gov.ph")->send(new msgCreateTicket($data));
            }

            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function reschedule_messengerial(Request $request)
    {
        try {
            $update = Messengerial::where('id', $request->resched_msg_id)->first();

            $update->resched_reason = $request->resched_reason;
            $update->old_date_needed = $update->date_needed;
            $update->date_needed = $request->due_date;
            $update->status = "For Rescheduling";
            $update->save();

            $user_id = $update->user_id;

            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();
            $agent = User::select('name', 'email')->where('user_type', '3')->first();

            $data = array(
                'emp_name' => $employee->name,
                'recipient' => $update->recipient,
                'agency' => $update->agency,
                'delivery_item' => $update->delivery_item,
                'date_needed' => $update->date_needed,
                'resched_reason' => $update->resched_reason,
                'link'  =>  URL::to('/messengerial'),
            );
            // Mail::to([$employee->email])->send(new msgApproved($data));

            Mail::to("paula.acedo@psrti.gov.ph")->send(new msgResched($data));

            return redirect()->back()->with('message', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function mark_accomplish_messengerial(Request $request)
    {
        try {
            $update = Messengerial::where('id', $request->data_id)->first();
            $update->status = "Accomplished";
            $update->accomplished_date = $request->accomplished_date;  // $update->save();
            $update->remarks = $request->remarks;
            $update->save();

            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();

            $data = array(
                'emp_name' => $employee->name,
                'driver' => $update->driver,
                'pickup_date' => $update->outfordel_date,
                'accomplished_date' => $update->accomplished_date,
                'recipient' => $update->recipient,
                'agency' => $update->agency,
                'delivery_item' => $update->delivery_item,
                'link'  =>  URL::to('/messengerial'),
            );

            // Mail::to([$employee->email])->send(new msgAccomplished($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new msgAccomplished($data));

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


    public function all_messengerial()
    {
        $messengerial = Messengerial::orderBy('id', 'desc')->get(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row
        return view('messengerial.all_messengerial', compact('messengerial')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
    }

    // MESSENGERIAL ATTACHMENT
    // public function accomplish_messengerial(Request $request)
    // {
    //     try {
    //         $edit = Messengerial::where('id', $request->data_id)->first();
    //         return json_encode($edit);
    //     } catch (\Exception $e) {
    //         return json_encode($e->getMessage());
    //     }
    // }

    // public function load_recipient(Request $request)
    // {
    //     $load = MessengerialItem::where('messengerial_id', $request->messengerial_id)->get();
    //     return json_encode($load);
    // }
    public function markacc_messengerial(Request $request)
    {
        try {
            $update = Messengerial::where('id', $request->data_id)->first();
            $update->save();
            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function load_file(Request $request)
    {
        $load = MessengerialFile::where('messengerial_id', $request->messengerial_id)->get();
        return json_encode($load);
    }

    public function file(Request $request)
    {
        try {
            $edit = Messengerial::where('id', $request->data_id)->first();
            return json_encode($edit);
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function submit_file(Request $request)
    {
        try {
            $insert = new MessengerialFile;
            $insert->messengerial_id = $request->messengerial_id;
            $file = $request->file('attachment');

            if ($file == '') {
                $new_name_file = '';
            } else {
                $new_name_file = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)  . "-" .  time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/messengerial'), $new_name_file);
            }
            $insert->attachment = $new_name_file;
            $insert->save();
            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function delete_file(Request $request)
    {
        try {
            $delete = MessengerialFile::where('id', $request->messengerialfile_id)->first();
            $delete->delete();
            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }
}
