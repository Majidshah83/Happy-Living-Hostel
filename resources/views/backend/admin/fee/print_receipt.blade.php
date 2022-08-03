<!DOCTYPE html>
<html lang="en">
<head>



    <style>
    .section-heading>th {
        color: black;
    }
    .section-sub-heading>td {
        color: black;
    }

    .section-heading{
        background-color: white;
        color: black !important;
        border-bottom: 2px solid black;
    }
    .section-sub-heading {
        background-color: #d9d9d9;
        color: black !important;
    }
    table {
        border-collapse: collapse;
    }

    .age-box {
        width: 190px !important;
        height: 190px !important;
        border: 1px solid black;
    }

    .td7 {
        border-left: #000000 1px solid;
        border-right: #000000 1px solid;
        border-top: #000000 1px solid;
        border-bottom: #000000 1px solid;
        padding: 0px;
        margin: 0px;
        width: 60px;
        vertical-align: bottom;
    }

    .no-in-official {
        float: right !important;
        text-align: right !important;
    }

    .pd-table-1 {
        border: black 3px solid;
    }
    .pd-table-1>tr>td {
        border: black 2px solid;
    }
    .sub-heading-3{
        font-size: 9px !important;
    }

    .pd-table-2 {
        border: black 2px solid;
    }
    .pd-table-2>tr>td {
        border: black 2px solid;
    }

    .sub-heading-4{
        font-size: 8px !important;
    }
    .special-h1{
        margin-bottom: 30px !important;
    }

    .pd-table-3 {
        border: black 2px solid;
    }
    .pd-table-3>tr>td {
        border: black 2px solid;
    }

    .pd-table-4 {
        border: black 2px solid;
    }

    .pd-table-5 {
        border: black 2px solid;
    }
    .pd-table-5>tr>td {
        border: black 2px solid;
    }


    .top-heading{
        font-size: 10px !important;
        font-weight: bold !important;
    }
    .cell-background-color{
        background-color: #d9d9d9;
    }
    .total-text{
        font-size: 10px !important;
        font-weight: bold !important;
    }

</style>

</head>

<div align="center">
    <h1>{{env('HOSTEL_NAME')}}</h1>
</div>
<table border="0">
    <tr>

        <td>
            <p> <strong>Rent Paid Date: </strong> {{date('d-m-Y', strtotime($fee_details->created_at))}}
 
                <br><strong> Student Name: </strong>{{@ucfirst($fee_details->Student->first_name) .' '. @ucfirst($fee_details->Student->last_name)}}
                <br />
                <strong> CNIC: </strong>
                {{@$fee_details->Student->cnic}}
                <br />

                <strong> Address: </strong>

                 {{@$fee_details->Student->address}}

               
                <br />

                <strong> Contact Number: </strong>
                 {{@$fee_details->Student->mobile_number}}

                 <br>
                 <strong>Student No: </strong>
                {{env('HOSTEL_CODE')}}{{@$fee_details->Student->id}}

                <br>
                <strong>Room No: </strong>
                {{@$fee_details->Student->room->room_name}}

                <br>
                <strong>Month: </strong>

               <?php $month = [ "01" => "January", "02" =>"February", "03" =>"March", "04" =>"April", "05" =>"May", "06" =>"June", "07" =>"July",
                 "08" =>"August", "09" =>"September", "10" =>"October", "11" =>"November", "12" =>"December"]; ?>
                {{@$month[$fee_details->month_fee]}}

            </p>

        </td>

        <td align="right">

            <h1 style="color: #999;"> RECEIPT </h1>
            <p>

                <strong> Receipt No: </strong>
                444{{ $fee_details->id }}
                <br />
                <strong>Next Due Date: </strong>
                <?php $new_date = date("d-m-Y", strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00')); ?>

                {{$new_date}}

                 
            </p>

        </td>

    </tr>

</table>

<strong><hr>
</strong>
<h2> Fee Details </h2>

<table border="1" width="100%" cellpadding="5" style="border-collapse: collapse !important;">
    <tr>
        <th width="70%"><strong>Fee Type </strong> </th>
        <th width="20%" align="right"><strong>Amount </strong> </th>
    </tr>

   
    <tr>
        <td>
          Admission Fee
        </td>
        <td align="right">
         {{$fee_details->admission_fee}}
        </td>
    </tr>
    <tr>
        <td>
          Hostel Fee
        </td>
        <td align="right">
        {{$fee_details->hostel_fee}}
        </td>
    </tr>
    <tr>
        <td>
          Security Fee
        </td>
        <td align="right">
         {{$fee_details->security_fee}}
        </td>
    </tr>
    <tr>
        <td>
          Ac Fee
        </td>
        <td align="right">
         {{$fee_details->ac_fee}}
        </td>
    </tr>
    <tr>
        <td>
          Gayser Charges
        </td>
        <td align="right">
         {{$fee_details->gayser_fee}}
        </td>
    </tr>
    <tr>
        <td>
          Late Fee Fine
        </td>
        <td align="right">
         {{$fee_details->late_fee_fine}}
        </td>
    </tr>
    <tr>
        <td>
          Miscellaneous Fee
        </td>
        <td align="right">
         {{$fee_details->miscellaneous_fee}}
        </td>
    </tr>

     <tr>
        <td>
          Electricty Fee
        </td>
        <td align="right">
         {{$fee_details->electricty_fee}}
        </td>
    </tr>
    <tr>

        <td class="grey-bg"><strong> Previous Remaining Amount : </strong> </td>

        <td class="grey-bg" align="right">
             <strong>Rs {{$amount}}</strong>
        </td>

    </tr>
    <tr>

        <td class="grey-bg"><strong> Total Amount : </strong> </td>

        <td class="grey-bg" align="right">
             <strong>Rs {{number_format($fee_details->total_amount)}}</strong>
        </td>

    </tr>

     <tr>

        <td class="grey-bg"><strong> Recived Amount : </strong> </td>

        <td class="grey-bg" align="right">
             <strong>Rs {{number_format($fee_details->due_fee)}}</strong>
        </td>

    </tr>

    <tr>
        <td class="grey-bg"><strong> Balance : </strong> </td>
        <td class="grey-bg" align="right">
             <strong>Rs {{number_format($fee_details->remaining_amount)}}</strong>
        </td>
    </tr>


</table>
<p><strong>Important Notes :</strong></p>
<ul>
  <li>Late fee fine will charged Rs.200 per day 5th of every month .    
  </li>
  <li>Hostel Dues are monthely not refundable. .</li>
  <li>AC and Gayser charges will be charge seperately.</li>
  <li>Maintence Charges Rs 300/month will be deducted from deposit.</li>
  <li>Security Deposit is not refundable before leaving five monthes.</li>
  <li>Security is not refundable without two month notice before leaving.</li>
  <li>If i failed to submit hostel Rent till 10 of any month , management can cancel my seat & removed my luggage & i will not demand luggage from hostel managment.</li>
  </li>
</ul>

<strong><hr>
</strong> 
<P>Signature Student __________________</P>
<br>
<P>Signature Admin __________________</P>

<!-- Prescriber Details -->

</body>
</html>
