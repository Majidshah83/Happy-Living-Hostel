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
    <strong>Report {{$fee_details->month_fee}}/{{$fee_details->year_fee}}</strong>

</div>

<br>



<table border="1" width="100%" cellpadding="5" style="border-collapse: collapse !important;">
     <tr>
        <td>
          Salary
        </td>
        <td align="right">
         {{$fee_details->salary}}
        </td>
    </tr>
    <tr>
        <td>
          Electricty Bill
        </td>
        <td align="right">
        {{$fee_details->electricty_bill}}
        </td>
    </tr>
    <tr>
        <td>
          Net Bill
        </td>
        <td align="right">
         {{$fee_details->net_bill}}
        </td>
    </tr>
    <tr>
        <td>
          Gas Bill
        </td>
        <td align="right">
         {{$fee_details->gas_bill}}
        </td>
    </tr>
    <tr>
        <td>
          Rent
        </td>
        <td align="right">
         {{$fee_details->rent}}
        </td>
    </tr>
    <tr>
        <td>
          Sabzi
        </td>
        <td align="right">
         {{$fee_details->sabzi}}
        </td>
    </tr>
    

     <tr>
        <td>
          Daily Expense
        </td>
        <td align="right">
         {{$fee_details->daily_expense}}
        </td>
    </tr>
    <tr>
        <td>
          Miscellaneous
        </td>
        <td align="right">
         {{$fee_details->misc}}
        </td>
    </tr>
  
    <tr>

        <td class="grey-bg"><strong> Total Expense Amount : </strong> </td>

        <td class="grey-bg" align="right">
             <strong>Rs {{number_format($fee_details->total_amount)}}</strong>
        </td>

    </tr>

     <tr>

        <td class="grey-bg"><strong> Total Rent : </strong> </td>

        <td class="grey-bg" align="right">
             <strong>Rs {{number_format($fee_details->total_rent)}}</strong>
        </td>

    </tr>

    <tr>
        <td class="grey-bg"><strong> Profit / Loss  : </strong> </td>
        <td class="grey-bg" align="right">
             <strong>Rs {{number_format($fee_details->remaining_amount)}}</strong>
        </td>
    </tr>


</table>


</body>
</html>
