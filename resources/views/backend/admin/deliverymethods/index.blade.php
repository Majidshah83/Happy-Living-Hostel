@extends('backend.admin.master')
@section('title', 'Delivery Methods')
@section('content')
    <!-- Start app-content-->
            <div class="app-content page-body">
                <div class="container">
                    <!--Page header-->
                    <div class="page-header">
                        <div class="page-leftheader">
                            <h4 class="page-title">Delivery Methods</h4>
                        </div>
                        <div class="page-rightheader ml-auto d-lg-flex d-none">
                            <a href="javascript:;" class="btn btn-primary add-edit-delivery-method" data-hash-id=""><i class="fa fa-plus mr-2"></i> Add New Delivery Method </a>
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
                                    <h3 class="card-title">List all delivery methods</h3>
                                    <div class="card-options">

                                    </div>
                                </div>
                                <div class="card-body">


                                    <?php $full_path = env('MEDIA_PATH_HTTP');?>
                                    <div class="table-responsive">
                                        <table id="delivery-methods-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                            <thead>
                                                <tr class="bold">
                                                    <th class="border-bottom-0" width="5%">ID </th>
                                                    <th class="border-bottom-0" width="10%">Logo </th>
                                                    <th class="border-bottom-0">Delivery Method</th>
                                                    <th class="border-bottom-0" width="10%">Price (£)</th>
                                                    <th class="border-bottom-0" width="13%">Order</th>
                                                    <th class="border-bottom-0" width="13%">Status</th>
                                                    <th class="text-center border-bottom-0" width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($delivery_methods as  $key => $delivery_method)
                                                <tr>
                                                    <td class="font-weight-bold text-center">
                                                        <strong>{{++$key}}</strong>
                                                    </td>
                                                    <td class="">

                                                         @if($delivery_method->image != null)
                                                            <img src="{{ $full_path.'deliverymethods/'.$delivery_method->image }}" alt="" title="" />
                                                        @endif()
                                                    </td>
                                                    <td>
                                                       <strong>{{$delivery_method->title}}</strong>
                                                       @if($delivery_method->is_international_delivery != 'Local')<span class="badge badge-pill badge-success mt-2 pull-right">International</span>
                                                       @endif
                                                       <br />
                                                       <p>{{$delivery_method->description}}</p>
                                                    </td>
                                                    <td>{{number_format($delivery_method->price)}}</td>
                                                    <td>
                                                        @include('backend.admin.components.display_order', ['item_details' => !empty($delivery_method) ? $delivery_method : '' , 'resource' => 'delivery_methods' ])

                                                    </td>
                                                    <td>

                                                        @include('backend.admin.components.status', ['item_details' => !empty($delivery_method) ? $delivery_method : '' , 'resource' => 'delivery_methods' ])

                                                    </td>
                                                    <td>
                                                        <button type="button" title="edit" class="btn btn-success btn-sm add-edit-delivery-method" data-hash-id="{{ $delivery_method->hash_id }}"><i class="fa fa-edit"></i></button>
                                                    </button>
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
        $('#delivery-methods-datatable').DataTable();
        $('.add-edit-delivery-method').click(function(){

            var hash_id = $(this).attr('data-hash-id');
            var request_url = (hash_id != '') ? 'delivery-methods/'+hash_id+'/edit' : 'delivery-methods/create' ;
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

                        popup_title = 'Add New Delivery Methods';

                    } else {

                        popup_title = 'Edit Delivery Methods';

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

            }); // click => .add-edit-delivery-methods
        });



</script>
@stop
