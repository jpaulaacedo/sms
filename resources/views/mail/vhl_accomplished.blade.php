<p>Hi {{ $data['emp_name'] }}!

<p>Your ticket is accomplished.

<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Messengerial</b><br>
    Purpose:<b> {{ $data['purpose'] }} </b><br>
    <br>
<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD