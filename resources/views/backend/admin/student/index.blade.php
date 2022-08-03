@extends('backend.admin.master')
@section('title', 'Customer Section')
@section('content')
    <style type="text/css">
        .modal-content {
                width: 148% !important;
                margin-left: -184px !important;
            }
                .card-header {
            background-color: #4454c3;
            color: white;
        }
    </style>
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Check In Customer</h4>
            </div>
            <div class="page-rightheader ml-auto d-lg-flex d-none">
                <a href="javascript:;" class="btn btn-primary add-edit-student" data-hash-id=""><i class="fa fa-plus mr-2"></i> Add New Customer </a>
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
                        <h3 class="card-title">List Customer</h3>
                        <div class="card-options">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="student-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr class="bold">
                                        <th class="border-bottom-0" width="5%">S.no</th>
                                        <th class="border-bottom-0" width="5%"> Customer NO</th>
                                        <th class="border-bottom-0">Full Name</th>
                                        <th class="border-bottom-0">Floor No</th>
                                        <th class="border-bottom-0">Room No</th>
                                        <th class="border-bottom-0">CNIC</th>
                                        <th class="text-center border-bottom-0" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(count($students) > 0)
                                @foreach($students as $student)

                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td> {{env('HOSTEL_CODE')}}{{@$student->id}}</td>
                                        <td>
                                            {{$student->first_name}} {{$student->last_name}} 
                                        </td>
                                        <td>
                                            {{$student->floor ? $student->floor->title : ''}}
                                        </td>
                                        <td>
                                           {{$student->room ? $student->room->room_name : ''}}
                                         </td>
                                        <td>{{$student->cnic}}</td>
                                        <td>
                                            <button type="button" title="edit" class="btn btn-success btn-sm add-edit-student" data-hash-id="{{ $student->hash_id }}"><i class="fa fa-edit"></i></button>
                                            <button type="button" title="edit" class="btn btn-danger btn-sm checkout-student" data-hash-id="{{ $student->hash_id }}">Checkout</button>
                                            <a target="blank" class="btn btn-info btn-sm" href="{{url('student/fee-detail',$student->id)}}"> <i class="fa fa-amount"></i> Fee Details </a>
                                            <a target="blank" class="btn btn-info btn-sm" href="{{url('student/profile',$student->id)}}"> <i class="fa fa-amount"></i>View  Profile </a>
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

                $.ajax({

                    type: 'POST',

                    url: 'students/'+hash_id,

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

            $('.checkout-student').click(function(){

                var hash_id = $(this).attr('data-hash-id');

                $('#mc-delete-popup-dialog').addClass('modal-md');

                // Set Heading
                $('#General_bootstrap_delete_popup_heading').html('Confirmation!');

                // Set Body
                $('#General_bootstrap_delete_popup_contents').html('<p> Are you sure you want to checkout this record? </p>');

                // Set hash id
                $('#General_bootstrap_delete_popup_hash_id').val(hash_id);

                $('#General_bootstrap_delete_popup').modal({
                    backdrop: 'static',
                    keyboard: false
                });

            }); // click => .delete-banner

            $('.add-edit-student').click(function(){


                var hash_id = $(this).attr('data-hash-id');

                var request_url = (hash_id != '') ? 'students/'+hash_id+'/edit' : 'students/create' ;

                $.ajax({

                    type: "GET",


                    url: request_url,

                    // processData: false,
                    // contentType: false,

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    /*data: {

                        'hash_id' : hash_id,

                    },*/

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

                            popup_title = 'Add New Customer';

                        } else {

                            popup_title = 'Edit Customer';

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
