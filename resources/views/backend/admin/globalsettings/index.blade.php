@extends('backend.admin.master')
@section('title', 'Global Settings Section')
@section('content')
    <!-- Start app-content-->
            <div class="app-content page-body">
                <div class="container">
                    <!--Page header-->
                    <div class="page-header">
                    <div class="page-leftheader">
                        <h4 class="page-title">Global Settings</h4>
                    </div>
                        <div class="page-rightheader ml-auto d-lg-flex d-none">
                            <a href="javascript:;" class="btn btn-primary add-edit-global-setting" data-hash-id=""><i class="fa fa-plus mr-2"></i> Add Settings </a>
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
                                    <h3 class="card-title">List all global settings</h3>
                                    <div class="card-options">

                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="global-setting-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                            <thead>
                                                <tr class="bold">
                                                    <th class="border-bottom-0" width="10%">Title</th>
                                                    <th class="border-bottom-0" width="10%">Key</th>
                                                    <th class="border-bottom-0" width="10%">value</th>
                                                    <th class="text-center border-bottom-0" width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($global_settings as $global_setting)
                                                <tr>
                                                    <td>
                                                        {{$global_setting->setting_title}}
                                                    </td>
                                                    <td>{{$global_setting->setting_key}}</td>
                                                     <td>
                                                        {{$global_setting->setting_value}}
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" title="edit" class="btn btn-success btn-sm add-edit-global-setting" data-hash-id="{{$global_setting->hash_id }}"><i class="fa fa-edit"></i></button>
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

            $('.add-edit-global-setting').click(function(){


                var hash_id = $(this).attr('data-hash-id');

                var request_url = (hash_id != '') ? 'global-settings/'+hash_id+'/edit' : 'global-settings/create' ;

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

                            popup_title = 'Add New Global Settings';

                        } else {

                            popup_title = 'Edit Global Settings';

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

            $('#global-setting-datatable').DataTable();

            $('#description').summernote({
                  height: 100,                 // set editor height
            });

        });

    </script>
@stop
