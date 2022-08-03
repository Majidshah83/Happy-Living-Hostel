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
        border-top: black 1px solid bold;
        border-bottom: black 1px solid bold;
        border-left: black 1px solid bold;
        border-right: black 1px solid bold;
        border-spacing:0;
    }
    .pd-table-1>tr>td {
        border: none;
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
        border-top: black 2px solid;
        border-bottom: none !important;
        border-left: black 2px solid;
        border-right: black 2px solid;
        border-collapse: collapse;

    }
    .pd-table-3>tr>td {
        border: black 3px solid;
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
    .text-font{
        font-size: 12px;
    }

</style>
</head>
<body>
<br>
<table width="100%" class="pd-table-1" cellpadding="3" cellspacing="3">
    <tr class="section-heading">
        <th width="100%" align="center" style="border-bottom: black 1px solid bold">
            <b ><span style="font-size:20px">Happy Living Boys Hostel</span>
                <br>
            </b>
        </th>
    </tr>
    
    <tr>
        <td width="50%" >
            <span class="text-font">Paid Date</span>:  {{date('d-m-Y', strtotime($fee_details->created_at))}}
        </td>
        <td width="50%" class="text-font">
            Next due date:  <?php $new_date = date("d-m-Y", strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00')); ?>

                {{$new_date}}
        </td>
    </tr>
    <tr>
        <td width="50%" >
            <span class="text-font">Payment Type</span>: @if(!empty($fee_details) && $fee_details->payment_type == 'offline') Cash @else Online @endif
        </td>
        @if(!empty($fee_details) && $fee_details->payment_type == 'online')
            <td width="50%" class="text-font">
                Payment Company: {{$fee_details->payment_company}}
            </td>
        @endif
    </tr>
    @if(!empty($fee_details) && $fee_details->payment_type == 'online')
        <tr>
            <td width="50%" class="text-font">
                Trasaction Id: {{$fee_details->transaction_id}}
            </td>
        </tr>
    @endif
    <tr>
        <td width="50%" class="text-font">
            Name:{{@ucfirst($fee_details->Student->first_name) .' '. @ucfirst($fee_details->Student->last_name)}}

        </td>
        <td width="50%" class="text-font">
            Resident Cell#: {{@$fee_details->Student->home_number}}

        </td>
    </tr>

    <tr>
        <td width="50%" class="text-font" >
            Reg No: {{env('HOSTEL_CODE')}}{{@$fee_details->Student->id}}

        </td>
        <td width="50%" class="text-font" >
            Rent for Month:  <?php $month = [ "01" => "January", "02" =>"February", "03" =>"March", "04" =>"April", "05" =>"May", "06" =>"June", "07" =>"July",
                 "08" =>"August", "09" =>"September", "10" =>"October", "11" =>"November", "12" =>"December"]; ?>
                {{@$month[$fee_details->month_fee]}}

        </td>
    </tr>

    <tr>
        <td width="50%" class="text-font">
            CNIC: {{@$fee_details->Student->cnic}}


        </td>
        <td width="50%" class="text-font">
            Room No:{{@$fee_details->Student->room->room_name}}

        </td>
    </tr>

    <tr>
        <td width="100%" >
            <table width="110%" class="pd-table-3" cellpadding="4">
                <tr class="">
                    <td width="10%"><b>SR</b>
                    </td>
                    <td width="40%"><b >Particulars</b>
                    </td>
                    <td width="40%"><b>Amount</b>
                    </td>
                </tr>

                <tr>
                    <td width="10%" class="text-font">
                        1

                    </td>
                    <td width="40%" class="text-font">
                        Admission Fee

                    </td>
                    <td width="40%" class="text-font">
                        {{number_format($fee_details->admission_fee)}}
                    </td>
                </tr>
                <tr>
                    <td width="10%" class="text-font">
                        2

                    </td>
                    <td width="40%" class="text-font">
                        Security Deposit

                    </td>
                    <td width="40%" class="text-font">
                      {{number_format($fee_details->security_fee)}}
                    </td>
                </tr>

                <tr>
                    <td width="10%" class="text-font">
                        3

                    </td>
                    <td width="40%" class="text-font">
                        Rent Per Month

                    </td>
                    <td width="40%" class="text-font">
                        {{number_format($fee_details->hostel_fee)}}
                    </td>
                </tr>
                <tr>
                    <td width="10%" class="text-font">
                        4
                    </td>
                    <td width="40%" class="text-font">
                        Late Fee Fine

                    </td>
                    <td width="40%" class="text-font">
                        {{number_format($fee_details->late_fee_fine)}}
                    </td>
                </tr>
                <tr>
                    <td width="10%" class="text-font">
                        5

                    </td>
                    <td width="40%" class="text-font">
                        Ac/Fridge/Gayser Charges

                    </td>
                    <td width="40%" class="text-font">
                          {{number_format($fee_details->gayser_fee+$fee_details->ac_fee)}}
                    </td>
                </tr>

                <tr>
                    <td width="10%" class="text-font">
                        6

                    </td>
                    <td width="40%" class="text-font">
                        Electricity Charges

                    </td>
                    <td width="40%" class="text-font">
                        {{number_format($fee_details->electricty_fee)}}
                    </td>
                </tr>

                <tr>
                    <td width="10%" class="text-font">
                        7

                    </td>
                    <td width="40%" class="text-font">
                        Pre Remaing Amount

                    </td>
                    <td width="40%" class="text-font">
                        {{number_format($amount)}}
                    </td>
                </tr>

                <tr >
                    <td width="50%" colspan="2" align="center" >
                       <strong> Total Amount</strong>

                    </td>
                    <td width="40%" >
                        {{number_format($fee_details->total_amount)}}
                    </td>
                </tr>
                <tr >
                    <td width="50%" colspan="2" align="center">
                        <strong>Received Amount</strong>

                    </td>
                    <td width="40%" >
                        {{number_format($fee_details->due_fee)}}
                    </td>
                </tr>
                <tr >
                    <td width="50%" colspan="2" align="center">
                       <strong> Remaining Balance Amount</strong>
                    </td>
                    <td width="40%" >
                        {{number_format($fee_details->remaining_amount)}}
                    </td>
                </tr>

            </table>

        </td>
    </tr>
   
</table>

<table width="100%" border="0" cellpadding="0">
    <tr><td width="100%">
            <h2>Important Notes</h2>
            {!! getPageSection('fee-instruction') !!}
        </td>
    </tr>
    <tr><td></td></tr>
    <tr><td width="50%"><br><h3>Resident Signature</h3>
        </td>
    </tr>
    <tr><td width="50%"><br><br><h3>Admin Signature</h3>
        </td>
    </tr>
</table>
<br>
</body>
</html>