@if ($data['status'] == "For Assignment")
<p>Hi {{ $data['emp_name'] }}!

<p>Your ticket is APPROVED by DC {{$data['dc']}}.

<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Vehicle</b><br>
    Destination:<b> {{ $data['destination'] }} </b><br>
    Purpose:<b> {{ $data['purpose'] }} </b><br>
    <br>

<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['dc_approved_link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD

@else
<p>Hi {{ $data['emp_name'] }}!

<p>Your ticket is APPROVED by CAO {{$data['cao']}}. <br>
<p>Please handover the documents to Mr. Percus Imperio.</p>
<br>
<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Vehicle</b><br>
    Destination:<b> {{ $data['destination'] }} </b><br>
    Purpose:<b> {{ $data['purpose'] }} </b><br>
    Driver: <b>{{ $data['driver'] }}</b><br>
    <br>

<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['cao_approved_link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD
@endif