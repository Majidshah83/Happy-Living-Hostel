@extends('backend.admin.master')
@section('title', 'Rooms Section')
@section('content')
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Rooms</h4>
            </div>
            <div class="page-rightheader ml-auto d-lg-flex d-none">
                <a href="javascript:;" class="btn btn-primary add-edit-faq" data-hash-id=""><i class="fa fa-plus mr-2"></i> Add Room</a>
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
                        <h3 class="card-title">List Rooms</h3>
                        <div class="card-options">
                         <h6 style="margin-right: 20px;font-size: 15px;color: black;">Total Seats:{{@$total_seats}}</h6>
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
                                        <th class="text-center border-bottom-0" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                            <td>
                                                <button type="button" title="edit" class="btn btn-success btn-sm add-edit-faq" data-hash-id="{{ $room->hash_id }}"><i class="fa fa-edit"></i></button>

                                                  <button type="button" title="edit" class="btn btn-danger btn-sm delete-room" data-hash-id="{{ $room->hash_id }}"><i class="fa fa-times"></i></button>

                                            </td>
                                        </tr>
                                    @endforeach
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

                    url: 'rooms/'+hash_id,

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

                        // console.log( xhr.responseJSON.error_msg );
                        mcShowErrorsPost(xhr, status, error);
                    }

                    // success

                }); // $.ajax

            }); // click => .delete-item

            $('.delete-room').click(function(){

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

            $('.add-edit-faq').click(function(){

                var hash_id = $(this).attr('data-hash-id');

                var request_url = (hash_id != '') ? 'rooms/'+hash_id+'/edit' : 'rooms/create' ;

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

                            popup_title = 'Add New Room';

                        } else {

                            popup_title = 'Edit Room';

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
