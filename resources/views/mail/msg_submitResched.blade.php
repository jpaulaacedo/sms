<p>Hi {{ $data['agent'] }}!

<p>{{ $data['emp_name'] }} responded to your request to reschedule Date Needed.
    <br>
    @if($data['pref_sched'] == "by_requestor")
<p>Preferred Schedule: <b>Set preferred schedule.</b> <br>
    Preferred Date: <b>{{ date('F j, Y g:i A', strtotime($data['pref_date'])) }}</b> <br>
    @else
<p>Preferred Schedule: <b>Proceed with the schedule set by {{ $data['agent'] }}.</b> <br>
    @endif
<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Messengerial</b><br>
    Recipient:<b> {{ $data['recipient'] }} </b><br>
    Agency:<b> {{ $data['agency'] }} </b><br>
    What to deliver:<b> {{ $data['delivery_item'] }} </b><br>

<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['agent_link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD