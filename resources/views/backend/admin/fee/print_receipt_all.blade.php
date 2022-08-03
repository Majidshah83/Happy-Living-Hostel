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
</div>
<br /> <br /> <br /> <br />

<table border="0">
    <tr>
      <td>
          <p><strong>Customer Name: </strong>{{@$students->first_name .' '. @$students->last_name}}<br /><strong>CNIC: </strong>
              {{@$students->cnic}}
              <br /><strong>Address: </strong>{{@$students->address}}<br /><strong>Contact Number: </strong>{{@$students->mobile_number}}<br><strong>Customer No: </strong>{{env('HOSTEL_CODE')}}{{@$students->id}}
          </p>
        </td>

 
    </tr>

</table>

<br /> <br /> <br />

<h2> Fee Details </h2>

<table border="1"  cellpadding="5" style="border-collapse: collapse !important;width:550px !important">
        
        <tr>
          <th>Month</th>
          <th>Admission</th>
          <th>Hostel</th>
          <th>Security</th>
          <th>Ac</th>
          <th>Gayser</th>
          <th>Late</th>
          <th>Mis</th>
          <th>electric</th>
          <th>Pervious</th>
          <th>Total</th>
          <th>Recived</th>
          <th>Remaining</th>
        </tr>
       <?php  $total_amount = 0; ?>
       <?php $due_fee = 0;?>
        @foreach($fee_details as $fee)
            <tr>
              <td>{{$fee->month_fee}}/{{$fee->year_fee}}</td>
              <td>{{$fee->admission_fee}}</td>
              <td>{{$fee->hostel_fee}}</td>
              <td>{{$fee->security_fee}}</td>
              <td>{{$fee->ac_fee}}</td>
              <td>{{$fee->gayser_charges}}</td>
              <td>{{$fee->late_fee_fine}}</td>
              <td>{{$fee->miscellaneous_fee}}</td>
              <td>{{$fee->electricty_fee}}</td>
              <td>{{$fee->total_amount-($fee->admission_fee+$fee->hostel_fee+$fee->security_fee+$fee->ac_fee+$fee->gayser_charges+$fee->late_fee_fine+$fee->miscellaneous_fee+$fee->electricty_fee)}}</td>
              <td>{{$fee->total_amount}}</td>
              <td>{{$fee->due_fee}}</td>
              <td>{{$fee->total_amount-$fee->due_fee}}</td>
            </tr>
            <?php $total_amount = $total_amount+$fee->total_amount; ?>
            <?php $due_fee = $due_fee+$fee->due_fee; ?>
        @endforeach()
        <tr>
            <td class="grey-bg" colspan="9"><strong> Total Amount </strong> </td>
            <td class="grey-bg" align="right" colspan="4">
                 <strong>Rs {{number_format($total_amount)}}</strong>
            </td>
        </tr>
        <tr>
            <td class="grey-bg" colspan="9"><strong> Recived Amount </strong> </td>
            <td class="grey-bg" align="right" colspan="4">
                 <strong>Rs {{number_format($due_fee)}}</strong>
            </td>
        </tr>
        <tr>
            <td class="grey-bg" colspan="9"><strong> Remaining Amount </strong> </td>
            <td class="grey-bg" align="right" colspan="4">
                 <strong>Rs {{number_format($total_amount-$due_fee)}}</strong>
            </td>
        </tr>

</table>

<!-- Prescriber Details -->

</body>
</html>
