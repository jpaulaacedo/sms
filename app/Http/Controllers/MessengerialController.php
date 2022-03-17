<?php

namespace App\Http\Controllers;

use App\Messengerial;
use App\MessengerialItem;
use Auth;
use Illuminate\Http\Request;

class MessengerialController extends Controller
{
    public function index()
    {

        $messengerial = Messengerial::orderBy('id', 'desc')->get(); //variable name = model_name::yourcondition(); get()=multiplerec while first()=1 row
        return view('messengerial', compact('messengerial')); //return view('folder.blade',compact('variable','variable2', 'variable....'));
    }

    public function store_request(Request $request)
    {
        try {
            $insert = new Messengerial;
            $insert->subject = $request->subject; //$insert->dbcolumn = $request->input name fr blade
            $insert->status = 'filing';
            $insert->user_id = Auth::user()->id;
            $current_rec = count(Messengerial::all());
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
            
            $insert->control_num = date("Y-m") . "-" . $new_rec;
            $insert->save();

            return redirect()->back()->with('message', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
}
