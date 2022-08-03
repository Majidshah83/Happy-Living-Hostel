<option value=""> Select Student</option>
@foreach($students as $student)
   <option value="{{$student->id}}" >{{$student->first_name}} {{$student->last_name}}</option>
@endforeach
