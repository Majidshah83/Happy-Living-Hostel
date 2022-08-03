@extends('backend.admin.master')
@section('title','Dashboard Section')
@section('content')
    <div class="container">
        <form action="{{url('/filter-orders')}}" method="POST" id="filters_frm">
            <!--Page header-->
            <div class="page-header">

                <div class="page-leftheader">
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
            @include('backend.admin.components.messages')
            @if('Admin' == \Illuminate\Support\Facades\Auth::user()->role)
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="card bg-primary">
                            <div class="card-body">
                                <a href="{{url('/getall/expense',date('m'))}}">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h6 class="text-white">Expense</h6>
                                        <h2 class="text-white m-0 font-weight-bold">{{@$expense}}</h2>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><i class="fa fa-file-text-o fa-2x"></i></span>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="card bg-secondary">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    @php
                                        $total_collection_amount_total = 0;
                                        $fee_collected_total = 0;
                                        $calc_amount = 0;
                                        if ($total_collection_amount > 0) {
                                            $calc_amount = $total_collection_amount - $fee_collected;
                                        }

                                    @endphp
                                    <div>
                                        <h6 class="text-white">Pending collection</h6>
                                        <h2 class="text-white m-0 font-weight-bold">{{number_format($calc_amount)}}</h2>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><i class="fa fa-signal fa-2x"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="card bg-success">

                            <a href="{{url('/reports')}}">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h6 class="text-white">Fee Collection Amount</h6>
                                        <h2 class="text-white m-0 font-weight-bold">{{number_format(@$total_collection_amount)}}</h2>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><i class="fa fa-usd fa-2x"></i></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="card bg-info">
                            <div class="card-body">
                          <a href="{{url('/getall/amount/collect')}}">

                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h6 class="text-white">Fee Collected Amount</h6>
                                        <h2 class="text-white m-0 font-weight-bold">{{number_format(@$fee_collected)}}</h2>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><i class="fa fa-usd fa-2x"></i></span>
                                    </div>
                                </div>
                            </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-6">
                        <div class="card">

                         <a href="{{url('/check-in-student')}}">
                            <div class="card-body text-center list-icons">
                                <svg class="svg-icon2 text-success icon-dropshadow-success" xmlns="http://www.w3.org/2000/svg" height="100%" width="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                <p class="card-text mt-3 mb-0">Total Customers</p>
                                <p class="h2 text-center font-weight-bold">{{@$student}}</p>
                            </div>
                         </a>
                        </div>

                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="card">
                      <a href="{{url('/users')}}">
                            <div class="card-body text-center list-icons">
                                <svg class="svg-icon2 text-primary icon-dropshadow-success" xmlns="http://www.w3.org/2000/svg" height="100%" width="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                <p class="card-text mt-3 mb-0">Total Users</p>
                                <p class="h2 text-center font-weight-bold">{{@$users}}</p>
                            </div>
                        </a>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-3">
                        <div class="card">

                             <a href="{{url('/rooms')}}">
                            <div class="card-body">
                                <i class="mdi mdi-hospital-building card-custom-icon icon-dropshadow-success text-success fs-60"></i>
                                <p class=" mb-1">Total Rooms</p>
                                <h2 class="mb-1 font-weight-bold">{{@$rooms}}</h2>
                            </div>
                        </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-3">
                        <div class="card">

                            <a href="{{url('/floors')}}">
                            <div class="card-body">
                                <i class="mdi mdi-hospital-building card-custom-icon icon-dropshadow-success text-success fs-60"></i>
                                <p class=" mb-1">Total Floors</p>
                                <h2 class="mb-1 font-weight-bold">{{@$floors_count}}</h2>
                            </div>
                        </a>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-3">
                        <div class="card">
                            <a href="{{url('/total_seat')}}">
                            <div class="card-body">
                                <i class="mdi mdi-account card-custom-icon icon-dropshadow-warning text-warning fs-60"></i>
                                <p class=" mb-1">Total Seats</p>
                                <h2 class="mb-1 font-weight-bold">{{@$total_seats}}</h2>
                            </div>
                        </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-3">
                        <div class="card">

                            <a href="{{url('/vacant_seats')}}">
                            <div class="card-body">
                                <i class="mdi mdi-hospital-building card-custom-icon icon-dropshadow-success text-success fs-60"></i>
                                <p class=" mb-1">Vacant Seats</p>
                                <h2 class="mb-1 font-weight-bold">{{@$total_seats-@$total_vacant_seats}}</h2>
                            </div>
                        </a>
                        </div>
                    </div>

                </div>
               <div class="row row-deck">
                    @if(count($floors) > 0)
                        @foreach($floors as $key => $floor)
                            <div class="col-xl-4 col-md-12 col-lg-6">
                                <div class="card">
                                    <div class="card-header bg-primary mb-4">
                                        <h3 class="card-title text-white">{{@$floor->title}}</h3>
                                    </div>
                                    <div class="p-2" style="overflow: hidden; padding:10px !important;">
                                        <table class="table card-table text-nowrap" style="overflow-x:auto ; width:90%; padding:0px 15px; margin:auto;">
                                            <thead>
                                            <tr>
                                                <th class="wd-45p border-bottom-0 py-4 font-weight-bold"style="width:50px !important;">R No.</th>
                                                <th class="border-bottom-0 py-4 font-weight-bold text-center">Capacity</th>
                                                <th class="border-bottom-0 py-4 font-weight-bold text-center">Occupied</th>
                                                <th class="border-bottom-0 py-4 font-weight-bold text-center">Unoccupied</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(@$floor->rooms && count(@$floor->rooms) > 0)
                                                @foreach($floor->rooms as $k => $room)
                                                    <tr>
                                                        <td style="padding:12px 12px 12px 0 !important;">
                                                            <h5 class="text-info text-white"><span class="badge bg-info">{{@$room->room_name}}</span></h5>
                                                        </td>
                                                        <td class="w-3 text-center">
                                                            <div class="mx-auto chart-circle chart-circle-xs chart-circle-secondary mt-sm-0 mb-0 icon-dropshadow-secondary" data-value="100" data-thickness="5" data-color="#4454c3">
                                                                <canvas width="60" height="60" style="height: 40px; width: 40px;"></canvas>
                                                                <div class="mx-auto chart-circle-value text-center">{{@$room->capacity}}</div>
                                                            </div>
                                                        </td>
                                                        @php
                                                            $unoccopied = 0;
                                                            $occopied = 0;
                                                            $unoccopied = checkSpaceRoom(@$room->capacity,@$room->id);
                                                            if ($room->capacity > 0) {
                                                                $occopied = $room->capacity - $unoccopied;
                                                            }

                                                        @endphp
                                                        <td class="w-3 text-center">
                                                            <div class="mx-auto chart-circle chart-circle-xs chart-circle-secondary mt-sm-0 mb-0 icon-dropshadow-secondary" data-value="100" data-thickness="5" data-color="#2dce89">
                                                                <canvas width="60" height="60" style="height: 40px; width: 40px;"></canvas>
                                                                <div class="mx-auto chart-circle-value text-center">{{$occopied}}</div>
                                                            </div>
                                                        </td>
                                                        <td class="w-3 text-center">
                                                            <div class="mx-auto chart-circle chart-circle-xs chart-circle-secondary mt-sm-0 mb-0 icon-dropshadow-secondary" data-value="100" data-thickness="5" data-color="#f72d66">
                                                                <canvas width="60" height="60" style="height: 40px; width: 40px;"></canvas>
                                                                <div class="mx-auto chart-circle-value text-center">{{$unoccopied}}</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>
                                                        No room found.
                                                    </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
        @endif
    </div>

@stop
@section('scripts')


@endsection
