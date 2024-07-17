<x-mail::message>
<b>Dear {{$name}},</b><br>

Thank you for using Homeful website. Your consultation details are listed below. <br><br>


<b><u>Transaction Summary</u></b><br>

Reference Code: <b>{{$code}}</b><br>
Name: <b>{{$name}}</b><br>
Contact number: <b>{{$mobile}}</b><br>
Brand: <b>{{$brand}}</b><br>
Total Contract Price: <b>₱{{number_format($tcp, 2)}}</b><br>
Consulting Fee: <b>₱{{number_format($consulting_fee, 2)}}</b><br>
Mode of Payment: <b>Credit Card</b><br><br>


<b><u>Customer Support</u></b><br>

For questions about the property and services you may submit your concern/s through: 
https://www.homeful.ph/contact-us?refence_code={{$code}}<br>

<i>This is an automatically generated email, please do not reply.</i><br>
</x-mail::message>