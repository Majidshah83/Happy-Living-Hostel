
<style type="text/css">
    .mc-cdt-links-div nav{
        float: right;
    }
</style>

<div class="row">

    <div class="col-md-2 col-sm-12">

        <div class="form-group">

            <label> Per Page </label>
            <select class="form-control cdt_per_page" id="cdt_per_page" mc-parent-id="mc-cdt">
                <!-- <option {{ !empty($post_arr) && $post_arr['cdt_per_page'] == '10' ? 'selected="selected"' : '' }} value="10"> 10 </option> -->
                <option {{ !empty($post_arr) && $post_arr['cdt_per_page'] == '50' ? 'selected="selected"' : '' }} value="50"> 50 </option>
                <option {{ !empty($post_arr) && $post_arr['cdt_per_page'] == '100' ? 'selected="selected"' : '' }} value="100"> 100 </option>
            </select>

        </div>

    </div>

    <div class="col-md-8 col-sm-12"></div>

    <div class="col-md-2 col-sm-12">

        <div class="form-group">

            <label> Search </label>
            <input type="text" class="form-control cdt_search" id="cdt_search" value="{{ !empty($post_arr['cdt_search']) ? $post_arr['cdt_search'] : '' }}" mc-parent-id="mc-cdt" />

        </div>

    </div>

</div>

<div class="row">
    <div class="col-sm-12 col-md-12">

        <div class="table-responsive">

            <table id="onsite-datetable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                <thead>
                    <tr class="bold">
                        <th class="border-bottom-0" width="8%">Codes </th>
                        <th class="border-bottom-0">Passenger Details</th>
                        <th class="border-bottom-0">Flight Details</th>
                        <th class="border-bottom-0" width="10%">Order Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list_all as $key => $order)
                        <tr>
                            <td class="">

                                <a href="javascript:;" class="btn btn-block btn-warning btn-block btn-sm add-edit-code mb-3" data-hash-id="{{$order->order_hash_id}}" data-hash-code="{{$order->order_plfcode}}" data-code-8="{{$order->order_day_8_barcode}}" data-pin-8="{{$order->order_day_8_pin}}" data-code-2="{{$order->order_day_2_barcode}}" data-pin-2="{{$order->order_day_2_pin}}">Code</a>
                                
                                <a href="javascript:;" class="mb-2 btn btn-block btn-sm {{ ($order->email2_sent_status == '1') ? 'btn-success' : 'btn-danger' }} send-email-2" data-hash-id="{{$order->order_hash_id}}"> Email </a>

                                @if($order->order_plfcode)
                                    <strong class="text-center">PLF Code</strong>
                                    <br>
                                    {{$order->order_plfcode}}
                                @endif
                                
                                @if($order->order_day_2_barcode)
                                    <br>
                                    <strong>Day 2</strong>
                                    <br>
                                    {{$order->order_day_2_barcode}} / {{$order->order_day_2_pin}}
                                @endif
                                
                                @if($order->order_day_8_barcode)
                                    <br>
                                    <strong>Day 8</strong>
                                    <br>
                                    {{$order->order_day_8_barcode}} / {{$order->order_day_8_pin}}
                                @endif

                            </td>
                            <td>
                                <a  data-container="body" data-html="true"
                                    data-content="
                                                            <ul>
                                                                @if($order->passengers_gender)<li><strong>Gender: </strong> {{ucwords($order->passengers_gender)}}</li>@endif()
                                    @if($order->passengers_dob)<li><strong>D.O.B: </strong> {{$order->passengers_dob}}</li>@endif()
                                    @if($order->passengers_phone_no)<li><strong>Phone: </strong> {{$order->passengers_phone_no}}</li>@endif()
                                    @if($order->passengers_email)<li><strong>Email: </strong> {{$order->passengers_email}}</li>@endif()
                                        </ul>
" data-placement="top" data-popover-color="head-primary"  title="" data-original-title="{{ucwords($order->passengers_first_name)}} {{ucwords($order->passengers_surname)}}"><strong>{{ucwords($order->passengers_first_name)}} {{ucwords($order->passengers_surname)}}</strong></a>

                                <p>
                                    {{$order->passenger_addresses_uk_address}} <br> {{$order->passenger_addresses_uk_postcode}} <br> {{$order->passenger_addresses_uk_city}}
                                    <br>
                                    <strong>T:</strong> {{$order->passengers_phone_no}}
                                    <br>
                                    <strong>E: </strong> {{$order->passengers_email}}
                                    <br>
                                    <strong>Gender: </strong> {{ucwords($order->passengers_gender)}}
                                    <br>
                                    <strong>DOB: </strong> <b>{{date('d/m/Y', strtotime($order->passengers_dob))}}</b>
                                    <br>
                                    <strong>NSH No: </strong> <b>{{$order->passengers_nhs_no}}</b>
                                    <br>
                                    <strong>Ethnicity: </strong> {{$order->passengers_ethnicity}}
                                    <br>
                                    <strong>Vaccination Status: </strong> {{ucwords($order->passengers_vaccination_status)}}
                                    <br>
                                    <strong>Passport No: </strong> {{$order->passengers_passport_no}}
                                </p>
                            </td>
                            <td>
                                <p>

                                    @php

                                        $arrival_date_class = '';

                                        if(!empty($order->travel_details_arrival_date)){

                                            $today = date('Y-m-d');
                                            $tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));

                                            $arrival_date = date('Y-m-d', strtotime($order->travel_details_arrival_date));
                                            $arrival_date_class = strtotime($arrival_date) == strtotime($today) || strtotime($arrival_date) == strtotime($tomorrow) ? 'bg-danger text-white' : '' ;

                                        }

                                    @endphp

                                    <strong class="{{ $arrival_date_class }}"> Arrival Date: </strong>

                                    {{date('d/m/Y', strtotime($order->travel_details_arrival_date))}}

                                    <br>

                                    <strong>Date of Departure: </strong> {{date('d/m/Y', strtotime($order->travel_details_date_of_departure))}}
                                    <br>
                                    <strong>Country Travelled From: </strong> {{$order->countries_title}}
                                    <br>
                                    <strong>City Travelled From: </strong> {{$order->travel_details_city_travelled_from}}
                                    <br>
                                    <strong>Type of Transport: </strong> {{$order->travel_details_type_of_transport}}
                                    <br>
                                    <strong>Flight No: </strong> {{$order->travel_details_coach_no}}


                                </p>
                            </td>
                            <td>
                                {{date('d/m/Y h:mA', strtotime($order->order_created_at))}}
                                <br>
                                <strong>Package: </strong> {{$order->services_title}}
                                <br>

                                @include('backend.admin.components.order_status', ['item_details' => !empty($order) ? $order : '' , 'resource' => 'orders' ])

                            </td>

                        </tr>
                    @endforeach()
                </tbody>
            </table>

        </div>

    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-5">

        Showing {{ $list_all->firstItem() }} - {{ $list_all->lastItem() }} of {{ $list_all->total() }} entries

        <input type="hidden" id="cdt_pagination_page_no" value="{{ !empty($post_arr) ? $post_arr['page'] : '1' }}" readonly="readonly" />


    </div>
    <div class="col-sm-12 col-md-7 mc-cdt-links-div" mc-parent-id="mc-cdt">

        {{ $list_all->links() }}

    </div>
