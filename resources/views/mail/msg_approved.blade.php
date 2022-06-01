@if ($data['status'] == "For CAO Approval")
<p>Hi {{ $data['emp_name'] }}!

<p>Your ticket is approved by DC {{$data['dc']}}.

<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Messengerial</b><br>
    Subject:<b> {{ $data['subject'] }} </b><br>
    <br>

<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['dc_approved_link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD

@else
<p>Hi {{ $data['emp_name'] }}!

<p>Your ticket is approved by CAO {{$data['cao']}} and is now FOR PICKUP.

<p><b>TICKET DETAILS:</b><br>
    Request Type: <b>Messengerial</b><br>
    Subject:<b> {{ $data['subject'] }} </b><br>
    <br>

<p>Note: <b>If you are not in the office</b>, kindly connect to the PSRTI-VPN first before accessing this link: <a href="{{ $data['cao_approved_link'] }}">Vehicle and Messengerial Request System</a>.

<p>Thanks,<br>
    KMD
@endif