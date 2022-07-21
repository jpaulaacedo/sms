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
                                <th width="15%">Recipient</th>
                                <th width="10%">Control Number</th>
                                <th width="10%">Requested By</th>
                                <th width="10%">Request Date</th>
                                <th width="10%">Destination</th>
                                <th width="10%">Date Needed</th>
                                <th width="20%">Status</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($messengerial as $data)
                            @if($data->status=='For Assignment')
                            <tr class="text-center">
                                <td>{{$data->recipient}}</td>
                                <td>{{$data->control_num}}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    @if(App\Messengerial::same_date($data->date_needed) == 'same')
                                    <span class="right badge badge-warning">
                                        {{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}
                                    </span>
                                    @else
                                    {{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}
                                    @endif
                                </td>
                                <td>
                                    @if($data->urgency == "urgent")
                                    <span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
                                    <span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
                                    @else
                                    <span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |

                                    @if($data->pref_sched == "")
                                    <button onclick="reschedAgent_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-calendar"></span>
                                    </button>
                                    @elseif($data->pref_sched != "" || $data->pref_sched == "by_agent")
                                    <button onclick="view_reschedAgent_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-calendar"></span>
                                    </button>
                                    @endif
                                    <button onclick="_assign_modal('{{$data->id}}')" class="btn btn-success btn-sm">
                                        <span class="fa fa-id-card"></span>
                                    </button>

                                    <a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @foreach($messengerial as $data)
                            @if($data->status=='For Rescheduling')
                            <tr class="text-center">
                                <td>{{$data->recipient}}</td>
                                <td>{{$data->control_num}}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    @if(App\Messengerial::same_date($data->old_date_needed) == 'same')
                                    <span class="right badge badge-warning">
                                        {{ date('F j, Y', strtotime($data->old_date_needed)) }} <br> {{ date('g:i A', strtotime($data->old_date_needed)) }}
                                    </span>
                                    @else
                                    {{ date('F j, Y', strtotime($data->old_date_needed)) }} <br> {{ date('g:i A', strtotime($data->old_date_needed)) }}
                                    @endif
                                </td>
                                <td>
                                    @if($data->urgency == "urgent")
                                    <span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>
                                    <span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
                                    @else
                                    <span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |

                                    @if($data->view_edit == "view")
                                    <button onclick="view_reschedAgent_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-calendar"></span>
                                    </button>
                                    @else
                                    <button onclick="reschedAgentbyR_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-calendar"></span>
                                    </button>
                                    @endif
                                    <button onclick="_assign_modal('{{$data->id}}')" class="btn btn-success btn-sm">
                                        <span class="fa fa-id-card"></span>
                                    </button>

                                    <a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @foreach($messengerial as $data)
                            @if($data->status=='For CAO Approval')
                            <tr class="text-center">
                                <td>{{$data->recipient}}</td>
                                <td>{{$data->control_num}}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    @if(App\Messengerial::same_date($data->date_needed) == 'same')
                                    <span class="right badge badge-warning">
                                        {{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}
                                    </span>
                                    @else
                                    {{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}
                                    @endif
                                </td>
                                <td>
                                    @if($data->urgency == "urgent")
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>
                                    <span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
                                    @else
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif

                                </td>
                                <td>
                                    <button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |
                                    @if($data->pref_sched == "")
                                    <button onclick="reschedAgent_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-calendar"></span>
                                    </button>
                                    @elseif($data->pref_sched != "" || $data->pref_sched == "by_agent")
                                    <button onclick="view_reschedAgent_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-calendar"></span>
                                    </button>
                                    @endif
                                    <a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @foreach($messengerial as $data)
                            @if($data->status=='Confirmed')
                            <tr class="text-center">
                                <td>{{$data->recipient}}</td>
                                <td>{{$data->control_num}}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    @if(App\Messengerial::same_date($data->date_needed) == 'same')
                                    <span class="right badge badge-warning">
                                        {{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}
                                    </span>
                                    @else
                                    {{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}
                                    @endif
                                </td>
                                <td>
                                    @if($data->urgency == "urgent")
                                    <span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
                                    <span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
                                    @else
                                    <span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif
                                    <br>
                                    <small>Driver: {{$data->driver}} <br></small>
                                </td>
                                <td>
                                    <button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |
                                    <button onclick="_outfordel('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-truck"></span> Out For Delivery
                                    </button>
                                    @if($data->pref_sched == "")
                                    <button onclick="reschedAgent_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-calendar"></span>
                                    </button>
                                    @elseif($data->pref_sched != "" || $data->pref_sched == "by_agent")
                                    <button onclick="view_reschedAgent_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-calendar"></span>
                                    </button>
                                    @endif
                                    <a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @foreach($messengerial as $data)
                            @if($data->status=='Cancelled')
                            <tr class="text-center">
                                <td>{{$data->recipient}}</td>
                                <td>{{$data->control_num}}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    {{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}
                                </td>
                                <td>
                                    <span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>
                                </td>
                                <td>
                                    <button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |
                                    <button class="btn btn-warning btn-sm" onclick="_cancelReasonMessengerial('{{$data->id}}')">
                                        <span class="fa fa-times"></span> reason
                                    </button>
                                    <a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @foreach($messengerial as $data)
                            @if($data->status=='Out For Delivery')
                            <tr class="text-center">
                                <td>{{$data->recipient}}</td>
                                <td>{{$data->control_num}}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    @if(App\Messengerial::same_date($data->date_needed) == 'same')
                                    <span class="right badge badge-warning">
                                        {{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}
                                    </span>
                                    @else
                                    {{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}
                                    @endif
                                </td>
                                <td>
                                    @if($data->urgency == "urgent")
                                    <span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>
                                    <span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
                                    @else
                                    <span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif
                                    <br>
                                    <small>Driver: {{$data->driver}} <br> Departure Time: {{ date('F j, Y g:i A', strtotime($data->outfordel_date)) }}</small>
                                </td>
                                <td>
                                    <button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |
                                    <button onclick="accomplish_modal('{{$data->id}}', '{{$data->outfordel_date}}')" class="btn btn-success btn-sm">
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
                                <td>{{$data->recipient}}</td>
                                <td>{{$data->control_num}}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    {{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}
                                </td>
                                <td>
                                    <span class="right badge badge-default">{{ ucwords(strtoupper($data->status)) }}</span>
                                    <br>
                                    <small>Driver: {{$data->driver}} <br> Departure Time: {{ date('F j, Y g:i A', strtotime($data->outfordel_date)) }}
                                        <br> Accomplished date: {{ date('F j, Y g:i A', strtotime($data->accomplished_date)) }}</small>
                                </td>
                                <td>
                                    <button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |
                                    <button class="btn btn-warning btn-sm" onclick="acc_accomplish_modal('{{$data->id}}','{{$data->outfordel_date}}')">
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

<!--resched modal-->
<div class="modal fade" id="reschedAgent_modal" tabindex="-1" aria-labelledby="reschedA_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="reschedA_modalLabel">
                    <span class="fa fa-truck"></span>
                    &nbsp;For Rescheduling
                </h5>
            </div>
            <input type="hidden" id="reschedA_msg_id" name="reschedA_msg_id">
            <div class="modal-body">
                <b>Agent Portion</b>
                <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="reschedA_due_date">Date Needed:</label>
                            </div>
                            <input type="datetime-local" class="form-control" name="reschedA_due_date" id="reschedA_due_date" readonly>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="suggestA_due_date">Suggested Date:</label>
                            </div>
                            <input type="datetime-local" class="form-control" name="suggestA_due_date" id="suggestA_due_date">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Reason for Rescheduling:
                        </label>
                        <textarea class="form-control" rows="3" id="reschedA_reason" name="reschedA_reason"></textarea>
                    </div>
                </div>
                <br>
                <hr>
                <b>Requestor Portion</b>
                <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <select readonly id="prefA_sched" disabled class="custom-select" aria-label="prefA_sched">
                                <option value="by_agent">Proceed with the schedule set by Agent.</option>
                                <option value="by_requestor">Set preferred schedule.</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="prefA_date">Preferred Date:</label>
                            </div>
                            <input type="datetime-local" class="form-control" name="prefA_date" id="prefA_date" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#reschedAgent_modal">
                    Close
                </button>
                <button onclick="reschedAgent()" class="btn btn-info float-right">
                    <span class="fa fa-calendar"></span>
                    <span>Reschedule</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!--resched modal if BY_REQUESTOR PREFERRED DATE -->
<div class="modal fade" id="reschedAgentbyR_modal" tabindex="-1" aria-labelledby="reschedAbyR_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="reschedAbyR_modalLabel">
                    <span class="fa fa-calendar"></span>
                    &nbsp;For Rescheduling
                </h5>
            </div>
            <input type="hidden" id="reschedAbyR_msg_id" name="reschedAbyR_msg_id">
            <div class="modal-body">
                <b>Agent Portion</b>
                <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="reschedAbyR_due_date">Date Needed:</label>
                            </div>
                            <input type="datetime-local" class="form-control" name="reschedAbyR_due_date" id="reschedAbyR_due_date" readonly>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="suggestAbyR_due_date">Suggested Date:</label>
                            </div>
                            <input type="datetime-local" readonly class="form-control" name="suggestAbyR_due_date" id="suggestAbyR_due_date">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Reason for Rescheduling:
                        </label>
                        <textarea class="form-control" rows="3" readonly id="reschedAbyR_reason" name="reschedAbyR_reason"></textarea>
                    </div>
                </div>
                <br>
                <hr>
                <b>Requestor Portion</b>
                <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <select readonly id="prefAbyR_sched" disabled class="custom-select" aria-label="prefAbyR_sched">
                                <option value="by_agent">Proceed with the schedule set by Agent.</option>
                                <option value="by_requestor">Set preferred schedule.</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="prefAbyR_date">Preferred Date:</label>
                            </div>
                            <input type="datetime-local" class="form-control" name="prefAbyR_date" id="prefAbyR_date" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#reschedAgentbyR_modal">
                    Close
                </button>
                @if(isset($data))
                <button onclick="reschedAgent_modal('{{$data->id}}')" class="btn btn-primary btn">
                    <span class="fa fa-calendar"></span>
                    Reschedule
                </button>
                @endif
                <button onclick="acceptResched()" class="btn btn-success btn">
                    <span class="fa fa-check"></span>
                    Accept
                </button>
            </div>
        </div>
    </div>
</div>

<!--view_resched modal -->
<div class="modal fade" id="view_reschedAgent_modal" tabindex="-1" aria-labelledby="view_reschedA_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="view_reschedA_modalLabel">
                    <span class="fa fa-calendar"></span>
                    @if(isset($data))
                    @if($data->status == "For Assignment" && $data->pref_date == $data->date_needed)
                    &nbsp;Preferred Date Accepted
                    @elseif($data->status == "For Assignment" && $data->pref_sched == "by_agent")
                    &nbsp;Suggested Date Accepted
                    @else
                    &nbsp;For Rescheduling
                    @endif
                    @endif
                </h5>
            </div>
            <input type="hidden" id="view_reschedA_msg_id" name="view_reschedA_msg_id">
            <div class="modal-body">
                <b>Agent Portion</b>
                <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="view_reschedA_due_date">Date Needed:</label>
                            </div>
                            <input type="datetime-local" class="form-control" name="view_reschedA_due_date" id="view_reschedA_due_date" readonly>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="view_suggestA_due_date">Suggested Date:</label>
                            </div>
                            <input type="datetime-local" readonly class="form-control" name="view_suggestA_due_date" id="view_suggestA_due_date">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Reason for Rescheduling:
                        </label>
                        <textarea class="form-control" rows="3" readonly id="view_reschedA_reason" name="view_reschedA_reason"></textarea>
                    </div>
                </div>
                <br>
                <hr>
                <b>Requestor Portion</b>
                <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <select id="view_prefA_sched" disabled class="custom-select" aria-label="view_prefA_sched">
                                <option value="by_agent">Proceed with the schedule set by Agent.</option>
                                <option value="by_requestor">Set preferred schedule.</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="view_prefA_date">Preferred Date:</label>
                            </div>
                            <input type="datetime-local" class="form-control" name="view_prefA_date" id="view_prefA_date" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#view_reschedA_modal">
                    Close
                </button>
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
                    <span>Mark</span>
                    <span id="control_num"></span>
                    <span>as Accomplished</span>
                </h5>
            </div>
            <input type="hidden" id="messengerial_id" name="messengerial_id">
            <div class="modal-body modal-lg">
                <div class="row">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="outfordel_date">Departure Time</label>
                        </div>
                        <input type="datetime-local" class="form-control" readonly name="outfordel_date" id="outfordel_date">

                        &nbsp;&nbsp;
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="accomplished_date">Accomplished Date</label>
                        </div>
                        <input type="datetime-local" class="form-control" name="accomplished_date" id="accomplished_date" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Remarks <small>(optional)</small></label>
                        <textarea class="form-control" rows="4" id="remarks" name="remarks"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm">
                        <label>Upload Documents <small> &nbsp;<span class="fa fa-exclamation-circle text-red"></span>
                                <b>Note: </b>
                                Upload documents as proof that messengerial request is accomplished.
                            </small></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="attachment" name="attachment">
                            <label class="custom-file-label" for="attachment"></label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm">
                        @if(isset($data))
                        <button id="btn_editRequest" type="submit" onclick="_submitFile()" class="btn btn-info float-right">
                            <span class="fa fa-plus"></span>
                            <span>Add to List</span>
                        </button>
                        @endif
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th width="30%">File</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody id="file_body">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" onclick="_markAccomplish()" class="btn btn-success btn-sm">
                        <span class="fa fa-check"></span>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- View Accomplish modal -->
<div class="modal fade" id="acc_accomplish_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="acc_accomplish_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="acc_accomplish_modalLabel">
                    <span id="modal_header" class="fa fa-file"></span>&nbsp;
                    <span>Attachment - </span>
                    <span id="acc_control_num"></span>
                </h5>
            </div>
            <input type="hidden" id="acc_msg_id" name="acc_msg_id">
            <div class="modal-body modal-lg">
                <div class="row">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="acc_outfordel_date">Departure Time</label>
                        </div>
                        <input type="datetime-local" class="form-control" readonly name="acc_outfordel_date" id="acc_outfordel_date">

                        &nbsp;&nbsp;
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="acc_accomplished_date">Accomplished Date</label>
                        </div>
                        <input type="datetime-local" class="form-control" name="acc_accomplished_date" readonly id="acc_accomplished_date">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Remarks</label>
                        <textarea class="form-control" rows="4" id="acc_remarks" name="acc_remarks" readonly></textarea>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-sm">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th width="30%">File</th>
                                </tr>
                            </thead>
                            <tbody id="acc_file_body">
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

<!-- Assign modal -->
<div class="modal fade" id="assign_modal" tabindex="-1" aria-labelledby="assign_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="assign_modalLabel">
                    <span class="fa fa-calendar"></span>
                    &nbsp;Assign Driver
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
                                <option value="Elmo">Elmo</option>
                                <option value="Ruben">Ruben</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="pickup_date">Pick-up Date:</label>
                            </div>
                            <input type="datetime-local" class="form-control" name="assigned_pickupdate" id="assigned_pickupdate" required>

                        </div>
                    </div>
                </div> -->
            </div>
            <div class="modal-footer">


                <button class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#assign_modal">
                    Close
                </button>
                <button onclick="_assign()" class="btn btn-success">
                    <span class="fa fa-truck"></span>
                    Assign
                </button>
            </div>
        </div>
    </div>
</div>

<!-- cancel modal -->
<div class="modal fade" id="cancel_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="cancel_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="cancel_modalLabel">
                    <span class="fa fa-times"></span>&nbsp;
                    <span id="cancel_header"> Cancel Request </span>
                </h5>
            </div>
            <form action="{{URL::to('/messengerial/cancel')}}" method="POST">
                @csrf
                <input type="hidden" id="msg_cancel_id" name="msg_cancel_id">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm">
                            <label id="lbl_reason">Reason for Cancellation </label>
                            @if(isset($data))
                            @if($data->status=='Cancelled')
                            <textarea id="cancel_reason" rows="4" class="form-control" name="cancel_reason" readonly></textarea>
                            @else
                            <textarea id="cancel_reason" rows="4" class="form-control" name="cancel_reason" placeholder="Type here..."></textarea>
                            @endif
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div id="cancel_note" class="col-sm">
                            <small>
                                <span class="fa fa-exclamation-circle text-red"></span>
                                <span><b>Note:</b> Make sure to provide reason if you want to cancel your request.</span>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @if(isset($data))
                    @if($data->status!='Cancelled' || $data->status!='Filing')
                    <button id="btn_cancelRequest" type="submit" class="btn btn-warning">
                        <span id="icon_submit" class="fa fa-times"></span>
                        <span id="btn_cancel">Cancel</span>
                    </button>
                    @endif
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Messengerial Modal-->
<div class="modal fade" id="view_msg_modal" tabindex="-1" aria-labelledby="view_msg_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="view_msg_modalLabel">
                    <span class="fa fa-user"></span>
                    &nbsp;Recipient Details
                </h5>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <input type="hidden" id="view_messengerial_id" name="view_messengerial_id">
                    <div class="col-sm">

                        <div class="row">
                            <div class="col-sm">
                                <label>Recipient
                                    <span class="text-red">*</span>
                                </label>
                                <input readonly type="text" id="view_recipient" name="view_recipient" class="form-control" rows="5" required>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="view_urgency" id="view_urgency" value="not_urgent">
                                        <label class="form-check-label" for="view_urgency">
                                            Not Urgent
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="view_urgency" id="view_urgency" value="urgent">
                                        <label class="form-check-label" for="view_urgency">
                                            Urgent
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        &nbsp;

                        <div class="row">
                            <div class="col-sm-4">
                                <label>Agency/Office
                                    <span class="text-red">*</span>
                                </label>
                                <input readonly type="text" id="view_agency" name="view_agency" class="form-control" rows="5" required>
                            </div>
                            <div class="col-sm-4">
                                <label>Contact #
                                    <span class="text-red">*</span>
                                </label>
                                <input readonly type="text" name="view_contact" id="view_contact" class="form-control" required />
                            </div>
                            <div class="col-sm-4">
                                <label>Date Needed
                                    <span class="text-red">*</span>
                                </label>
                                <input type="datetime-local" class="form-control" readonly name="view_due_date" id="view_due_date" required>
                            </div>
                        </div>

                        &nbsp;

                        <div class="row">
                            <div class="col-sm">
                                <label>Destination(Address)
                                    <span class="text-red">*</span>
                                </label>
                                <textarea readonly class="form-control" rows="3" id="view_destination" required name="view_destination"></textarea>
                            </div>
                        </div>
                        &nbsp;

                        <div class="row">
                            <div class="col-sm">
                                <label>What to Deliver
                                    <span class="text-red">*</span>
                                    <small>
                                        If multiple items, separate using comma(,).
                                    </small>
                                </label>
                                <textarea readonly class="form-control" required rows="3" id="view_delivery_item" name="view_delivery_item"></textarea>
                            </div>
                            <div class="col-sm">
                                <label>Instruction</label>
                                <textarea readonly id="view_instruction" name="view_instruction" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        &nbsp;

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#view_msg_modal">
                                Close
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
<script src="{{ asset('js/table.js') }}"></script>
<script src="{{ asset('js/messengerial.js') }}"></script>
@endsection