<?php

namespace App\Http\Controllers;

use App\Messengerial;
use App\MessengerialItem;
use App\MessengerialFile;
use Auth;
use App\User;
use App\Mail\msgCreateTicket;
use App\Mail\msgForPickup;
use App\Mail\msgApproved;
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
            if ($request->messengerial_id != null) {
                $save = Messengerial::where('id', $request->messengerial_id)->first();
            } else {
                $save = new Messengerial; //model
                $save->status = 'Filing';
                $save->user_id = Auth::user()->id;
                $save->remarks = "";
                $save->attachment = "";


                $save->cancel_reason = "cancel reason";
                $current_rec = Messengerial::max('id');
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
            $save->subject = $request->subject; //$save->dbcolumn = $request->input name fr blade
            $save->save();

            return redirect()->back()->with('message', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function store_recipient(Request $request)
    {
        try {

            if ($request->messengerial_item_id != null) {
                $save = MessengerialItem::where('id', $request->messengerial_item_id)->first();
            } else {
                $save = new MessengerialItem; //model
            }
            $save->agency = $request->agency; //$save->dbcolumn = $request->input name fr blade
            $save->recipient = $request->recipient;
            $save->contact = $request->contact;
            $save->destination = $request->destination;
            $save->delivery_item = $request->delivery_item;
            $save->instruction = $request->instruction;
            $save->due_date = $request->due_date;
            $save->messengerial_id = $request->messengerial_id;
            $save->save();

            return redirect()->back()->with('message', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function get_recipient($messengerial_id)
    {
        $messengerial = Messengerial::where('id', $messengerial_id)->first(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row

        $recipient = MessengerialItem::where('messengerial_id', $messengerial_id)
            ->orderBy('id', 'desc')
            ->get();
        $count_recipient = count($recipient);
        $messengerial->count_rec = $count_recipient;
        $messengerial->save();
        return view('messengerial.recipient', compact('recipient', 'messengerial')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
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
            $update = Messengerial::where('id', $request->submit_msg_id)->first(); //model
            $division = Auth::user()->division;
            $user_type = Auth::user()->user_type;
            if ($user_type == 2 || $user_type == 4) {
                $update->status = "For CAO Approval";
            } elseif ($user_type == 6) {
                $update->status = "For Pickup";
                $today = date("Y-m-d H:i:s");
                $update->approvedcao_date = $today;
            } elseif ($user_type != 2 && $division == "Finance and Administrative Division") {
                $update->status = "For CAO Approval";
            } else {
                $update->status = "For DC Approval"; //$update->dbcolumn = $request->input name fr blade 
            }
            $update->save();
            $user_id = $update->user_id;

            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();
            $dc = User::select('name', 'email')->where('division', $employee->division)->where('user_type', '2')->orwhere('user_type', '4')->first();
            $cao = User::select('name', 'email')->where('division', $employee->division)->where('user_type', '6')->first();

            if ($employee->division != "Finance and Administrative Division") {
                $dc_true = 1;
                $data = array(
                    'dc_name' => $dc->name,
                    'emp_name' => $employee->name,
                    'subject' => $update->subject,
                    'link'  =>  URL::to('/messengerial/dc/approval')
                );
            } else {
                $dc_true = 0;
                $data = array(
                    'dc_name' => $cao->name,
                    'emp_name' => $employee->name,
                    'subject' => $update->subject,
                    'link'  =>  URL::to('/messengerial/cao/approval')
                );
            }

            // if ($dc_true == 1) {
            //     Mail::to($dc->email)->cc([$employee->email])->send(new msgCreateTicket($data));
            // } else {
            //     Mail::to($cao->email)->cc([$employee->email])->send(new msgCreateTicket($data));
            // }

            Mail::to("paula.acedo@psrti.gov.ph")->send(new msgCreateTicket($data));

            return redirect('messengerial')->with('message', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
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
        $messengerial = Messengerial::whereYear('approvedcao_date', $year)
            ->whereMonth('approvedcao_date', $month)
            ->get();

        $my_date = date("M Y", strtotime($messengerial[0]["approvedcao_date"]));
        return view('messengerial.monthly_report', compact('messengerial', 'my_date'));
    }

    public function messengerial_check_monthly_report(Request $request)
    {
        $messengerial = Messengerial::whereYear('approvedcao_date', $request->year)
            ->whereMonth('approvedcao_date', $request->month)
            ->get();
        return json_encode(count($messengerial));
    }

    // EDIT RECIPIENT
    public function edit_recipient(Request $request)
    {
        $edit = MessengerialItem::where('id', $request->data_id)->first();
        $due_date = date("Y-m-d", strtotime($edit->due_date));
        $due_time = date("H:i", strtotime($edit->due_date));

        $edit->due_date = $due_date . "T" . $due_time;

        return json_encode($edit);
    }

    // DELETE RECIPIENT
    public function delete_recipient(Request $request)
    {
        try {
            MessengerialItem::where('id', $request->data_id)->delete(); //model
            return json_encode('deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    // EDIT MESSENGERIAL
    public function edit_messengerial(Request $request)
    {
        $edit = Messengerial::where('id', $request->data_id)->first();
        return json_encode($edit);
    }

    // CANCEL MESSENGERIAL
    public function cancel_messengerial(Request $request)
    {
        try {
            $cancel = Messengerial::where('id', $request->messengerial_id)->first();
            $cancel->status = "Cancelled";
            $cancel->cancel_reason = $request->cancel_reason;
            $cancel->save();

            return redirect()->back()->with('message', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    // CANCEL REASON VIEW
    public function cancel_reason_messengerial(Request $request)
    {
        $load = Messengerial::where('id', $request->msg_cancel_id)->first();
        return json_encode($load);
    }

    // DELETE MESSENGERIAL REC
    public function delete_messengerial(Request $request)
    {
        try {
            Messengerial::where('id', $request->data_id)->delete(); //model
            return json_encode('deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }


    // APPROVE DC APPROVAL
    public function approveDC_messengerial(Request $request)
    {
        try {
            $update = Messengerial::where('id', $request->data_id)->first();
            $update->status = "For CAO Approval";
            $update->save();

            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();
            $cao = User::select('name', 'email')->where('user_type', '6')->first();
            $dc = User::select('name', 'email')->where('division', $employee->division)->where('user_type', '2')->orwhere('user_type', '4')->first();

            $data = array(
                'dc_name' => $cao->name,
                'emp_name' => $employee->name,
                'subject' => $update->subject,
                'status' => $update->status,
                'link'  =>  URL::to('/messengerial/cao/approval'),
                'dc' => $dc->name,
                'dc_approved_link'  =>  URL::to('/messengerial'),

            );

            // Mail::to($cao->email)->cc([$employee->email])->send(new msgCreateTicket($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new msgCreateTicket($data));
            // Mail::to([$employee->email])->send(new msgApproved($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new msgApproved($data));

            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    // APPROVE CAO APPROVAL
    public function approveCAO_messengerial(Request $request)
    {
        try {
            $update = Messengerial::where('id', $request->data_id)->first();
            $update->status = "For Pickup";
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
                'subject' => $update->subject,
                'status' => $update->status,
                'link'  =>  URL::to('/messengerial/accomplish'),
                'cao_approved_link'  =>  URL::to('/messengerial')
            );

            // Mail::to($agent->email)->cc([$employee->email])->send(new msgCreateTicket($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new msgForPickup($data));
            // Mail::to([$employee->email])->send(new msgApproved($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new msgApproved($data));


            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    // OUT FOR DELIVERY
    public function outfordel_messengerial(Request $request)
    {
        try {
            $update = Messengerial::where('id', $request->data_id)->first();
            $update->status = "Out For Delivery";
            $today = date("Y-m-d H:i:s");
            $update->out_date = $today;
            $update->driver = $request->driver;
            // $update->save();

            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();

            $data = array(
                'emp_name' => $employee->name,
                'subject' => $update->subject,
                'link'  =>  URL::to('/messengerial'),
            );

            // Mail::to($agent->email)->cc([$employee->email])->send(new msgCreateTicket($data));
            // Mail::to("paula.acedo@psrti.gov.ph")->send(new msgOutForDel($data));

            $this->itexmo("09171259293","A new ticket is ready for out for delivery. Kindly contact Admin Aide IV for more details.","TR-PAULA259293_25NMQ","7&6k!wqg}e");
            // send SMS Notif
            // Nexmo::message()->send([
            //     'to' => '639224847673',
            //     'from' => '639224847673',
            //     'text' => "A new ticket is ready for out for delivery. Kindly contact Admin Aide IV for more details."
            // ]);


            return json_encode('success');
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }
    function itexmo($number, $message, $apicode, $passwd)
    { 
        $ch = curl_init();
        $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
        curl_setopt($ch, CURLOPT_URL, "https://www.itexmo.com/php_api/api.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($itexmo));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($ch);
        curl_close($ch);
    }

    public function all_messengerial()
    {
        $messengerial = Messengerial::orderBy('id', 'desc')->get(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row
        return view('messengerial.all_messengerial', compact('messengerial')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
    }

    // MESSENGERIAL ATTACHMENT
    public function messengerial_attachment(Request $request)
    {
        try {
            $edit = Messengerial::where('id', $request->data_id)->first();
            return json_encode($edit);
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }
    }

    public function load_recipient(Request $request)
    {
        $load = MessengerialItem::where('messengerial_id', $request->messengerial_id)->get();
        return json_encode($load);
    }

    public function messengerial_mark_accomplish(Request $request)
    {
        try {
            $update = Messengerial::where('id', $request->data_id)->first();
            $update->status = "Accomplished";
            $update->returned_date = date("Y-m-d H:i:s");
            $update->save();
            $user_id = $update->user_id;
            $employee = User::select('name', 'email', 'division')->where('id', $user_id)->first();

            $data = array(
                'emp_name' => $employee->name,
                'subject' => $update->subject,
                'link'  =>  URL::to('/messengerial'),
            );

            // Mail::to([$employee->email])->send(new msgAccomplished($data));
            Mail::to("paula.acedo@psrti.gov.ph")->send(new msgAccomplished($data));

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
            $insert->recipient = $request->recipient;
            $insert->messengerial_id = $request->messengerial_id;
            $insert->remarks = $request->remarks;
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
