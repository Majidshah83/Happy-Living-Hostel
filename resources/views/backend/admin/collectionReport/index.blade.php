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
                <h4 class="page-title">Current Month Amount Report</h4>

            </div>


        </div>

<div class="card-header">
    <h3 class="card-title">Reports Fee</h3>
    <div class="card-options">
    </div>
</div>
<div class="card-body">
    <div class="row mb-3">

       @include('backend.admin.components.pagination_dp')


        <div class="col-md-6 text-left">
            <form method="POST" action="{{url('download-student-fee-reports')}}" target="blank">

                @csrf()
            <div class="row">
                @php
                    $months = ['01' => 'January','02' => 'February','03' => 'March','04' => 'April' ,'05' => 'May','06' => 'June','07' => 'July','08' => 'August','09' => 'September','10' => 'October','11' => 'November','12' => 'December'];
                    $current_month = date('m');
                    $current_year = date('Y');
                @endphp
                <div class="col-md-3">
                    <div class="form-group">
                        {{--                    <label class="form-label">Status</label>--}}
                        <select class="form-control add_filters" name="status" id="status">
                            <option class="" selected="selected" value="">Report Type</option>
                            <option value="all" {{ (!empty($post_arr) && @$post_arr['status'] == 'all') ? 'selected' : '' }}>All</option>
                            <option value="" {{ (!empty($post_arr) && @$post_arr['status'] == '') ? 'selected' : '' }}>Not All</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{--                    <label class="form-label">Select Month</label>--}}
                        <select name="month" class="form-control add_filters" id="month">
                            <option class="" selected="selected" value="">Month</option>
                            @foreach($months as $key => $month)
                                <option value="{{$key}}"  {{ (!empty($post_arr) && @$post_arr['month'] == $key) ? 'selected' : '' }} @if(empty($post_arr['month']) && $key == $current_month) selected @endif>{{$month}}</option>
                            @endforeach()
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{--                    <label class="form-label">Select Year</label>--}}

                        <select name="year" class="form-control add_filters" id="year">
                            <option class="" selected="selected" value="">Year</option>
                            @php
                                $last= date('Y')-60;
                                $now = date('Y');
                            @endphp
                            @for ($i = $now; $i >= $last; $i--)
                                <option value="{{ $i }}" {{ (!empty($post_arr) && @$post_arr['year'] == $i) ? 'selected' : '' }} @if(empty($post_arr['year']) && $i == $current_year) selected @endif>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button class="btn btn-indigo " type="submit" id="add-edit-category-btn"><i class="fa fa-print"> </i> Report </button>
                    </div>
                </div>
            </div>
            </form>

        </div>

        <div class="col-md-3">
            <div class="input-group float-right">
                <input type="text" class="form-control" placeholder="Search for ..." id="cdt_search" value="{{ !empty($post_arr['cdt_search']) ? $post_arr['cdt_search'] : '' }}" mc-parent-id="mc-cdt" />
                <span class="input-group-append">
                    <button class="btn btn-primary cdt_search" type="button" ><i class="fa fa-search"></i></button>
                </span>
            </div>
        </div>

    </div>

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
            {{-- @if(count($list_all) > 0)
                @foreach($list_all as $list) --}}
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                {{-- @endforeach()
            @else
                <tr>
                    <td colspan="7" class="text-center">
                        <p>No data found</p>
                    </td>
                </tr>
            @endif --}}

            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-5">

            {{-- Showing {{ $list_all->firstItem() }} - {{ $list_all->lastItem() }} of {{ $list_all->total() }} entries --}}

            {{-- <input type="hidden" id="cdt_pagination_page_no" value="{{ !empty($post_arr) ? $post_arr['page'] : '1' }}" readonly="readonly" /> --}}


        </div>
        <div class="col-sm-12 col-md-7 mc-cdt-links-div" mc-parent-id="mc-cdt">

                {{-- {{ $list_all->links() }} --}}

        </div>
    </div>
</div>
</div>
@stop
@section('scripts')
<script>
    $(document).ready(function() {
        $('.add_filters').unbind().change(function(){
            $('#mc-cdt').find('#cdt_pagination_page_no').val('1');
            refresh_cdt('mc-cdt');
        });
    } );
</script>
@stop


