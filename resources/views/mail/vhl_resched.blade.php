<p>Hi {{ $data['emp_name'] }}!

<p>Your ticket is RESCHEDULED to {{ date('F j, Y g:i A', strtotime($data['date_needed'])) }} .
    <br>
    Reason for Rescheduling: {{ $data['resched_reason'] }}
    <br>
<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Vehicle</b><br>
    Destination:<b> {{ $data['destination'] }} </b><br>
    Purpose:<b> {{ $data['purpose'] }} </b><br>
    <br>

<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD