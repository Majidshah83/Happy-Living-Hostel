@extends('backend.admin.master')
@section('title', 'Vacant Seats Section')
@section('content')
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title" >Vacant Seats</h4>

            </div>
            <?php
           $total_vant=$total_capicity-$total_vacant_seats;
            ?>
             <h5 style="color:black !important;">Total Vacant Seats: {{$total_vant}}</h5>
        </div>
        <!--Row-->
        @include('backend.admin.components.messages')
        <!--Row-->
          <!--End Page header-->
        <div class="row row-deck">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List Vacant Seats</h3>

                        <div class="card-options">


                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="faq-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr class="bold">
                                        <th class="border-bottom-0">Floor</th>
                                        <th class="border-bottom-0">Room</th>
                                        <th class="border-bottom-0">Capacity</th>
                                        <th class="border-bottom-0">Vacant</th>

                                    </tr>
                                </thead>
                                <tbody>
                                       @if(count($rooms)>0)
                                        @foreach($rooms as $room)
                                        <tr>
                                            <td>
                                                @if($room->floor)
                                                    {{$room->floor->title}}
                                                @endif
                                            </td>
                                            <td>
                                                {!! $room->room_name !!}
                                            </td>

                                            <td>
                                                {!! $room->capacity !!}
                                            </td>
                                                       @php
                                                         $unoccopied = 0;
                                                            $occopied = 0;
                                                            $unoccopied = checkSpaceRoom(@$room->capacity,@$room->id);
                                                            if ($room->capacity > 0) {
                                                                $occopied = $room->capacity - $unoccopied;
                                                             }

                                                        @endphp

                                      <td> {{$unoccopied}}</td>
                                        </tr>
                                 @endforeach
                                 @else
                                 <td>
                                   Room data not Found
                                 </td>
                                 @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     <!--End row-->
    </div>
    <!-- end app-content-->
@stop

@section('scripts')
    <script type="text/javascript">



            $('#faq-datatable').DataTable();
            $('#description').summernote({
                  height: 100,                 // set editor height
            });
            $('#edit_description').summernote({
                  height: 100,                 // set editor height
            });
        });



    </script>
@stop
