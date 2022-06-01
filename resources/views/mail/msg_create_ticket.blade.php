<p>Hi Ma'am {{ $data['dc_name'] }}!

<p>{{ $data['emp_name'] }} created a ticket that needs your approval.

<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Messengerial</b><br>
    Subject:<b> {{ $data['subject'] }} </b><br>
    <br>

<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD