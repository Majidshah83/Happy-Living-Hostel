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
    <strong>Luxry Boys Hostel</strong>
    <br>
                <p style="color: #999;"> Reports : {{$data['start_date']}} - {{$data['end_date']}}</p>

</div>
<br /> <br /> <br /> <br />

<table border="0">
    <tr>

        <td>
            <p>
                <br/>
                <strong> Patient Name: </strong>
                {{$data['student']->first_name .''. $data['student']->last_name}}
                <br />

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

</table>

<br /> <br /> <br />

<h2> Fee Details </h2>

<table border="1" width="100%" cellpadding="5" style="border-collapse: collapse !important;">
    <tr>
        <th width="50%"><strong>Fee Type </strong> </th>
        <th width="30%"><strong>Created Date </strong> </th>
        <th width="20%" align="right"><strong>Amount </strong> </th>
    </tr>
   <?php $amount = 0; ?>
   @foreach($data['order'] as $order)
   <?php $amount = $amount + $order->due; ?> 
    <tr>
        <td>
           {{$order->FeeType ? $order->FeeType->title : ''}}
        </td>
        <td>{{$order->created_at->format('d/m/Y h:i:s A')}}</td>
        <td align="right">
         Rs {{number_format($order->due,2)}}
        </td>
    </tr>
    @endforeach()


    <tr>
        <td class="grey-bg"></td>

        <td class="grey-bg"><strong>Total: </strong> </td>

        <td class="grey-bg" align="right">
             <strong> Rs <?php echo number_format($amount, 2); ?> </strong>
        </td>

    </tr>

</table>

<br /> <br /> <br />

<!-- Prescriber Details -->

</body>
</html>
