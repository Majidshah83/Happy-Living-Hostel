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
              @if(@$student->image)

<table border="0">
    <tr>
        <td>
                <img src="{{asset('storage/student/'.$student->image)}}" width="60" height="70" alt="" title="" />
        </td>
    </tr>
</table>
            @endif()

</div>
<div align="right">
    <p><strong>Alloted Room No </strong> :     {{$student->room ? $student->room->room_name : ''}}</p>
    <p><strong>Hostel Registration No </strong> :{{env('HOSTEL_CODE')}}{{@$student->id}}</p>
</div>
<hr>

<h2>Application Information</h2>

<table style="width:100%">
  <tr>
    <th>Full Name:    </th>
    <td> {{$student->first_name}} {{$student->last_name}}</td>
  </tr>
  <tr>
    <th>CNIC no:</th>
    <td>{{$student->cnic}}</td>
  </tr>
  <tr>
    <th>Nationalty:</th>
    <td>{{$student->nationality}}</td>
  </tr>
  <tr>
    <th>University/Employee Name:</th>
    <td>{{$student->uni_company_name}}</td>
  </tr>
    <tr>
    <th>University/Employee Id:</th>
    <td>{{$student->uni_company_id}}</td>
  </tr>
  <tr>
    <th>Department/Feculty:</th>
    <td>{{$student->department_faculty}}</td>
  </tr>
   <tr>
    <th>Cell No:</th>
    <td>{{$student->mobile_number}}</td>
  </tr>
  <tr>
    <th>Email:</th>
    <td>{{$student->email}}</td>
  </tr>
  <tr>
    <th>Father/Guardian Name:</th>
    <td>{{$student->father_name}}</td>
  </tr>
  <tr>
    <th>Father/Guardian Cell:</th>
    <td>{{$student->father_cell_no}}</td>
  </tr>
  <tr>
    <th>Relation With Guardian:</th>
    <td>{{$student->relation_with_guardian}}</td>
  </tr>
  <tr>
    <th>Occupation:</th>
    <td>{{$student->father_accupation}}</td>
  </tr>
  <tr>
    <th>Home Address:</th>
    <td>{{$student->address}}</td>
  </tr>
  <tr>
    <th>City:</th>
    <td>{{$student->city}}</td>
  </tr>
  <tr>
    <th>Home Cell No:</th>
    <td>{{$student->home_number}}</td>
  </tr>
</table>
<br /> 

<div>
<p><span>Guardian Singature: __________________</span></p>
<p><span >Customer Singature &amp; Thumb Impersion: __________________</span></p></div>
<p>  <span>Hostel Warden Singature: __________________</span></p>
<p> <span >Hostel Director Singature :__________________</span></p>
</div>
<br>
<div>
<span>Admission Rent(PKR):{{$student->admission_fee}}</span>
<span align="right" style="
    margin-left: 10%;
">Monthely Rent(PKR :{{$student->monthely_fee}}</span>
<span style="
    margin-left: 15%;
">Admission Date: {{$student->admission_date}}</span>
</div>
<br>
</div>
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
