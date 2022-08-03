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
                        </div>
                        <div class="card-body">
                                     <form method="POST" action="{{url('download-excell-order')}}">
                                  @csrf()
                                 <div class="row">
                                   
                                     <div class="col-md-6 offset-3">
                                        <div class="form-group">
                                           <label class="form-label">Select Date</label>
                                           <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="date" required>
                                        </div>
                                     </div>
                                  
                                  
                                  </div>

                                    <div class="row">
                                     <div class="col-md-6 offset-3">
                                        <div class="form-group">
                                           <label class="form-label">Select Services</label>
                                           <select class="form-control"  name="service" required>
                                            <option value="all">All</option>
                                            @foreach($services as $service)
                                               <option value="{{$service->id}}">{{$service->title}}</option>
                                            @endforeach()
                                           </select>

                                        </div>
                                     </div>
                                 </div>

                                 <div class="row">
                                     <div class="col-md-6 offset-3">
                                        <div class="form-group">
                                           <label class="form-label">Select Status</label>
                                           <select class="form-control"  name="order_status" required>
                                        <option value="all">
                                            All </option>
                                        <option value="P">
                                            Pending </option>
                                        <option value="R">
                                            Refunded </option>
                                        <option value="O">
                                            On-hold </option>
                                        <option value="C">
                                            Completed </option>
                                        </select>
                                        </div>
                                     </div>                                  
                                    </div>
                                    <hr />

                                    <div class="row">
                                        <div class="col-md-3 offset-9">
                                          <button class="btn btn-indigo" type="submit" id="add-edit-category-btn">Download Excell Sheet</button>
                                        </div>
                                    </div>

                                </form>

                               {{-- 
                                <a class="btn btn-success" href="{{url('export')}}">Download Excell All</a>
                                <a class="btn btn-success" href="{{url('export','66')}}">Download Excell Day 2</a>
                                <a class="btn btn-success" href="{{url('export','67')}}">Download Excell Day 2 & 8 </a>
                                <br> --}}
                                
                                <!-- <a class="btn btn-danger mt-4" href="{{url('export-pdf')}}">Download Pdf All</a> -->

                                {{-- <a class="btn btn-warning mt-4" href="{{ url('export-pdf-orders') }}"> Download Pdf </a> --}}


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
