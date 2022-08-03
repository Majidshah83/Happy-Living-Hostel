@extends('backend.admin.master')
@section('title', 'Services Section')
@section('style')
    <style type="text/css">
        img#thumb_service_image {
            height: 142px;
        }
        img#service_image {
            height: 142px;
        }
    </style>
@stop
@section('content')
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Services</h4>
            </div>
            <div class="page-rightheader ml-auto d-lg-flex d-none">
                <a href="javascript:;" class="btn btn-primary add-edit-service" data-hash-id="" data-target="#add-service" data-toggle="modal"><i class="fa fa-plus mr-2"></i>Add New Service</a>
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
                        <h3 class="card-title">List Services</h3>
                        <div class="card-options">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="service-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                <thead>
                                <tr class="bold">
                                    <th class="border-bottom-0">Service</th>
                                    <th class="border-bottom-0" width="13%">Disply order</th>
                                    <th class="border-bottom-0" width="13%">Status</th>
                                    <th class="text-center border-bottom-0" width="10%">Action</th>
                                </tr>
                                </thead>
                                <?php $full_path = env('MEDIA_PATH_HTTP');?>
                                <tbody>
                                @foreach($services as $service)
                                    <tr>

                                        <td>
                                            {{$service->title}}
                                        </td>

                                        <td>
                                           @include('backend.admin.components.display_order', ['item_details' => !empty($service) ? $service : '' , 'resource' => 'services' ])
                                        </td>

                                        <td>
                                          @include('backend.admin.components.status', ['item_details' => !empty($service) ? $service : '' , 'resource' => 'services' ])
                                        </td>

                                        <td>

                                            <button title="edit" class="btn btn-success btn-sm add-edit-service" data-hash-id="{{ $service->hash_id }}"><i class="fa fa-edit"></i></button>

                                            <button title="Countries" class="btn btn-info btn-sm edit-countries-list" data-hash-id="{{ $service->hash_id }}"><i class="fa fa-plane"></i></button>

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

@stop
@section('scripts')

    <script type="text/javascript">
        $(document).ready(function(){

            $('.add-edit-service').click(function(){
                var hash_id = $(this).attr('data-hash-id');

                var request_url = (hash_id != '') ? 'services/'+hash_id+'/edit' : 'services/create' ;

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

                            popup_title = 'Add New Service';

                        } else {

                            popup_title = 'Edit Service';

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

            $('.edit-countries-list').click(function(){
                
                var hash_id = $(this).attr('data-hash-id');

                $.ajax({

                    type: "GET",

                    url: '{{ url("/services/get-service-countries") }}' +'/'+ hash_id,

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

                        var popup_title = 'Service Countries';

                        $('#mc-popup-dialog').addClass('modal-md');

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

            }); // click => .edit-countries-list

            $('#service-datatable').DataTable();
            $('#long_description').summernote({
                height: 100,                 // set editor height
            });

        });

        function filterData(data){
            while(data.startsWith('<p><br></p>')){
                data=data.replace('<p><br></p>','')
            }
            while(data.endsWith('<p><br></p>')){
                data=data.replace(new RegExp('<p><br></p>$'),'')
            }
            return data;
        }



    </script>
@stop
