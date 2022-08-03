@extends('backend.admin.master')
@section('title', 'Fee Section')
@section('content')
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Fee Details</h4>
            </div>
            <div class="page-rightheader ml-auto d-lg-flex d-none">
                <a href="javascript:;" class="btn btn-primary add-edit-fee" data-hash-id=""><i class="fa fa-plus mr-2"></i> Add New Fee </a>
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
                        <h3 class="card-title">List Fee</h3>
                        <div class="card-options">
                       <form method="POST" action="{{url('download-student-fee-report')}}">
                          @csrf()
                             <div class="row">
                            <input type="hidden" name="student_id" value="{{$id}}">
                              <div class="col-md-4">
                                <div class="form-group">
                                   <label class="form-label">Start Date</label>
                                   <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="start_date" required>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                   <label class="form-label">End Date</label>
                                   <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="end_date" required>
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
                                        <th class="border-bottom-0" width="5%">s.no </th>
                                        <th class="border-bottom-0">Fee Type</th>
                                        <th class="border-bottom-0">Due</th>
                                        <th class="border-bottom-0">Date</th>
                                        <th class="text-center border-bottom-0" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(count($data) > 0)
                                @foreach($data as $key => $data)

                                    <tr>
                                        <td>
                                            {{++$key}}
                                        </td>
                                        <td>
                                             {{$data->FeeType ? $data->FeeType->title : ''}}
                                        </td>
                                        <td>
                                            {{number_format($data->due)}}
                                        </td>
                                        <td>

                                           {{$data->date}}
                                         </td>
                                     
                                        <td>

                                            <button type="button" title="edit" class="btn btn-success btn-sm add-edit-fee" data-hash-id="{{ $data->hash_id }}"><i class="fa fa-edit"></i></button>

                                            <button type="button" title="edit" class="btn btn-danger btn-sm delete-fee" data-hash-id="{{ $data->hash_id }}"><i class="fa fa-times"></i></button>

                                             <a  href="{{url('student-fee-receipt',$data->id)}}" title="edit" class="btn btn-info btn-sm" > <i class="fa fa-print">Receipt </i></a>

                                        </td>
                                    </tr>
                                @endforeach
                                @endif()
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

        $(document).ready(function(){

            $('.delete-item').click(function(){

                var hash_id = $('#General_bootstrap_delete_popup_hash_id').val();
                var request_url = '{{url('fee-delete')}}/'+hash_id;
                $.ajax({

                    type: 'POST',

                    url: request_url,

                    // processData: false,
                    // contentType: false,

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    data: {

                        '_method' : 'DELETE'

                    },

                    beforeSend: function(result) {

                        // $("#loading").css("display","block");

                        $('#delete_crud_errors_div').addClass('d-none');
                        $('#delete_crud_errors_ul').html('');

                    },
                    success: function(response) {

                        // $("#loading").css("display","none");

                        // swal(response);
                        location.reload();

                    },

                    error: function(xhr, status, error) {

                        mcShowErrorsPost(xhr, status, error)
                    }

                    // success

                }); // $.ajax

            }); // click => .delete-item

            $('.delete-fee').click(function(){

                var hash_id = $(this).attr('data-hash-id');

                $('#mc-delete-popup-dialog').addClass('modal-md');

                // Set Heading
                $('#General_bootstrap_delete_popup_heading').html('Confirmation!');

                // Set Body
                $('#General_bootstrap_delete_popup_contents').html('<p> Are you sure you want to delete this record? </p>');

                // Set hash id
                $('#General_bootstrap_delete_popup_hash_id').val(hash_id);

                $('#General_bootstrap_delete_popup').modal({
                    backdrop: 'static',
                    keyboard: false
                });

            }); // click => .delete-banner

            $('.add-edit-fee').click(function(){


                var hash_id = $(this).attr('data-hash-id');

                var request_url = (hash_id != '') ? '{{url('student/fee/update')}}/'+hash_id : '{{url('student/fee/create')}}' ;

                $.ajax({

                    type: "GET",


                    url: request_url,

                    // processData: false,
                    // contentType: false,

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    data: {

                        'id' : {{$id}},

                    },

                    beforeSend: function(result) {

                        // $("#loading").css("display","block");

                        $('#crud_errors_div').addClass('d-none');
                        $('#crud_errors_ul').html('');

                    },
                    success: function(response) {

                        // $("#loading").css("display","none");

                        // swal(response);

                        var popup_title = '';

                        if(hash_id == ''){

                            popup_title = 'Add New Fee';

                        } else {

                            popup_title = 'Edit Fee';

                        } // if(hash_id == '')

                        $('#mc-popup-dialog').addClass('modal-lg');

                        // Set Heading
                        $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                        // Set Body
                        $('#crud_contents').html(response);

                        // Set Footer
                        // $('#general_bootstrap_ajax_popup_footer').prepend('');

                        $('#general_bootstrap_ajax_popup').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                    }, // success
                    error: function(xhr, status, error) {

                        mcShowErrorsGet(xhr, status, error);

                    }

                }); // $.ajax

            }); // click => .add-edit-banner

            $('#student-datatable').DataTable();

        });


    </script>
@stop
