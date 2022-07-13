<p>Hi {{ $data['agent'] }}!

<p>{{ $data['emp_name'] }} created a ticket that is now FOR ASSIGNMENT.

<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Messengerial</b><br>
    Recipient:<b> {{ $data['recipient'] }} </b><br>
    Agency:<b> {{ $data['agency'] }} </b><br>
    What to deliver:<b> {{ $data['delivery_item'] }} </b><br>
    <br>

<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['agent_link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD