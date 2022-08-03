@extends('backend.admin.master')
@section('title', 'Business')
@section('content')
    <!-- Start app-content-->
    <div class="app-content page-body">
        <div class="container">

            <!--Page header-->
            <div class="page-header">
                <div class="page-leftheader">
                    <h4 class="page-title">Business</h4>
                </div>
                <div class="page-rightheader ml-auto d-lg-flex d-none">
                    <a href="javascript:;" class="btn btn-primary add-edit-business" data-hash-id="" data-target="#patientModal" data-toggle="modal"> <i class="fa fa-plus mr-1"></i>Add New Busines</a>
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
                            <h3 class="card-title">List Business</h3>
                            <div class="card-options">
                                <!-- <a href="" title="print list" class="btn btn-light"><i class="fa fa-print" aria-hidden="true"></i></a> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="business-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                    <thead>
                                    <tr class="bold">
                                        <th class="border-bottom-0" width="5%">ID </th>
                                        <th class="border-bottom-0">Business Details</th>
                                        <th class="border-bottom-0" width="12%">Type</th>
                                        <th class="border-bottom-0" width="12%">Status</th>
                                        <th class="border-bottom-0" width="10%">Order</th>
                                        <th class="text-center border-bottom-0" width="10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                     
                                    @foreach($business as $busines)
                                        
                                        <tr>
                                           <td>{{$busines->id}}</td>
                                           <td><p><strong> {{$busines->business_name}} </strong></p>
                                               <p>{{$busines->address_1}} @if(!empty($busines->address_2))<br> {{$busines->address_2}} @endif @if(!empty($busines->address_3))<br> {{$busines->address_3}} @endif @if(!empty($busines->town_city))<br> {{$busines->town_city}} @endif @if(!empty($busines->postcode))<br> {{$busines->postcode}} @endif</p>
                                            </td>
                                            <td> {{$busines->Type ? $busines->Type->title : '' }} </td>
                                            <td>
                                             @include('backend.admin.components.display_order', ['item_details' => !empty($busines) ? $busines : '' , 'resource' => 'business' ])
                                            </td>
                                            <td>
                                             @include('backend.admin.components.status', ['item_details' => !empty($busines) ? $busines : '' , 'resource' => 'business' ])
                                            </td>
                                            <td>  <button type="button" title="edit" class="btn btn-success btn-sm add-edit-business" data-hash-id="{{ $busines->hash_id }}"><i class="fa fa-edit"></i></button> </td>
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

    <!-- Page Modal -->
    <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="normalmodal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="action-modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="POST" id="action_form">
                    <div class="modal-body">

                        @csrf
                        <div class="row" id="password_row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">New Password <span class="text-red">*</span></label>
                                    <input type="password" id="password" class="form-control" name="password">
                                    <span class="text-danger error-text password_err"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Confirm New Password <span class="text-red">*</span></label>
                                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
                                    <span class="text-danger error-text password_confirmation_err"></span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="data">
                        <input type="hidden" id="verify">
                        <div class="col-md-6" id="is_verified_row">
                            <div class="form-group">
                                <div class="mt-5">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="is_verified_in" id="is_verified_in" value="0"> <span class="custom-control-label">Is Verified?</span> </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="reason_row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="mt-5">
                                        <label class="form-label">Reason</label>
                                        <textarea rows="4" class="form-control" id="reason_in" placeholder="Reason"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="save_changes" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection()

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#is_verified_in').click(function () {
                if ($(this).is(':checked')) {
                    $(this).attr('value', 1);
                } else {
                    $(this).attr('value', 0);
                }
                console.log($('#is_verified_in').val())
                $('#reason_row').toggle();
            });
            $('.add-edit-business').click(function () {


                var hash_id = $(this).attr('data-hash-id');

                var request_url = (hash_id != '') ? 'business/' + hash_id + '/edit' : 'business/create';

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

                    beforeSend: function (result) {

                        // $("#loading").css("display","block");

                        $('#crud_errors_div').addClass('d-none');
                        $('#crud_errors_ul').html('');

                    },
                    success: function (response) {

                        // $("#loading").css("display","none");

                        // swal(response);

                        var popup_title = '';

                        if (hash_id == '') {

                            popup_title = 'Add New business';

                        } else {

                            popup_title = 'Edit business';

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
          
            $('#business-datatable').DataTable();

        });

       
    </script>

@endsection()
