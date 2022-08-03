@extends('backend.admin.master')
@section('title', 'Pages List')
@section('content')
    <div class="app-content page-body">
        <div class="container">
            <!--Page header-->
            <div class="page-header">
                <div class="page-leftheader">
                    <h4 class="page-title">Pages</h4>
                </div>
                <div class="page-rightheader ml-auto d-lg-flex d-none">
                    <a href="javascript:;" class="btn btn-primary add-edit-page" data-target="#add-page" data-hash-id="" data-toggle="modal"> <i class="fa fa-plus mr-1"></i>Add New Page</a>
                </div>
            </div>
            <!--End Page header-->
            <!--Row-->
            <!--Row-->
        @include('backend.admin.components.messages')
        <!--Row-->
            <!--Row-->
            <div class="row row-deck">

                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List all the pages</h3>
                            <div class="card-options">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="page-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                    <thead>
                                    <tr class="bold">
                                        <th class="border-bottom-0">Page Title</th>
                                        <th class="border-bottom-0">URL Slug</th>
                                        <th class="border-bottom-0" width="13%">Status</th>
                                        <th class="text-center border-bottom-0" width="10%">Action</th>
                                    </tr>
                                    </thead>
                                    <?php $full_path = env('MEDIA_PATH_HTTP');?>
                                    <tbody>
                                    @foreach($pages as $page)
                                        <tr>
                                            <td class="">
                                                {{$page->title}}
                                            </td>
                                            <td>
                                                {{$page->url_slug}}
                                            </td>
                                            <td>
                                                  @include('backend.admin.components.status', ['item_details' => !empty($page) ? $page : '' , 'resource' => 'pages' ])

                                            </td>
                                            <td>
                                                <button title="edit" class="btn btn-success btn-sm add-edit-page" data-hash-id="{{ $page->hash_id }}"><i class="fa fa-edit"></i></button>
                                                <button title="delete" class="btn btn-danger btn-sm delete-page" data-hash-id="{{ $page->hash_id }}"><i class="fa fa-times"></i></button>
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
    </div><!-- end app-content-->
    </div>

@stop
@section('scripts')

    <script type="text/javascript">

        $(document).ready(function(){

            $('.delete-item').click(function(){

                var hash_id = $('#General_bootstrap_delete_popup_hash_id').val();

                $.ajax({

                    type: 'POST',

                    url: 'pages/'+hash_id,

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

            $('.delete-page').click(function(){

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

            }); // click => .delete-page

            $('.add-edit-page').click(function(){
                var hash_id = $(this).attr('data-hash-id');

                var request_url = (hash_id != '') ? 'pages/'+hash_id+'/edit' : 'pages/create' ;

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
                        // $("#global-loader").fadeIn("slow");

                        $('#crud_errors_div').addClass('d-none');
                        $('#crud_errors_ul').html('');

                    },
                    success: function(response) {
                        // $("#global-loader").fadeOut("slow");
                        // $("#loading").css("display","none");

                        // swal(response);

                        var popup_title = '';

                        if(hash_id == ''){

                            popup_title = 'Add New Page';

                        } else {

                            popup_title = 'Edit Page';

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

            }); // click => .add-edit-page

            $('#page-datatable').DataTable();
            $('#description').summernote({
                height: 100,                 // set editor height
            });
            $('#edit_description').summernote({
                height: 100,                 // set editor height
            });

        });

    </script>
@stop
