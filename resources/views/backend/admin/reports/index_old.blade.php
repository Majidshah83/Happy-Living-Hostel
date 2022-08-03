@extends('backend.admin.master')
@section('title', 'Fee Section')
@section('content')
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Reports Fee</h4>
            </div>
        </div>
        <div class="row">
          
        </div>
        <!--Row-->
            @include('backend.admin.components.messages')
        <!--Row-->
        <!--End Page header-->
        <div class="row row-deck">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reports Fee</h3>
                        <div class="card-options">
                       
                        <form method="POST" action="{{url('download-student-fee-reports')}}" target="blank">
                         
                          @csrf()

                            <?php 
                             $months = ['01' => 'January','02' => 'February','03' => 'March','04' => 'April' ,'05' => 'May','06' => 'June','07' => 'July','08' => 'August','09' => 'September','10' => 'October','11' => 'November','12' => 'December'];
                             $current_month = date('m');
                            ?>

                            <div class="row">
                              <div class="col-md-3">
                                  <div class="form-group">
                                     <label class="form-label">Select Month</label>
                                     <select name="month_fee" class="form-control" id="month_fee">
                                        @foreach($months as $key => $month)
                                          <option value="{{$key}}" @if(empty($edit_details) && $key == $current_month) selected @endif>{{$month}}</option>
                                        @endforeach()
                                     </select>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <?php 
                                     $current_year = date('Y');
                                  ?>
                                  <div class="form-group">
                                    <label class="form-label">Select Year</label>
                                    <select name="year_fee" class="form-control" id="year_fee">
                                          {{ $last= date('Y')-60 }}
                                          {{ $now = date('Y') }}
                                          @if(!empty($edit_details))
                                             <option value="{{$edit_details->year_fee}}">{{$edit_details->year_fee}}</option>  
                                          @endif
                                          @for ($i = $now; $i >= $last; $i--)
                                              <option value="{{ $i }}" >{{ $i }}</option>
                                          @endfor
                                     </select>
                                  </div>
                              </div>
                              <div class="col-md-3 mt-5">
                                  <button class="btn btn-indigo " type="submit" id="add-edit-category-btn"><i class="fa fa-print"> </i> Download Report </button>
                              </div>
                            </div>

                        </form>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                             <table id="student-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr class="bold">
                                        <th class="border-bottom-0" width="5%"> Student NO</th>
                                        <th class="border-bottom-0">Student Name</th>
                                        <th class="border-bottom-0">Room No</th>
                                        <th class="border-bottom-0">Month/Year</th>
                                        <th class="border-bottom-0">Total Amount</th>
                                        <th class="border-bottom-0">Recived</th>
                                        <th class="border-bottom-0">Remaining Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list_fee as $list)
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

