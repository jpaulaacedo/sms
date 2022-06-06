<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/', 'HomeController@index');

// Auth::routes(['register' => false]);
Auth::routes(['register' => true]);

Route::get('/home', 'HomeController@index')->name('home');

// REQUESTING STAFF
Route::get('/messengerial', 'MessengerialController@index');

Route::post('/messengerial/store', 'MessengerialController@messengerial_store');

// View Recipient
Route::get('/messengerial/recipient/{messengerial_id}', 'MessengerialController@get_recipient');

Route::get('/messengerial_form/{messengerial_id}', 'MessengerialController@print_messengerial');

Route::post('/messengerial/recipient/store', 'MessengerialController@store_recipient');

Route::post('/messengerial/submit', 'MessengerialController@submit_messengerial');

// DC APPROVAL
Route::get('/messengerial/dc/approval', 'MessengerialController@dc_approval_messengerial');

// CAO APPROVAL
Route::get('/messengerial/cao/approval', 'MessengerialController@cao_approval_messengerial');

// AGENT TO ACCOMPLISH
Route::get('/messengerial/accomplish', 'MessengerialController@to_accomplish_messengerial');

Route::get('/messengerial/report', 'MessengerialController@report_messengerial');

Route::post('/messengerial/recipient/edit', 'MessengerialController@edit_recipient');

Route::post('/messengerial/recipient/delete', 'MessengerialController@delete_recipient');

Route::post('/messengerial/edit', 'MessengerialController@edit_messengerial');

Route::post('/messengerial/cancel', 'MessengerialController@cancel_messengerial');

Route::post('/messengerial/cancel_reason', 'MessengerialController@cancel_reason_messengerial');

Route::post('/messengerial/delete', 'MessengerialController@delete_messengerial');

//change status if 'out for delivery is clicked'
Route::post('/messengerial/accomplish/change_status', 'MessengerialController@change_status');

Route::post('/messengerial/dc/approve', 'MessengerialController@approveDC_messengerial');

Route::post('/messengerial/cao/approve', 'MessengerialController@approveCAO_messengerial');

Route::post('/messengerial/accomplish/outfordel', 'MessengerialController@outfordel_messengerial');

//all messengerial
Route::get('/messengerial/all', 'MessengerialController@all_messengerial');


Route::post('/messengerial/accomplish', 'MessengerialController@accomplish_modal');

Route::post('/messengerial/attachment', 'MessengerialController@messengerial_attachment');


Route::post('/load_recipient', 'MessengerialController@load_recipient');

Route::post('/messengerial/mark_accomplish', 'MessengerialController@messengerial_mark_accomplish');

Route::post('/load_file', 'MessengerialController@load_file');

Route::post('/submit_file', 'MessengerialController@submit_file');

Route::post('/delete_file', 'MessengerialController@delete_file');

Route::post('/messengerial/check_monthly_report', 'MessengerialController@messengerial_check_monthly_report');

Route::get('/messengerial/monthly_report/{month}/{year}', 'MessengerialController@messengerial_monthly_report');



//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~



//VEHICLE
Route::get('/vehicle', 'VehicleController@index');

Route::post('/vehicle/store', 'VehicleController@vehicle_store');

Route::get('/vehicle/all', 'VehicleController@all_vehicle');

Route::get('/vehicle/trip/{vehicle_id}', 'VehicleController@get_trip');

Route::post('/vehicle/edit', 'VehicleController@edit_vehicle');

Route::post('/vehicle/delete', 'VehicleController@delete_vehicle');

Route::post('/vehicle/trip/store', 'VehicleController@store_trip');

Route::post('/vehicle/trip/edit', 'VehicleController@edit_trip');

Route::post('/vehicle/trip/delete', 'VehicleController@delete_trip');

Route::post('/vehicle/submit', 'VehicleController@submit_vehicle');

Route::get('/vehicle/dc/approval', 'VehicleController@dc_approval_vehicle');

Route::post('/vehicle/dc/approve', 'VehicleController@approveDC_vehicle');

Route::get('/vehicle/cao/approval', 'VehicleController@cao_approval_vehicle');

Route::post('/vehicle/cao/approve', 'VehicleController@approveCAO_vehicle');

Route::get('/vehicle/accomplish', 'VehicleController@to_accomplish_vehicle');

Route::post('/vehicle/accomplish/otw', 'VehicleController@otw_vehicle');

Route::post('/vehicle/mark_accomplish', 'VehicleController@vehicle_mark_accomplish');

Route::post('/vehicle/attachment', 'VehicleController@vehicle_attachment');

Route::post('/load_destination', 'VehicleController@load_destination');

Route::post('/vehicle/load_file', 'VehicleController@vehicle_load_file');

Route::post('/vehicle/submit_file', 'VehicleController@vehicle_submit_file');

Route::post('/vehicle/delete_file', 'VehicleController@vehicle_delete_file');

Route::post('/vehicle/cancel', 'VehicleController@cancel_vehicle');

Route::post('/vehicle/cancel_reason', 'VehicleController@cancel_reason_vehicle');

Route::get('/vehicle/report', 'VehicleController@report_vehicle');

Route::post('/vehicle/check_monthly_report', 'VehicleController@vehicle_check_monthly_report');

Route::get('/vehicle/monthly_report/{month}/{year}', 'VehicleController@vehicle_monthly_report');

Route::post('/vehicle/trip/passenger', 'MessengerialController@add_passenger');

Route::post('/vehicle/add/passenger', 'VehicleController@add_passenger');

Route::post('/vehicle/add/passengertolist', 'VehicleController@passengertolist');

Route::post('/vehicle/delete/passengertolist', 'VehicleController@del_passengertolist');

Route::post('/vehicle/view/passenger', 'VehicleController@view_passenger');

Route::post('/vehicle/view/vehicle', 'VehicleController@view_vehicle');

Route::get('/vehicle_form/{vehicle_id}', 'VehicleController@print_vehicle');

Route::post('/calendar/feed', 'HomeController@feed_calendar');

Route::get('/vehicle/calendar/view', 'VehicleController@vehicle_calendar');

// Route::get('/send-mail', function(){

//     $details = [
//         'body' => 'This is a sample email notification'
//     ];
//     \Mail::to('vamrs.psrti@gmail.com')->send(new \App\Mail\TestMail($details));
//     echo "Email has been sent successfully";
// });