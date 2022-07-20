<p>Hi {{ $data['agent'] }}!

<p>{{ $data['emp_name'] }} responded to your request to reschedule Date Needed.
    <br>
    Date Needed: <b>{{ date('F j, Y g:i A', strtotime($data['old_date_needed'])) }}</b> <br>
    @if($data['pref_sched'] == "by_requestor")
<p>Preferred Schedule: <b>Set preferred schedule.</b> <br>
    Preferred Date: <b>{{ date('F j, Y g:i A', strtotime($data['pref_date'])) }}</b> <br>
    @else
<p>Preferred Schedule: <b>Proceed with the schedule set by {{ $data['agent'] }}.</b> <br>
    @endif
<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Vehicle</b><br>
    Destination:<b> {{ $data['destination'] }} </b><br>
    Purpose:<b> {{ $data['purpose'] }} </b><br>
    <br>

<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['agent_link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD