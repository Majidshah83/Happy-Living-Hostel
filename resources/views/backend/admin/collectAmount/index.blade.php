@extends('backend.admin.master')
@section('title', 'Amount Collect Section')
@section('content')
<style>
    .card-header{
        background-color:blue;
        color: white;
    }
</style>
 <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Collect Amount Report</h4>

            </div>

        <div class="page-leftheader">



           <h6>Total Amount:&nbsp;&nbsp;{{$monthly_fee}} </h6>

        </div>
        </div>
        <!--Row-->
            @include('backend.admin.components.messages')
        <!--Row-->
        <!--End Page header-->
        <div class="row row-deck">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">

                        <div class="card-options">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="expense-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr class="bold">
                 <th class="border-bottom-0" width="5%"> Customer NO</th>
                <th class="border-bottom-0">Customer Name</th>
                <th class="border-bottom-0">Room No</th>
                <th class="border-bottom-0">Total Amount</th>


                                        {{-- <th class="text-center border-bottom-0" width="10%">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
            @if(count($list_all) > 0)
                @foreach($list_all as $list)
                    <tr>
                        <td>{{env('HOSTEL_CODE')}}{{@$list->id}}</td>
                        <td>{{@$list->first_name}} {{@$list->last_name}}</td>

                        <td>{{$list->room->room_name}}</td>
                        <td>{{$list->monthely_fee}}</td>

                    </tr>
                @endforeach()
            @else
                <tr>
                    <td colspan="7" class="text-center">
                        <p>No data found</p>
                    </td>
                </tr>
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
<script>
    //data table
    $('#expense-datatable').DataTable();
</script>

@stop
