<p>Hi {{ $data['emp_name'] }}!

<p>Your ticket is ACCOMPLISHED.

<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Messengerial</b><br>
    Recipient:<b> {{ $data['recipient'] }} </b><br>
    Driver: <b>{{ $data['driver'] }}</b><br>
    Pickup Date: <b>{{ date('F j, Y g:i A', strtotime($data['pickup_date'])) }}</b><br>
    Accomplished Date: <b>{{ date('F j, Y g:i A', strtotime($data['accomplished_date'])) }}</b><br>
    <br>
<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD