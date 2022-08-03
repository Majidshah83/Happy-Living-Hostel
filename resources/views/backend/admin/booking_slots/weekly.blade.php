@extends('backend.admin.master')
@section('title', 'Booking Slots - Weekly')
@section('style')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css" integrity="sha512-E4kKreeYBpruCG4YNe4A/jIj3ZoPdpWhWgj9qwrr19ui84pU5gvNafQZKyghqpFIHHE4ELK7L9bqAv7wfIXULQ==" crossorigin="anonymous" />

    <style type="text/css">
        
        .timerpicker {
            
            border: 1px solid #ddd;
            
            padding: 8px;

            z-index: 9999 !important; 

        }

    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />

    <style type="text/css">
        
        .datepicker {
            
            border: 1px solid #ddd;
            
            padding: 8px;

            z-index: 999999 !important; 

        }

    </style>
    
@endsection()
@section('content')
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title"> Booking Slots - Weekly </h4>
            </div>
            <div class="page-rightheader ml-auto d-lg-flex d-none">

                <!--
                <div class="form-group mr-2">
                    <select class="form-control">
                        <option>Global Time Slots</option>
                        <option>Travel Clinic</option>
                        <option>Hair Loss</option>
                        <option>Weight Loss</option>
                        <option>PCR Test</option>
                    </select>
                </div>
                -->

                <div class="form-group mr-2">
                    <a href="{{ url('booking_slots') }}" class="btn btn-white"><i class="fa fa-cog mr-2"></i> Master </a>
                </div>

                <div class="form-group mr-2">
                    <a href="{{ url('booking_slots/weekly') }}" class="btn btn-success"><i class="fa fa-calendar-o mr-2"></i> Weekly </a>
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

                            <!--
                            <a href="javascript:;" class="btn btn-sm d-block btn-success manage-date-slots-trigger" data-day-number="1"> <i class="fa fa-calendar-o mr-1"></i> Manage Date Slots </a>
                            -->

                        </div>
                    </div>
                    <div class="card-body">
                        
                        <!-- Full Calendar Ajax Contents [ next_prev ] -->
                        <div id="full_calendar_div"></div>

                    </div>
                </div>
            </div>

        </div>
        <!--End row-->

    </div>

    <!-- end app-content-->

@stop

@section('scripts')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js" integrity="sha512-2xXe2z/uA+2SyT/sTSt9Uq4jDKsT0lV4evd3eoE/oxKih8DSAsOF6LUb+ncafMJPAimWAXdu9W+yMXGrCVOzQA==" crossorigin="anonymous"></script>

    <script>

        (function($){
          
          $('#full_calendar_div').on('click', '#prev_day_weekly, #next_day_weekly, #current_day_weekly', function (e) {

            var action = $(this).attr('id');
            var current_day = $('#rxdate_weekly').attr('rel');

            var calendar_pharmacy_id = $('#calendar_pharmacy_id').val();

            $.ajax({

                type: "POST",
                url: "{{ route('next_prev_weekly') }}",
                // processData: false,
                // contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'current': current_day,
                    'action': action,
                    'calendar_pharmacy_id' : calendar_pharmacy_id
                },

                beforeSend: function(result) {

                    $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                
                success: function(response) {
                    
                    $("#loading").css("display","none");

                    $("#full_calendar_div").html(response);
                    
                } // success

            }); // $.ajax

          });

          $(document).ready(function(){

            $.ajax({

                type: "POST",
                url: "{{ route('next_prev_weekly') }}",
                // processData: false,
                // contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'action': 'current_day',
                },

                beforeSend: function(result) {

                    $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                
                success: function(response) {
                    
                    $("#loading").css("display","none");

                    $("#full_calendar_div").html(response);
                    
                } // success

            }); // $.ajax

          }); // documen.ready function

        })( jQuery );

    </script>

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

            $('.manage-day-slots-trigger').click(function(){

                var _token = $('meta[name="csrf-token"]').attr('content');

                var _this = this;
                var day_number = $(_this).attr('data-day-number');

                $.ajax({

                    type: "POST",
                    url: "{{ url('/booking_slots/day_slots') }}",
                    data: {
                        'day_number': day_number,
                        _token: _token
                    },

                    beforeSend: function(result) {
                        //$("#overlay").removeClass("hidden");
                    },
                    success: function(response) {

                        // $("#loading").css("display","none");

                        // swal(response);

                        // Add New
                        var popup_title = 'Manage Day Slots';

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

            // Start => function day_on_off(e)
            $('.week-day-switch').click(function(){

                var day_number = $(this).val();

                var day_is_off = $(this).prop('checked') == true ? 'N' : 'Y';

                // alert(day_is_off);

                swal({

                    title: "Are you sure?",
                    text: "Are you sure you want to switch day on/off status?",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    cancelButtonClass: "btn-danger",
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false

                },
                function(inputValue) {

                    if (inputValue===false) {
                        
                        location.reload();

                    } else {

                        $.ajax({

                            type: "POST",
                            url: "/booking_slots/day_on_off",
                            data: {
                                'day_number': day_number,
                                'day_is_off' : day_is_off
                            },
                            // processData: false,
                            // contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            beforeSend: function(result) {
                                $("#overlay").removeClass("hidden");
                            },
                            success: function(response) {

                                location.reload()

                            },
                            error: function(request, status, error) {
                                // mc_notify('danger', response.responseText);
                            }


                        }); // $.ajax

                    } // if (inputValue===false)

                });

            }); // End

            ///////// WEEKLY FUNCTIONS /////////

            // Start => function day_on_off(e)
            $(document).on('click', '.week-date-switch', function(){

                var off_date = $(this).val();

                var day_is_off = $(this).prop('checked') == true ? 'N' : 'Y';

                // alert(day_is_off);

                swal({

                    title: "Are you sure?",
                    text: "Are you sure you want to switch date on/off status?",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    cancelButtonClass: "btn-danger",
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false

                },
                function(inputValue) {

                    if (inputValue===false) {
                        
                        location.reload();

                    } else {

                        $.ajax({

                            type: "POST",
                            url: "/booking_slots/date_on_off",
                            data: {
                                'off_date': off_date,
                                'day_is_off' : day_is_off
                            },
                            // processData: false,
                            // contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            beforeSend: function(result) {
                                $("#overlay").removeClass("hidden");
                            },
                            success: function(response) {

                                location.reload()

                            },
                            error: function(request, status, error) {
                                // mc_notify('danger', response.responseText);
                            }


                        }); // $.ajax

                    } // if (inputValue===false)

                });

            }); // $(document).on('click', '.week-date-switch', function()

            $(document).on('click', '.manage-date-slots-trigger',function(){

                var _token = $('meta[name="csrf-token"]').attr('content');

                var _this = this;
                var slot_date = $(_this).attr('data-date');

                $.ajax({

                    type: "POST",
                    url: "{{ url('/booking_slots/date_slots') }}",
                    data: {
                        'slot_date': slot_date,
                        _token: _token
                    },

                    beforeSend: function(result) {
                        //$("#overlay").removeClass("hidden");
                    },
                    success: function(response) {

                        // $("#loading").css("display","none");

                        // swal(response);

                        // Add New
                        var popup_title = 'Manage Date Slots';

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

    </script>

@stop
