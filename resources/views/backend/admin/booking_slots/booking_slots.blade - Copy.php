@extends('backend.admin.master')
@section('title', 'Booking Slots')
@section('style')
    <style>
        .datepicker {
            z-index: 1600 !important; /* has to be larger than 1050 */
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

@endsection()
@section('content')
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title"> Booking Slots </h4>
            </div>
            <div class="page-rightheader ml-auto d-lg-flex d-none">

                <div class="form-group mr-2">
                    <select class="form-control">
                        <option>Global Time Slots</option>
                        <option>Travel Clinic</option>
                        <option>Hair Loss</option>
                        <option>Weight Loss</option>
                        <option>PCR Test</option>
                    </select>
                </div>

                <div class="form-group">
                    <a href="javascript:;" class="btn btn-primary booking-slots-settings-trigger" mc-item-id=""><i class="fa fa-cog mr-2"></i> Settings </a>
                </div>

            </div>
        </div>

        <!--Row-->
        @include('backend.admin.components.messages')
        <!--Row-->

        <!--Row-->
        <div class="row row-deck">

            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Manage Booking slots</h3>
                        <div class="card-options">

                            <a href="javascript:;" class="btn btn-sm d-block btn-success manage-date-slots-trigger" data-day-number="1"> <i class="fa fa-calendar-o mr-1"></i> Manage Date Slots </a>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">

                                <thead>
                                    <tr>

                                        <th>

                                            <div class="row">

                                                <div class="col-md-5"> Mon </div>
                                                <div class="col-md-7">


                                                        <span class="pull-right">

                                                            <div class="form-group">
                                                                <div class="form-label"></div>
                                                                <label class="custom-switch">
                                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" onchange="day_on_off(this)" />
                                                                    <span class="custom-switch-indicator">

                                                                    </span>
                                                                </label>
                                                            </div>

                                                        </span>


                                                </div>

                                            </div>

                                        </th>
                                        <th>

                                            <div class="row">

                                                <div class="col-md-5"> Tue </div>

                                                <div class="col-md-7">


                                                        <span class="pull-right">

                                                            <div class="form-group">
                                                                <div class="form-label"></div>
                                                                <label class="custom-switch">
                                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                                                    <span class="custom-switch-indicator">

                                                                    </span>
                                                                </label>
                                                            </div>

                                                        </span>


                                                </div>

                                            </div>

                                        </th>
                                        <th>

                                            <div class="row">

                                                <div class="col-md-5">Wed</div>

                                                <div class="col-md-7">


                                                        <span class="pull-right">

                                                            <div class="form-group">
                                                                <div class="form-label"></div>
                                                                <label class="custom-switch">
                                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                                                    <span class="custom-switch-indicator">

                                                                    </span>
                                                                </label>
                                                            </div>

                                                        </span>


                                                </div>

                                            </div>

                                        </th>
                                        <th>

                                            <div class="row">

                                                <div class="col-md-5"> Thu </div>

                                                <div class="col-md-7">


                                                        <span class="pull-right">

                                                            <div class="form-group">
                                                                <div class="form-label"></div>
                                                                <label class="custom-switch">
                                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                                                    <span class="custom-switch-indicator">

                                                                    </span>
                                                                </label>
                                                            </div>

                                                        </span>


                                                </div>

                                            </div>

                                        </th>
                                        <th>

                                            <div class="row">

                                                <div class="col-md-5"> Fri </div>

                                                <div class="col-md-7">


                                                        <span class="pull-right">

                                                            <div class="form-group">
                                                                <div class="form-label"></div>
                                                                <label class="custom-switch">
                                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                                                    <span class="custom-switch-indicator">

                                                                    </span>
                                                                </label>
                                                            </div>

                                                        </span>


                                                </div>

                                            </div>

                                        </th>

                                        <th>

                                            <div class="row">

                                                <div class="col-md-5"> Sat </div>

                                                <div class="col-md-7">


                                                        <span class="pull-right">

                                                            <div class="form-group">
                                                                <div class="form-label"></div>
                                                                <label class="custom-switch">
                                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                                                    <span class="custom-switch-indicator">

                                                                    </span>
                                                                </label>
                                                            </div>

                                                        </span>


                                                </div>

                                            </div>

                                        </th>

                                        <th>

                                            <div class="row">

                                                <div class="col-md-5"> Sun </div>

                                                <div class="col-md-7">


                                                        <span class="pull-right">

                                                            <div class="form-group">
                                                                <div class="form-label"></div>
                                                                <label class="custom-switch">
                                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                                                    <span class="custom-switch-indicator">

                                                                    </span>
                                                                </label>
                                                            </div>

                                                        </span>


                                                </div>

                                            </div>

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                        <td class="">


                                                <div class="row mb-2">

                                                    <div class="col-md-12 text-right">

                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="1"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>
                                                   <a href="#" class="btn btn-sm d-block btn-light mb-1">    9:00 am </a>
                                                   <a href="#" class="btn btn-sm d-block btn-light mb-1">    9:15 am </a>
                                                   <a href="#" class="btn btn-sm d-block btn-light mb-1">    9:30 am </a>


                                        </td>

                                        <td class="">


                                                <div class="row mb-2">

                                                    <div class="col-md-12 text-right">

                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots" data-day-number="2"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>
                                                    <p class="text-center text-mute"> No slots </p>


                                        </td>

                                        <td class="">


                                                <div class="row mb-2">

                                                    <div class="col-md-12 text-right">

                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots" data-day-number="3"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>
                                                    <p class="text-center text-mute"> No slots </p>


                                        </td>

                                        <td class="">


                                                <div class="row mb-2">

                                                    <div class="col-md-12 text-right">

                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots" data-day-number="4"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>
                                                    <p class="text-center text-mute"> No slots </p>


                                        </td>

                                        <td class="">


                                                <div class="row mb-2">

                                                    <div class="col-md-12 text-right">

                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots" data-day-number="5"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>
                                                    <p class="text-center text-mute"> No slots </p>


                                        </td>

                                        <td class="">


                                                <div class="row mb-2">

                                                    <div class="col-md-12 text-right">

                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots" data-day-number="6"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>
                                                    <p class="text-center text-mute"> No slots </p>


                                        </td>
                                        <td class="">


                                                <div class="row mb-2">

                                                    <div class="col-md-12 text-right">

                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots" data-day-number="7"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>
                                                    <p class="text-center text-mute"> No slots </p>


                                        </td>
                                    </tr>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                zIndex: 99999999,
            });
            $('[data-toggle="datepicker"]').css('z-index','99999999');
        });
        $(document).ready(function(){


            $('.booking-slots-settings-trigger').click(function() {

                var _token = $('meta[name="csrf-token"]').attr('content');

                var _this = this;
                var item_id = $(_this).attr('mc-item-id');

                $.ajax({

                    type: "POST",
                    url: "{{ url('/booking_slots/settings') }}",
                    data: {
                        'item_id': item_id,
                        _token: _token
                    },

                    beforeSend: function(result) {
                        //$("#overlay").removeClass("hidden");
                    },
                    success: function(response) {


                        $("#loading").css("display","none");

                // swal(response);

                        var popup_title = '';

                        if (item_id == '') {

                            // Add New
                            popup_title = 'Master Calendar Settings';

                        } else {

                            // Edit
                            popup_title = 'Service Calendar Settings';

                        } // if(item_id == '')

                        $('#mc-popup-dialog').addClass('modal-md');

                        // Set Heading
                        $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                        // Set Body
                        $('#general_bootstrap_ajax_popup_body').html(response);

                        // Set Footer
                        // $('#general_bootstrap_ajax_popup_footer').prepend('');

                        $('#general_bootstrap_ajax_popup').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                        /*
                        if ($(_this).attr('mc-edit-btn') == "edit") {
                            $('#mc_frm_submit_btn').attr('edit_button', 'yes');
                        } // if($(_this).attr('mc-edit-btn') == "edit")
                        */

                    } // success

                }); // $.ajax

            }); // click => booking-slots-settings-trigger

            $('.manage-day-slots-trigger').click(function() {

                var _token = $('meta[name="csrf-token"]').attr('content');

                var _this = this;
                var item_id = $(_this).attr('mc-item-id');

                $.ajax({

                    type: "POST",
                    url: "{{ url('/booking_slots/day_slots') }}",
                    data: {
                        'item_id': item_id,
                        _token: _token
                    },

                    beforeSend: function(result) {
                        //$("#overlay").removeClass("hidden");
                    },
                    success: function(response) {


                        $("#loading").css("display","none");

                        // swal(response);

                        var popup_title = '';

                        if (item_id == '') {

                            // Add New
                            popup_title = 'Manage Day Slots (Monday)';

                        } else {

                            // Edit
                            popup_title = 'Manage Day Slots (Monday)';

                        } // if(item_id == '')

                        $('#mc-popup-dialog').addClass('modal-md');

                        // Set Heading
                        $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                        // Set Body
                        $('#general_bootstrap_ajax_popup_body').html(response);

                        // Set Footer
                        // $('#general_bootstrap_ajax_popup_footer').prepend('');

                        $('#general_bootstrap_ajax_popup').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                        /*
                        if ($(_this).attr('mc-edit-btn') == "edit") {
                            $('#mc_frm_submit_btn').attr('edit_button', 'yes');
                        } // if($(_this).attr('mc-edit-btn') == "edit")
                        */

                    } // success

                }); // $.ajax

            }); // click => manage-day-slots-trigger

            $('.manage-date-slots-trigger').click(function() {

                var _token = $('meta[name="csrf-token"]').attr('content');

                var _this = this;
                var item_id = $(_this).attr('mc-item-id');

                $.ajax({

                    type: "POST",
                    url: "{{ url('/booking_slots/date_slots') }}",
                    data: {
                        'item_id': item_id,
                        _token: _token
                    },

                    beforeSend: function(result) {
                        //$("#overlay").removeClass("hidden");
                    },
                    success: function(response) {


                        $("#loading").css("display","none");

                        // swal(response);

                        var popup_title = '';

                        if (item_id == '') {

                            // Add New
                            popup_title = 'Manage Date Slots (08/12/2021)';

                        } else {

                            // Edit
                            popup_title = 'Manage Date Slots (08/12/2021)';

                        } // if(item_id == '')

                        $('#mc-popup-dialog').addClass('modal-md');

                        // Set Heading
                        $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                        // Set Body
                        $('#general_bootstrap_ajax_popup_body').html(response);

                        // Set Footer
                        // $('#general_bootstrap_ajax_popup_footer').prepend('');

                        $('#general_bootstrap_ajax_popup').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                        /*
                        if ($(_this).attr('mc-edit-btn') == "edit") {
                            $('#mc_frm_submit_btn').attr('edit_button', 'yes');
                        } // if($(_this).attr('mc-edit-btn') == "edit")
                        */

                    } // success

                }); // $.ajax

            }); // click => manage-date-slots-trigger


        }); // ready


        // Start => function day_on_off(e)
        function day_on_off(e){

            var item_id = $(e).attr('mc-item-id');

            // alert(item_id);

            swal({

                title: "Are you sure?",
                text: "Are you sure you want to switch this day off?",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "No",
                cancelButtonClass: "btn-danger",
                confirmButtonClass: "btn-success",
                confirmButtonText: "Yes",
                closeOnConfirm: false

            },
            function() {

                $.ajax({

                    type: "DELETE",
                    url: "/pharmacy_menus/delete/" + item_id,
                    data: {
                        'item_id': item_id
                    },
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    beforeSend: function(result) {
                        $("#overlay").removeClass("hidden");
                    },
                    success: function(response) {

                        // swal("Deleted!", "Pharmacy menu successfully deleted.", "success");

                        // mc_notify('success', response.message);

                        location.reload()

                    },
                    error: function(request, status, error) {
                        // mc_notify('danger', response.responseText);
                    }


                }); // $.ajax

            });

        } // End => function day_on_off(e)

    </script>

@stop
