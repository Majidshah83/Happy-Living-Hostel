@extends('backend.admin.master')
@section('title', 'Fee Section')
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
                        <h3 class="card-title">List Fee </h3>
                        <div class="card-options">

                        </div>
                       
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="student-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr class="bold">
                                        <th class="border-bottom-0" width="5%"> Sr</th>
                                        <th class="border-bottom-0" width="5%"> Customer NO</th>
                                        <th class="border-bottom-0">Customer Name</th>
                                        <th class="border-bottom-0">Room No</th>
                                        <th class="border-bottom-0">Month/Year</th>
                                        <th class="border-bottom-0">Total Amount</th>
                                        <th class="border-bottom-0">Recived</th>
                                        <th class="border-bottom-0">Rem Amount</th>
                                        <th class="text-center border-bottom-0" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list_fee as $list)
                                       <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{env('HOSTEL_CODE')}}{{@$list->Student->id}}</td>
                                        <td>{{@$list->Student->first_name}} {{@$list->Student->last_name}}</td>
                                        <td>{{@$list->roomlist->room_name}}</td>
                                        <td>{{$list->month_fee}}/{{$list->year_fee}}</td>
                                        <td>{{$list->total_amount}}</td>
                                        <td>{{$list->due_fee}}</td>
                                        <td>{{$list->remaining_amount}}</td>
                                        <td> <button type="button" title="edit" class="btn btn-success btn-sm add-edit-fee" data-hash-id="{{ $list->hash_id }}"><i class="fa fa-edit"></i></button>
                                        <a target="blank" href="{{url('fee-details-print',$list->hash_id)}}" title="edit" class="btn btn-primary btn-sm" ><i class="fa fa-print"></i></a>
                                         <button type="button" title="edit" class="btn btn-danger btn-sm delete-fee" data-hash-id="{{ $list->hash_id }}"><i class="fa fa-times"></i></button>
                                    </td>
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

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function(){

            $(document).on("change","#student",function() {

                id = $(this).val();
                 $.ajax({

                type: 'post',

                url: '{{url('get-student-balanace')}}',

                // processData: false,

                // contentType: false,

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {'id':id},

                beforeSend: function(result) {

                    // $("#loader").show();
                    // $("#add-edit-student-btn").attr("disabled", true);
                    // $('#add-edit-student-btn').html('Loading..');

                    // $('#crud_errors_div').addClass('d-none');
                    // $('#crud_errors_ul').html('');

                },
                success: function(response) {
                    $('#remaining_amount').val(response);
                      let total_amount = $('#total_amount').val();
                      total_amount = parseInt(response) + parseInt(total_amount);
                     $('#total_amount').val(total_amount);

                    // $("#add-edit-student-btn").attr("disabled", false);
                    // $('#add-edit-student-btn').html('Submit');
                    // $("#loading").css("display","none");
                    // // swal(response);
                    // location.reload();
                    // $('#loader').delay(2000).hide(100);


                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-student-btn").attr("disabled", false);
                    $('#add-edit-student-btn').html('Submit');
                    mcShowErrorsPost(xhr, status, error);
                }

                // success

            }); // $.ajax

        });

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


            // $('.add-edit-fee').click(function(){

            // $(document).click('.add-edit-fee' ,function()

            $(document).on("click",".add-edit-fee",function() {


                var hash_id = $(this).attr('data-hash-id');

                var request_url = (hash_id != '') ? 'student-fee/'+hash_id+'/edit' : 'student-fee/create' ;

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




    </script>
@stop
