<p>Hi {{ $data['emp_name'] }}!

<p>Your ticket is now OUT FOR DELIVERY.

<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Messengerial</b><br>
    Recipient:<b> {{ $data['recipient'] }} </b><br>
    Agency:<b> {{ $data['agency'] }} </b><br>
    What to deliver:<b> {{ $data['delivery_item'] }} </b><br>
    Driver: <b>{{ $data['driver'] }}</b><br>
    Pickup Schedule: <b>{{ date('F j, Y g:i A', strtotime($data['pickup_date'])) }}</b><br>

<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD