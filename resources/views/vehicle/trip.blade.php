@extends('partials._layout')
@section('css')
<style>
    .btn-right {
        text-align: right;
    }
</style>
@endsection

@section('content')
<div>
    @if(Auth::user()->user_type == 1 || Auth::user()->user_type == 4)
    <a class="btn btn-primary" href="{{URL::to('/vehicle')}}"><span class="fa fa-reply"></span> Back</a>
    @endif

    @if(Auth::user()->user_type == 2)
    @if($vehicle->status=='For DC Approval')
    <a class="btn btn-primary" href="{{URL::to('/vehicle/dc/approval')}}">
        <span class="fa fa-reply"></span> Back
    </a>
    @elseif($vehicle->status!='For DC Approval')
    <a class="btn btn-primary" href="{{URL::to('/vehicle')}}">
        <span class="fa fa-reply"></span> Back
    </a>
    @endif
    @endif

    @if(Auth::user()->user_type == 3)
    @if(Auth::user()->id != $vehicle->user_id || $vehicle->status=='Confirmed' && $vehicle->status=='Out For Delivery' && $vehicle->status=='Accomplished')
    <a class="btn btn-primary" href="{{URL::to('/vehicle/accomplish')}}">
        <span class="fa fa-reply"></span> Back
    </a>
    @elseif(Auth::user()->id == $vehicle->user_id)
    <a class="btn btn-primary" href="{{URL::to('/vehicle')}}">
        <span class="fa fa-reply"></span> Back
    </a>
    @endif
    @endif

    @if(Auth::user()->user_type == 5 && Auth::user()->id == $vehicle->user_id)
    <a class="btn btn-primary" href="{{URL::to('/vehicle')}}">
        <span class="fa fa-reply"></span> Back
    </a>
    @elseif(Auth::user()->user_type == 5 && Auth::user()->id != $vehicle->user_id)
    <a class="btn btn-primary" href="{{URL::to('/vehicle/all')}}">
        <span class="fa fa-reply"></span> Back
    </a>
    @endif

    @if(Auth::user()->user_type == 6)
    @if($vehicle->status=='For CAO Approval')
    <a class="btn btn-primary" href="{{URL::to('/vehicle/cao/approval')}}">
        <span class="fa fa-reply"></span> Back
    </a>
    @elseif($vehicle->status!='For CAO Approval')
    <a class="btn btn-primary" href="{{URL::to('/vehicle')}}">
        <span class="fa fa-reply"></span> Back
    </a>
    @endif
    @endif

</div>
<br>
<div class="card">
    <div class="card-header card-header-new card-header-dark">
        <h4 align="center">
            <span class="fa fa-truck"></span>
            &nbsp;Vehicle Request and Trip Ticket
        </h4>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-sm">
                <table>
                    <tbody>
                        <tr>
                            <td style="text-align:right">SUBJECT: &nbsp;</td>
                            <td><b>{{$vehicle->subject}}</b></td>
                        </tr>
                        <tr>
                            <td style="text-align:right">DATE OF REQUEST:&nbsp;</td>
                            <td><b>{{ date('F j, Y g:i A', strtotime($vehicle->created_at)) }}</b></td>
                        </tr>
                        @if($vehicle->status == "Accomplished")
                        <tr>
                            <td style="text-align:right">DATE ACCOMPLISHED:&nbsp;</td>
                            <td><b>{{ date('F j, Y g:i A', strtotime($vehicle->updated_at)) }}</b></td>
                        </tr>
                        @endif
                        <tr>
                            <td style="text-align:right">STATUS:&nbsp;</td>
                            <td style="color:blue"><b>{{$vehicle->status}}</b></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-info" id="basic-addon3">
                                <span class="fa fa-search">&nbsp;</span>
                                Search
                            </span>
                            <input type="text" placeholder="Type here..." class="form-control text_search" id="basic-url" aria-describedby="basic-addon3">
                        </div>
                    </div>

                    <div class="col-sm">
                        @if($vehicle->status=='Filing')
                        <button onclick="_add()" class="btn btn-outline-primary float-right">
                            <span class="fas fa-map-pin"></span>
                            &nbsp;Add Passenger
                        </button>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <table class="table-sm table table-bordered table-striped searchTable no-footer" id="tickets_table" align="center" role="grid" aria-describedby="tickets_table_info">
                        <thead>
                            <tr class="text-center">
                                <th width="10%">Date and Time Needed</th>
                                <th width="15%">Destination</th>
                                <th width="15%">Purpose of Trip</th>
                                <th width="20%">Passengers</th>
                                @if($vehicle->status=='Filing')
                                <th width="10%">Action</th>
                                @endif


                            </tr>
                        </thead>
                        <tbody>

                            @foreach($trip as $data)

                            <tr class="text-center">
                                <td>{{date('F j, Y g:i A', strtotime($data->date_needed))}}</td>
                                <td>{{$data->destination}}</td>
                                <td>{{$data->purpose}}</td>
                                <td>{{$data->passenger}}</td>

                                @if($vehicle->status=='Filing')
                                <td>
                                    <button name="edit" id="edit" onclick="_edit('{{$data->id}}')" class="btn btn-sm btn-primary edit">
                                        <span class="far fa-edit"></span>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="_delete('{{$data->id}}','{{$vehicle->id}}','{{$data->destination}}')">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@if($vehicle->status=='Filing')
<div class="card">
    <div class="card-body">
        <form action="{{URL::to('/vehicle/submit')}}" method="POST">
            @csrf

            <input type="hidden" id="submit_msg_id" name="submit_msg_id" value="{{$vehicle->id}}">
            <center><button type="submit" name="submit_button" id='submit_button' class="btn btn-success">
                    <span class="fa fa-check"></span>
                    Submit Request
                </button>
            </center>
        </form>
    </div>
</div>
@endif

<!-- TRIP/VEHICLE Modal-->
<div class="modal fade" id="trip_modal" tabindex="-1" aria-labelledby="trip_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="trip_modalLabel">
                    <span class="fa fa-truck"></span>
                    &nbsp;Vehicle Request/ Trip Ticket
                </h5>
            </div>
            <div class="modal-body">
                <form action="{{URL::to('/vehicle/trip/store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <input type="hidden" value="{{$vehicle->id}}" id="vehicle_id" name="vehicle_id">
                        <input type="hidden" id="vehicle_item_id" name="vehicle_item_id">
                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-6 border-right">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Date and Time Needed
                                                <span class="text-red">*</span>
                                            </label>
                                            <input type="datetime-local" class="form-control" name="date_needed" id="date_needed" required>
                                        </div>

                                        <div class="col-md-12">
                                            <label>Purpose of Trip</label>
                                            <span class="text-red">*</span>
                                            <textarea placeholder="purpose of trip..." id="purpose" name="purpose" class="form-control" rows="4" required></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Destination(Address)
                                                <span class="text-red">*</span>
                                            </label>
                                            <textarea placeholder="complete address..." class="form-control" rows="4" id="destination" required name="destination"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="col-md-12" id="div_single">
                                        <label>Passenger(s) &nbsp;</label>
                                        <span class="text-red">*</span>
                                        <div class="input-group">
                                            <input type="text" placeholder="Type passenger name here..." class="form-control" name="passenger" id="passenger">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" onclick="add_passenger($('#passenger').val())">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm">
                                            <label>Passenger(s): </label>
                                            <div class='scrolledTable' style='height:300px;'>
                                                <table class="table table-striped table-bordered table-sm" id="dates_table">
                                                    <tbody id="my_tbody">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#trip_modal">
                                    Close
                                </button>
                                <button id="btn_add" type="submit" class="btn btn-info">
                                    <span id="icon_submit" class="fa fa-plus"></span>
                                    <span id="btn_submit">Add to List</span>
                                </button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/vehicle.js') }}"></script>
<script src="{{ asset('js/table.js') }}"></script>
@endsection