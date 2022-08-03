<!DOCTYPE html>
<html lang="en">
<head>

  
    <style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
}
  .grey-bg{
            background-color: #d3d3d3;
        }

</style>

</head>

<body>

<input type='button' id='btn' value='Print' onclick='printDiv();'>

<div id='DivIdToPrint'>

<div align="center">
    <h1>{{env('HOSTEL_NAME')}}</h1>
</div>
<br /> 
  
    <style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
}
  .grey-bg{
            background-color: #d3d3d3;
        }

</style>

<div align="left">
              

</div>
<div align="right">
    <p><strong>Alloted Room No </strong> </p>
    <p><strong>Hostel Registration No </strong></p>
</div>
<hr>

<h2>Application Information</h2>

<table style="width:100%">
  <tr class="">
        <td width="10%"><b>SR</b>
        </td>
        <td width="40%"><b >Particulars</b>
        </td>
        <td width="40%"><b>Amount</b>
        </td>
  </tr>

  <tr class="">
        <td width="10%"><b>1</b>
        </td>
        <td width="40%"><b >Particulars</b>
        </td>
        <td width="40%"><b>Amount</b>
        </td>
  </tr>

    <tr>
        <td width="10%" >
            1

        </td>
        <td width="40%" >
            Admission Fee

        </td>
        <td width="40%" >
            {{$fee_details->admission_fee}}
        </td>
    </tr>
    <tr>
        <td width="10%" >
            2

        </td>
        <td width="40%" >
            Security Deposit

        </td>
        <td width="40%">
          {{$fee_details->security_fee}}
        </td>
    </tr>

    <tr>
        <td width="10%" >
            3

        </td>
        <td width="40%" >
            Rent Per Month

        </td>
        <td width="40%" >
            {{$fee_details->hostel_fee}}
        </td>
    </tr>
    <tr>
        <td width="10%" >
            4
        </td>
        <td width="40%" >
            Late Fee Fine

        </td>
        <td width="40%" >
            {{$fee_details->late_fee_fine}}
        </td>
    </tr>
    <tr>
        <td width="10%" >
            5

        </td>
        <td width="40%" >
            Ac/Fridge/Gayser Charges

        </td>
        <td width="40%" >
              {{$fee_details->gayser_fee+$fee_details->ac_fee}}
        </td>
    </tr>

    <tr>
        <td width="10%" >
            6

        </td>
        <td width="40%" >
            Electricity Charges

        </td>
        <td width="40%" >
            {{$fee_details->electricty_fee}}
        </td>
    </tr>

    <tr>
        <td width="10%" >
            7

        </td>
        <td width="40%" >
            Pre Remaing Amount

        </td>
        <td width="40%" >
            {{$amount}}
        </td>
    </tr>

    <tr>
        <td width="50%" colspan="2" align="center" style="text-align: center;">
           <strong>Total Amount</strong> 
        </td>
        <td width="40%" >
            {{number_format($fee_details->total_amount)}}
        </td>
    </tr>
    <tr >
        <td width="50%" colspan="2" align="center" style="text-align: center;">
            <strong>Received Amount</strong>

        </td>
        <td width="40%" >
            {{number_format($fee_details->due_fee)}}
        </td>
    </tr>
    <tr>
        <td width="50%" colspan="2" align="center" style="text-align: center;">
           <strong> Remaining Balance Amount</strong>
        </td>
        <td width="40%" >
            {{number_format($fee_details->remaining_amount)}}
        </td>
    </tr>
 
</table>
<br /> 

<table width="100%" border="0" cellpadding="0">
    <tr><td width="100%">
            <h2>Important Notes</h2>
            <p>Late fee fine will charged Rs.200 per day 5th of every month .
                <br>Hostel adminstration fee is Rs. 2000 per resident .
                
                <br>Hostel dues are monthly and not refundable .

                <br>Security not refundable without two monthes written notice.
                <br>Security deposite is not refundable leaving before four monthes.
                <br>AC and Geyser will be charged separately .
                <br>Maintenance Charges Rs. 300 per month will be deducated for from security deposit .
                <br>If i failed to submit hostel Rent till 10 of any month , management can cancel<br> my seat & removed my luggage & i will not
                demand luggage from hostel managment.
            </p>
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
</body>
<script type="text/javascript">
  function printDiv() 
{

  var divToPrint=document.getElementById('DivIdToPrint');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
</script>
</html>
