<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .mail{font-family:Sans-serif}.mail__greeting{margin-bottom:2rem}.mail__table{border:1px solid #000;border-collapse:collapse;margin:1rem 0;text-transform:uppercase}.mail__table td,.mail__table th{border:1px solid #000;padding:1rem}.mail__table tbody th{text-align:left}.mail__email{text-transform:lowercase}.mail__footer{font-style:italic;font-size:.8rem}.mail__sender-name{color:#162da1}.mail__sender-position{font-size:1rem;font-weight:700;font-style:normal;margin-bottom:1rem}.mail__mobile{color:#0a6aa1}.mail__info{margin-top:1rem;font-style:normal}
    </style>
</head>
<body>
<div class="mail">
    <div class="mail__greeting">Hi PLDT,</div>
    <div class="mail__content">
        <div class="mail__intro">
            {{$data->details}}
        </div>
        <table class="mail__table">
            <thead>
                <tr>
                    <th colspan="2">BRANCH INFORMATION</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>CITIHARDWARE {{$branch}}</td>
                </tr>
                <tr>
                    <th>Account#</th>
                    <td>{{$data->dial ?? ''}}</td>
                </tr>
                <tr>
                    <th>{{$data->type}}#</th>
                    <td>{{$data->pid}}</td>
                </tr>
                <tr>
                    <th>Concern</th>
                    <td>{{$concern}}</td>
                </tr>
                <tr>
                    <th>Contact Person</th>
                    <td>JENNIFER</td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <td>{{$data->contact}}</td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td class="mail__email">it.support@citihardware.com</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mail__footer">
            <div>Regards,</div>
            <div class="mail__sender-name">{{$user}}</div>
            <div class="mail__sender-position">IT Support Staff</div>

            <div>Ticket ID: 12345</div>
            <div>CitiHardware Inc.</div>
            <div>Quimpo Boulevard</div>
            <div>Matina, Davao City</div>
            <div>Philippines 8000</div>
            <div>Mobile: <span class="mail__mobile">+63 923 734 3138</span></div>
            <div>Fax: (082)2961821 to 23 loc. 231</div>
            <div>Tel:  (082)2961821 to 23 loc. 226</div>
            <div class="mail__info">This e-mail message (including attachments, if any) is intended for the use of the individual or the entity to whom it is addressed and may contain information that is privileged, proprietary and confidential.  If you are not the intended recipient, you are notified that any dissemination, distribution, disclosure or copying of this communication is strictly prohibited.  If you have received this communication in error, please notify the sender and delete this E-mail message immediately. Any views or opinions expressed are solely those of the author and do not necessarily represent the Company.</div>
    </div>

</div>
</body>
</html>
