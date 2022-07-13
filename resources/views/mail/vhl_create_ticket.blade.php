@if($data['status'] == "For DC Approval")
<p>Hi Ma'am {{ $data['dc_name'] }}!

<p>{{ $data['emp_name'] }} created a ticket that needs your approval.

<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Vehicle</b><br>
    Destination:<b> {{ $data['destination'] }} </b><br>
    Purpose:<b> {{ $data['purpose'] }} </b><br>
    <br>

<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['dc_link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD
@else
<p>Hi Ma'am {{ $data['cao_name'] }}!

<p>{{ $data['emp_name'] }} created a ticket that needs your approval.

<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Vehicle</b><br>
    Destination:<b> {{ $data['destination'] }} </b><br>
    Purpose:<b> {{ $data['purpose'] }} </b><br>
    <br>

<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['cao_link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD
@endif
