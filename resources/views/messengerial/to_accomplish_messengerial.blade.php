@extends('partials._layout')
@section('content')
<div class="card">
    <div class="card-header card-header-new card-header-dark">
        <h4 align="center"><span class="fa fa-envelope"></span>&nbsp;Messengerial To Accomplish</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- 1st col -->
            <div class="col-sm">
                &nbsp;
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
                </div>
                <div class="row">
                    <table class="table-sm table table-bordered table-striped searchTable no-footer" id="tickets_table" align="center" role="grid" aria-describedby="tickets_table_info">

                        <thead>
                            <tr class="text-center">
                                <th width="20%">Subject</th>
                                <th width="10%">Control Number</th>
                                <th width="15%">Request Date</th>
                                <th width="15%">Requested By</th>
                                <th width="10%">Status</th>
                                <th width="10%">No. of Recipients</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($messengerial as $data)
                            @if($data->status=='For CAO Approval')
                            <tr class="text-center">
                                <td>{{$data->subject}}</td>
                                <td>{{$data->control_num}}</td>
                                <td>{{ date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>
                                    <span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
                                </td>
                                <td>{{$data->count_rec}}</td>
                                <td>
                                    <a href="{{URL::to('/messengerial/recipient')}}/{{$data->id}}" class="btn btn-info btn-sm">
                                        <span class="fa fa-users"></span>

                                    </a> |
                                    </button>

                                    <a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @foreach($messengerial as $data)
                            @if($data->status=='Confirmed')
                            <tr class="text-center">
                                <td>{{$data->subject}}</td>
                                <td>{{$data->control_num}}</td>
                                <td>{{ date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>
                                    @if($data->status=='Confirmed')
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif
                                </td>
                                <td>{{$data->count_rec}}</td>
                                <td>
                                    <a href="{{URL::to('/messengerial/recipient')}}/{{$data->id}}" class="btn btn-info btn-sm">
                                        <span class="fa fa-users"></span>
                                    </a> |
                                    <button onclick="_outfordel_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-truck"></span>
                                    </button>
                                    <a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @foreach($messengerial as $data)
                            @if($data->status=='Out For Delivery')
                            <tr class="text-center">
                                <td>{{$data->subject}}</td>
                                <td>{{$data->control_num}}</td>
                                <td>{{ date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>
                                    @if($data->status == "Out For Delivery")
                                    <span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif
                                </td>
                                <td>{{$data->count_rec}}</td>
                                <td>
                                    <a href="{{URL::to('/messengerial/recipient')}}/{{$data->id}}" class="btn btn-info btn-sm">
                                        <span class="fa fa-users"></span>
                                    </a> |
                                    <button onclick="mark_accomplish_modal('{{$data->id}}')" class="btn btn-success btn-sm">
                                        <span class="fa fa-check"></span>
                                    </button>
                                 
                                    <a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @foreach($messengerial as $data)
                            @if($data->status=='Accomplished')
                            <tr class="text-center">
                                <td>{{$data->subject}}</td>
                                <td>{{$data->control_num}}</td>
                                <td>{{ date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>
                                    @if($data->status == "Accomplished")
                                    <span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif
                                </td>
                                <td>{{$data->count_rec}}</td>
                                <td>
                                    <a href="{{URL::to('/messengerial/recipient')}}/{{$data->id}}" class="btn btn-info btn-sm">
                                        <span class="fa fa-users"></span>
                                    </a> |
                                    <button class="btn btn-warning btn-sm" onclick="_attachmentAgent('{{$data->id}}')">
                                        <span class="fa fa-file"></span>
                                    </button>
                                    <a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Accomplish modal -->
<div class="modal fade" id="accomplish_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="accomplish_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="accomplish_modalLabel">
                    <span id="modal_header" class="fa fa-file"></span>&nbsp;
                    <span>Attachment/s for Request - </span>
                    <span id="ctrl_num"></span>
                </h5>
            </div>
            <input type="hidden" id="messengerial_id" name="messengerial_id">
            <div class="modal-body modal-lg">
                <div class="row">
                    <div class="col-sm">
                        <label>Recipient</label>
                        <select name="recipient" class="form-control" id="recipient"></select>
                    </div>
                    <br>
                    <div class="col-sm">
                        <label>Upload Documents </label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="attachment" name="attachment">
                            <label class="custom-file-label" for="attachment"></label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm">
                        <label>Remarks (optional)</label>
                        <!-- <input type="text" id="remarks" class="form-control"> -->
                        <textarea class="form-control" rows="5" id="remarks" name="remarks"></textarea>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm">
                        <button id="btn_editRequest" type="submit" onclick="_submitFile()" class="btn btn-info float-right">
                            <span class="fa fa-plus"></span>
                            <span>Add to List</span>
                        </button>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm">
                        <small> <span class="fa fa-exclamation-circle text-red"></span>
                            <b>Note: </b>
                            Upload attachment/s as proof that messengerial request is completed.
                        </small>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th width="25%">Recipient</th>
                                    <th width="30%">File</th>
                                    <th width="40%">Remarks</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody id="file_body">
                                <td></td>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Out For Del modal -->
<div class="modal fade" id="outfordel_modal" tabindex="-1" aria-labelledby="outfordel_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="outfordel_modalLabel">
                    <span class="fa fa-truck"></span>
                    &nbsp;Delivery Details
                </h5>
            </div>
            <!-- BLADE TO AJAX -->
            <!-- use this id below in ajax -->
            <input type="hidden" id="submit_msg_id" name="submit_msg_id">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="driver">Driver:</label>
                            </div>
                            <select class="custom-select" id="driver">
                                <option selected value="" disabled>-- select --</option>
                                <option value="Elmo">Sr. Elmo</option>
                                <option value="Ruben">Sr. Ruben</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#outfordel_modal">
                    Close
                </button>
                <button onclick="_outfordel()" class="btn btn-success">
                    <span class="fa fa-truck"></span>
                    out for delivery
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Mark Accomplish modal -->
<div class="modal fade" id="mark_accomplish_modal" tabindex="-1" aria-labelledby="mark_accomplish_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="mark_accomplish_modalLabel">
                    <span class="fa fa-envelope"></span>
                    &nbsp;Accomplishment Details
                </h5>
            </div>
            <!-- BLADE TO AJAX -->
            <!-- use this id below in ajax -->
            <input type="hidden" id="markacc_msg_id" name="markacc_msg_id">
            <div class="modal-body">
                <div class="row">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="pickup_date">Pickup Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <input type="datetime-local" class="form-control" name="pickup_date" id="pickup_date" required>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="accomplished_date">Accomplished Date</label>
                        </div>
                        <input type="datetime-local" class="form-control" name="accomplished_date" id="accomplished_date" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#mark_accomplish_modal">
                    Close
                </button>
                <button class="btn btn-success" onclick="_markAccomplish('{{$data->id}}', '{{$data->control_num}}')" class="btn btn-success btn-sm">
                    <span class="fa fa-check"></span>
                    Accomplished
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/table.js') }}"></script>
<script src="{{ asset('js/messengerial.js') }}"></script>
@endsection