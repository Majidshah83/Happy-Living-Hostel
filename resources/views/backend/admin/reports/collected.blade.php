@extends('backend.admin.master')
@section('title', 'Reporitng')
@section('content')
    <!-- Start app-content-->
    <div class="app-content page-body">
        <div class="container">

            <!--Page header-->
            <div class="page-header">
                <div class="page-leftheader">
                    <h4 class="page-title">Reporting</h4>
                </div>

            </div>
            <!--End Page header-->
            @include('backend.admin.components.messages')
            <p id="validation-errors"></p>
            <!--Row-->

            <!--Row-->
            <div class="row row-deck">

                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                               <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-nowrap">
            <thead>
            <tr>
                <th class="border-bottom-0" width="5%"> Customer NO</th>
                <th class="border-bottom-0">Customer Name</th>
                <th class="border-bottom-0">Room No</th>
                <th class="border-bottom-0">Month/Year</th>
                <th class="border-bottom-0">Total Amount</th>
                <th class="border-bottom-0">Received</th>
                <th class="border-bottom-0">Remaining Amount</th>
            </tr>
            </thead>
            <tbody>
            @if(count($list_all) > 0)
                @foreach($list_all as $list)
                    <tr>
                        <td>{{env('HOSTEL_CODE')}}{{@$list->Student->id}}</td>
                        <td>{{@$list->Student->first_name}} {{@$list->Student->last_name}}</td>
                        <td>{{@$list->roomlist->room_name}}</td>
                        <td>{{$list->month_fee}}/{{$list->year_fee}}</td>
                        <td>{{number_format($list->total_amount)}}</td>
                        <td>{{number_format($list->due_fee)}}</td>
                        <td>{{number_format($list->remaining_amount)}}</td>
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

            </div>
            <!--End row-->

        </div>
    </div><!-- end app-content-->
    </div>


@endsection()

@section('scripts')

@endsection()
