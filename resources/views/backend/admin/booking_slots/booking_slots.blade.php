@extends('backend.admin.master')
@section('title', 'Booking Slots - Master')
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
                <h4 class="page-title"> Booking Slots - Master </h4>
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
                    <a href="{{ url('booking_slots') }}" class="btn btn-success"><i class="fa fa-cog mr-2"></i> Master </a>
                </div>

                <div class="form-group mr-2">
                    <a href="{{ url('booking_slots/weekly') }}" class="btn btn-white"><i class="fa fa-calendar-o mr-2"></i> Weekly </a>
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
                                                                    
                                                                    <input type="checkbox" class="custom-switch-input week-day-switch" id="mon_day_onn_off_switch" name="week_day_onn_off_switch" value="1" {{ !empty($week_day_on_off_status['1']) ? '' : 'checked="checked"' }} />
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
                                                                    
                                                                    <input type="checkbox" class="custom-switch-input week-day-switch" id="tue_day_onn_off_switch" name="week_day_onn_off_switch" value="2" {{ !empty($week_day_on_off_status['2']) ? '' : 'checked="checked"' }} />

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
                                                                    
                                                                    <input type="checkbox" class="custom-switch-input week-day-switch" id="wed_day_onn_off_switch" name="week_day_onn_off_switch" value="3" {{ !empty($week_day_on_off_status['3']) ? '' : 'checked="checked"' }} />

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
                                                                    
                                                                    <input type="checkbox" class="custom-switch-input week-day-switch" id="thu_day_onn_off_switch" name="week_day_onn_off_switch" value="4" {{ !empty($week_day_on_off_status['4']) ? '' : 'checked="checked"' }} />

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
                                                                    
                                                                    <input type="checkbox" class="custom-switch-input week-day-switch" id="fri_day_onn_off_switch" name="week_day_onn_off_switch" value="5" {{ !empty($week_day_on_off_status['5']) ? '' : 'checked="checked"' }} />

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
                                                                
                                                                <input type="checkbox" class="custom-switch-input week-day-switch" id="sat_day_onn_off_switch" name="week_day_onn_off_switch" value="6" {{ !empty($week_day_on_off_status['6']) ? '' : 'checked="checked"' }} />

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
                                                                    
                                                                    <input type="checkbox" class="custom-switch-input week-day-switch" id="sund_day_onn_off_switch" name="week_day_onn_off_switch" value="7" {{ !empty($week_day_on_off_status['7']) ? '' : 'checked="checked"' }} />

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

                                        <td class="{{ !empty($week_day_on_off_status['1']) ? 'bg-danger' : '' }}">

                                            <div class="row mb-2">

                                                <div class="col-md-12 text-right">

                                                    <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="1"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                </div>

                                            </div>
                                            
                                            @php
                                            
                                            if(!empty($week_day_slots[1])){

                                                foreach($week_day_slots[1] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                                        {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                                    </a>

                                                    @php

                                                } // foreach($week_day_slots[1] as $day_slot)

                                            } else {

                                                @endphp
                                                
                                                    <p class="text-center text-mute"> No slots </p>

                                                @php
                                            
                                            } // if(!empty($week_day_slots[1]))

                                            @endphp

                                        </td>

                                        <td class="{{ !empty($week_day_on_off_status['2']) ? 'bg-danger' : '' }}">

                                            <div class="row mb-2">

                                                <div class="col-md-12 text-right">

                                                    <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="2"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                </div>

                                            </div>
                                            
                                            @php
                                            
                                            if(!empty($week_day_slots[2])){

                                                foreach($week_day_slots[2] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                                        {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                                    </a>

                                                    @php

                                                } // foreach($week_day_slots[2] as $day_slot)

                                            } else {

                                                @endphp
                                                
                                                    <p class="text-center text-mute"> No slots </p>

                                                @php
                                            
                                            } // if(!empty($week_day_slots[2]))

                                            @endphp

                                        </td>

                                        <td class="{{ !empty($week_day_on_off_status['3']) ? 'bg-danger' : '' }}">

                                            <div class="row mb-2">

                                                <div class="col-md-12 text-right">

                                                    <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="3"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                </div>

                                            </div>
                                            
                                            @php
                                            
                                            if(!empty($week_day_slots[3])){

                                                foreach($week_day_slots[3] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                                        {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                                    </a>

                                                    @php

                                                } // foreach($week_day_slots[3] as $day_slot)

                                            } else {

                                                @endphp
                                                
                                                    <p class="text-center text-mute"> No slots </p>

                                                @php
                                            
                                            } // if(!empty($week_day_slots[3]))

                                            @endphp

                                        </td>

                                        <td class="{{ !empty($week_day_on_off_status['4']) ? 'bg-danger' : '' }}">

                                            <div class="row mb-2">

                                                <div class="col-md-12 text-right">

                                                    <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="4"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                </div>

                                            </div>
                                            
                                            @php
                                            
                                            if(!empty($week_day_slots[4])){

                                                foreach($week_day_slots[4] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                                        {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                                    </a>

                                                    @php

                                                } // foreach($week_day_slots[4] as $day_slot)

                                            } else {

                                                @endphp
                                                
                                                    <p class="text-center text-mute"> No slots </p>

                                                @php
                                            
                                            } // if(!empty($week_day_slots[4]))

                                            @endphp

                                        </td>

                                        <td class="{{ !empty($week_day_on_off_status['5']) ? 'bg-danger' : '' }}">

                                            <div class="row mb-2">

                                                <div class="col-md-12 text-right">

                                                    <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="5"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                </div>

                                            </div>
                                            
                                            @php
                                            
                                            if(!empty($week_day_slots[5])){

                                                foreach($week_day_slots[5] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                                        {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                                    </a>

                                                    @php

                                                } // foreach($week_day_slots[5] as $day_slot)

                                            } else {

                                                @endphp
                                                
                                                    <p class="text-center text-mute"> No slots </p>

                                                @php
                                            
                                            } // if(!empty($week_day_slots[5]))

                                            @endphp

                                        </td>

                                        <td class="{{ !empty($week_day_on_off_status['6']) ? 'bg-danger' : '' }}">

                                            <div class="row mb-2">

                                                <div class="col-md-12 text-right">

                                                    <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="6"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                </div>

                                            </div>
                                            
                                            @php
                                            
                                            if(!empty($week_day_slots[6])){

                                                foreach($week_day_slots[6] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                                        {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                                    </a>

                                                    @php

                                                } // foreach($week_day_slots[6] as $day_slot)

                                            } else {

                                                @endphp
                                                
                                                    <p class="text-center text-mute"> No slots </p>

                                                @php
                                            
                                            } // if(!empty($week_day_slots[6]))

                                            @endphp

                                        </td>

                                        <td class="{{ !empty($week_day_on_off_status['7']) ? 'bg-danger' : '' }}">

                                            <div class="row mb-2">

                                                <div class="col-md-12 text-right">

                                                    <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="7"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                                </div>

                                            </div>
                                            
                                            @php
                                            
                                            if(!empty($week_day_slots[7])){

                                                foreach($week_day_slots[7] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                                        {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                                    </a>

                                                    @php

                                                } // foreach($week_day_slots[7] as $day_slot)

                                            } else {

                                                @endphp
                                                
                                                    <p class="text-center text-mute"> No slots </p>

                                                @php
                                            
                                            } // if(!empty($week_day_slots[7]))

                                            @endphp

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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js" integrity="sha512-2xXe2z/uA+2SyT/sTSt9Uq4jDKsT0lV4evd3eoE/oxKih8DSAsOF6LUb+ncafMJPAimWAXdu9W+yMXGrCVOzQA==" crossorigin="anonymous"></script>

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

        }); // ready


    </script>

@stop
