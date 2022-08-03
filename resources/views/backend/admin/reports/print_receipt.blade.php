<!DOCTYPE html>
<html lang="en">
<head>

    <style type="text/css">
        .grey-bg{
            background-color: #d3d3d3;
        }
    </style>

</head>

<div align="center">
    <h1>{{env('HOSTEL_NAME')}}</h1>
    <p> Reports :    <?php $month = [ "01" => "January", "02" =>"February", "03" =>"March", "04" =>"April", "05" =>"May", "06" =>"June", "07" =>"July",
                 "08" =>"August", "09" =>"September", "10" =>"October", "11" =>"November", "12" =>"December"]; ?>
                {{@$month[$month_fee]}} {{$year_fee}}</p>
</div>
<br /> <br /> <br /> <br />

{{-- <table border="0">
    <tr>

        <td>
            <p>


                <strong> CNIC: </strong>
                {{$data['student']->cnic}}

                <br />

                <strong> Address: </strong>

                 {{$data['student']->address}}


                <br />

                <strong> Contact Number: </strong>
                 {{$data['student']->mobile_number}}

            </p>

        </td>

        <td align="right">


        </td>

    </tr>

</table> --}}



<table border="1" width="100%" cellpadding="5" style="border-collapse: collapse !important;">

    <tr>
        <th><strong>Customer NO </strong> </th>
        <th ><strong>Customer Name </strong> </th>
        <th ><strong> Room No </strong> </th>
        <th><strong>Month/Year</strong></th>
        <th><strong> Total Amount </strong> </th>
        <th><strong> Received </strong> </th>
        <th><strong>Remaining Amount </strong> </th>
    </tr>
        <?php $total_amount = $due_fee = $remaining_amount = 0; ?>
        @foreach($data['order'] as $list)
           <tr>
            <td>{{env('HOSTEL_CODE')}}{{@$list->Student->id}}</td>
            <td>{{@$list->Student->first_name}} {{@$list->Student->last_name}}</td>
            <td>{{@$list->roomlist->room_name}}</td>
            <td>{{$list->month_fee}}/{{$list->year_fee}}</td>
            <td>{{number_format($list->total_amount)}}</td>
            <td>{{number_format($list->due_fee)}}</td>
            <td>{{number_format($list->remaining_amount)}}</td>
          </tr>
          <?php

             $total_amount = $total_amount+$list->total_amount;
             $due_fee = $due_fee+$list->due_fee;
             $remaining_amount = $remaining_amount+$list->remaining_amount;

          ?>
        @endforeach()


    <tr>
        <td class="grey-bg"></td>
        <td class="grey-bg"></td>
        <td class="grey-bg"></td>
        <td class="grey-bg"></td>
        <td class="grey-bg">{{number_format($total_amount)}}</td>
        <td class="grey-bg">{{number_format($due_fee)}}</td>
        <td class="grey-bg">{{number_format($remaining_amount)}}</td>
    </tr>

</table>

<br /> <br /> <br />

<!-- Prescriber Details -->

</body>
</html>