</div>
<div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="normalmodal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="action-modal-title">Change PLF Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="POST" id="action_form">
                <div class="modal-body">
                    <div class="row d-none" id="crud_errors_div">

                        <div class="col-md-12">

                            <div class="alert alert-danger">

                                <!-- Contain Dynamic Errors -->
                                <ul class="mb-0" id="crud_errors_ul"></ul>

                                <!-- Contain Input File Errors -->
                                <ul class="mb-0" id="file_error_ul"></ul>

                            </div>

                        </div>

                    </div>
                    @csrf
                    <input type="hidden" id="order_hash_id" name="order_hash_id">
                    <input type="hidden" id="old_plfcode" class="form-control" name="old_plfcode">
                    <div class="row" id="password_row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">PLF Code </label>
                                <input type="text" id="plfcode" oninput="this.value = this.value.toUpperCase()" class="form-control" name="plfcode">
                                <span class="text-danger error-text password_err"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Day 2 Barcode </label>
                                <input type="text" id="day_2_barcode" class="form-control" name="day_2_barcode">
                                <span class="text-danger error-text password_err"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Day 2 Pin </label>
                                <input type="text" id="day_2_pin" class="form-control" maxlength="4" name="day_2_pin">
                                <span class="text-danger error-text password_err"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Day 8 Barcode </label>
                                <input type="text" id="day_8_barcode" class="form-control" name="day_8_barcode">
                                <span class="text-danger error-text password_err"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Day 8 Pin </label>
                                <input type="text" id="day_8_pin" class="form-control" maxlength="4" name="day_8_pin">
                                <span class="text-danger error-text password_err"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="save_changes" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {

    $('.send-email-2').click(function(){

        var hash_id = $(this).attr('data-hash-id');

        var request_url = 'orders/send-email-2/'+hash_id;

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

                var popup_title = 'Send Email 2';

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

    }); // click => .send-email-2

}); // click => add-edit-website-design-trigger
</script>

<script>
    $(document).ready(function() {

        $('.add_filters').unbind().change(function(){

            $('#mc-cdt').find('#cdt_pagination_page_no').val('1');
            console.log("callling")
            refresh_cdt('mc-cdt');

        });
        $('#today').unbind().click(function(){

            $('#mc-cdt').find('#cdt_pagination_page_no').val('1');
            $('#today').val(1)
            refresh_cdt('mc-cdt');

        });
        $('#tom').unbind().click(function(){

            $('#mc-cdt').find('#cdt_pagination_page_no').val('1');
            $('#tom').val(1)
            refresh_cdt('mc-cdt');

        });
        $('.add-edit-code').click(function () {
            $('#crud_errors_div').addClass('d-none');
            var hash_id = $(this).attr('data-hash-id');
            var code = $(this).attr('data-hash-code');
            var code_8 = $(this).attr('data-code-8');
            var pin_8 = $(this).attr('data-pin-8');
            var code_2 = $(this).attr('data-code-2');
            var pin_2 = $(this).attr('data-pin-2');
            $('#order_hash_id').val(hash_id);
            $('#day_8_barcode').val(code_8);
            $('#day_8_pin').val(pin_8);
            $('#day_2_barcode').val(code_2);
            $('#day_2_pin').val(pin_2);
            $('#plfcode').val(code);
            $('#old_plfcode').val(code);
            $('#openModal').modal('show');
        });
        $('#save_changes').click(function(){

            var request_data = new FormData(document.getElementById("action_form"));

            $.ajax({

                type: 'POST',

                url: "{{ url('update-plf-code') }}",

                processData: false,

                contentType: false,

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: request_data,

                beforeSend: function(result) {

                    $("#loader").show();
                    $("#save_changes").attr("disabled", true);
                    $('#save_changes').html('Loading..');

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {

                    $("#save_changes").attr("disabled", false);
                    $('#save_changes').html('Submit');
                    $("#loading").css("display","none");
                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);


                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#save_changes").attr("disabled", false);
                    $('#save_changes').html('Submit');
                    mcShowErrorsPost(xhr, status, error);
                }

                // success

            }); // $.ajax

        });
        $('#dashboard-table').dataTable( {
            "pageLength": 50
        });
    } );
</script>
