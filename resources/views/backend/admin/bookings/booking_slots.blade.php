@extends('layouts.app')

@section('title', 'Booking Slots')

@section('main-content')

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row align-items-center">
            
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4 class="font-size-18"> Calendar </h4>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/"> Home </a></li>
                        <li class="breadcrumb-item active"> Calendar </li>
                    </ol>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="float-right d-none d-md-block">
                    
                    @if(!empty($can_edit))

                        <a href="javascript:;" title="Booking calendar" class="btn btn-primary waves-effect waves-light" id="switch-off-days">
                            <i class="fa fa-calendar mr-2"></i> Switch Off Days
                        </a>

                    @endif

                </div>
            </div>
            
        </div>
        <!-- end page title -->

        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            
                            <div class="col-lg-6">
                                
                                <h4 class="card-title"> Manage Booking Time Slots </h4>
                                <p class="card-title-desc"> You can add time slots simply by clicking the Manage Slots button below. </p>

                            </div>
                            
                            <div class="col-lg-6 text-right">

                                @php

                                    if(!empty($is_child_pharmacy)){
                                        
                                        @endphp

                                        <div class="form-group mb-0 pb-0">

                                            <label class="mr-3">
                                                
                                                <input type="radio" class="update-use-calendar" id="use_calendar_global" name="use_calendar" {{ (!empty($use_calendar) && $use_calendar == 'GLOBAL') ? 'checked="checked"' : '' }} value="GLOBAL" />

                                                Global Calendar

                                            </label>

                                            <label>

                                                <input type="radio" class="update-use-calendar" id="use_calendar_local" name="use_calendar" value="LOCAL" {{ (!empty($use_calendar) && $use_calendar == 'LOCAL') ? 'checked="checked"' : '' }} />

                                                Local Calendar

                                            </label>

                                        </div>

                                        @php

                                    } // if(!empty($is_child_pharmacy))

                                @endphp

                            </div>

                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">

                                <thead>
                                    <tr>
                                        
                                        <th>
                                            
                                            <div class="row">
                                                
                                                <div class="col-md-5"> Mon </div>
                                                <div class="col-md-7">
                                                    
                                                    @if(!empty($can_edit))

                                                        <span class="pull-right">

                                                            <input type="checkbox" class="week-day-switch" id="monday_switch" switch="none" {{ !empty($week_day_on_off_status['1']) ? '' : 'checked="checked"' }} value="1" />

                                                            <label for="monday_switch" data-on-label="On" data-off-label="Off"></label>

                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                        </th>
                                        <th>
                                            
                                            <div class="row">
                                                
                                                <div class="col-md-5"> Tue </div>
                                                
                                                <div class="col-md-7">
                                                    
                                                    @if(!empty($can_edit))

                                                        <span class="pull-right">

                                                            <input type="checkbox" class="week-day-switch" id="tuesday_switch" switch="none" {{ !empty($week_day_on_off_status['2']) ? '' : 'checked="checked"' }} value="2" />

                                                            <label for="tuesday_switch" data-on-label="On" data-off-label="Off"></label>

                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                        </th>
                                        <th>
                                            
                                            <div class="row">
                                            
                                                <div class="col-md-5">Wed</div>
                                                
                                                <div class="col-md-7">
                                                    
                                                    @if(!empty($can_edit))

                                                        <span class="pull-right">

                                                            <input type="checkbox" class="week-day-switch" id="wednesday_switch" switch="none" {{ !empty($week_day_on_off_status['3']) ? '' : 'checked="checked"' }} value="3" />

                                                            <label for="wednesday_switch" data-on-label="On" data-off-label="Off"></label>

                                                        </span>

                                                    @endif

                                                </div>
                                            
                                            </div>

                                        </th>
                                        <th>
                                            
                                            <div class="row">
                                                
                                                <div class="col-md-5"> Thu </div>
                                                
                                                <div class="col-md-7">
                                                    
                                                    @if(!empty($can_edit))

                                                        <span class="pull-right">

                                                            <input type="checkbox" class="week-day-switch" id="thursday_switch" switch="none" {{ !empty($week_day_on_off_status['4']) ? '' : 'checked="checked"' }} value="4" />

                                                            <label for="thursday_switch" data-on-label="On" data-off-label="Off"></label>

                                                        </span>

                                                    @endif

                                                </div>
                                            
                                            </div>

                                        </th>
                                        <th>
                                            
                                            <div class="row">

                                                <div class="col-md-5"> Fri </div>
                                            
                                                <div class="col-md-7">
                                                    
                                                    @if(!empty($can_edit))

                                                        <span class="pull-right">

                                                            <input type="checkbox" class="week-day-switch" id="friday_switch" switch="none" {{ !empty($week_day_on_off_status['5']) ? '' : 'checked="checked"' }} value="5" />

                                                            <label for="friday_switch" data-on-label="On" data-off-label="Off"></label>

                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                        </th>

                                        <th>
                                            
                                            <div class="row">
                                            
                                                <div class="col-md-5"> Sat </div>
                                            
                                                <div class="col-md-7">
                                                    
                                                    @if(!empty($can_edit))

                                                        <span class="pull-right">

                                                            <input type="checkbox" class="week-day-switch" id="saturday_switch" switch="none" {{ !empty($week_day_on_off_status['6']) ? '' : 'checked="checked"' }} value="6" />

                                                            <label for="saturday_switch" data-on-label="On" data-off-label="Off"></label>

                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                        </th>

                                        <th>
                                            
                                            <div class="row">
                                                
                                                <div class="col-md-5"> Sun </div>
                                                
                                                <div class="col-md-7">
                                                    
                                                    @if(!empty($can_edit))

                                                        <span class="pull-right">

                                                            <input type="checkbox" class="week-day-switch" id="sunday_switch" switch="none" {{ !empty($week_day_on_off_status['7']) ? '' : 'checked="checked"' }} value="7" />

                                                            <label for="sunday_switch" data-on-label="On" data-off-label="Off"></label>

                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        
                                        <td class="{{ !empty($week_day_on_off_status['1']) ? 'bg-danger' : '' }}">
                                            
                                            @if(!empty($can_edit))

                                                <div class="row mb-2">
                                                    
                                                    <div class="col-md-12 text-right">
                                                        
                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots" data-day-number="1"> <i class="fa fa-clock mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>

                                            @endif

                                            @php
                                            
                                            if(!empty($week_day_slots[1])){

                                                foreach($week_day_slots[1] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-secondary mb-1">  {{ CommonCustomHelper::time_format($day_slot['slot_start_time']) }} </a>

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
                                            
                                            @if(!empty($can_edit))

                                                <div class="row mb-2">
                                                    
                                                    <div class="col-md-12 text-right">
                                                        
                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots" data-day-number="2"> <i class="fa fa-clock mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>

                                            @endif
                                            
                                            @php
                                            
                                            if(!empty($week_day_slots[2])){

                                                foreach($week_day_slots[2] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-secondary mb-1">    {{ CommonCustomHelper::time_format($day_slot['slot_start_time']) }} </a>

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
                                            
                                            @if(!empty($can_edit))

                                                <div class="row mb-2">
                                                    
                                                    <div class="col-md-12 text-right">
                                                        
                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots" data-day-number="3"> <i class="fa fa-clock mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>

                                            @endif
                                            
                                            @php
                                            
                                            if(!empty($week_day_slots[3])){

                                                foreach($week_day_slots[3] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-secondary mb-1">    {{ CommonCustomHelper::time_format($day_slot['slot_start_time']) }} </a>

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
                                            
                                            @if(!empty($can_edit))

                                                <div class="row mb-2">
                                                    
                                                    <div class="col-md-12 text-right">
                                                        
                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots" data-day-number="4"> <i class="fa fa-clock mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>

                                            @endif
                                            
                                            @php
                                            
                                            if(!empty($week_day_slots[4])){

                                                foreach($week_day_slots[4] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-secondary mb-1">    {{ CommonCustomHelper::time_format($day_slot['slot_start_time']) }} </a>

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
                                            
                                            @if(!empty($can_edit))

                                                <div class="row mb-2">
                                                    
                                                    <div class="col-md-12 text-right">
                                                        
                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots" data-day-number="5"> <i class="fa fa-clock mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>

                                            @endif
                                            
                                            @php
                                            
                                            if(!empty($week_day_slots[5])){

                                                foreach($week_day_slots[5] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-secondary mb-1">    {{ CommonCustomHelper::time_format($day_slot['slot_start_time']) }} </a>

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
                                            
                                            @if(!empty($can_edit))

                                                <div class="row mb-2">
                                                    
                                                    <div class="col-md-12 text-right">
                                                        
                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots" data-day-number="6"> <i class="fa fa-clock mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>

                                            @endif
                                            
                                            @php
                                            
                                            if(!empty($week_day_slots[6])){

                                                foreach($week_day_slots[6] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-secondary mb-1">    {{ CommonCustomHelper::time_format($day_slot['slot_start_time']) }} </a>

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

                                            @if(!empty($can_edit))
                                            
                                                <div class="row mb-2">
                                                    
                                                    <div class="col-md-12 text-right">
                                                        
                                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots" data-day-number="7"> <i class="fa fa-clock mr-1"></i> Manage Slots </a>

                                                    </div>

                                                </div>

                                            @endif
                                            
                                            @php
                                            
                                            if(!empty($week_day_slots[7])){

                                                foreach($week_day_slots[7] as $day_slot){

                                                    @endphp

                                                    <a href="#" class="btn btn-sm d-block btn-secondary mb-1">    {{ CommonCustomHelper::time_format($day_slot['slot_start_time']) }} </a>

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
            </div> <!-- end col -->
        </div> <!-- end row -->    

    </div> <!-- container-fluid -->

    <!-- Drive Booking SLots modules and each action against the below field as reference to the pharmacy -->
    <input type="hidden" id="calendar_pharmacy_id" name="calendar_pharmacy_id" readonly="readonly" value="{{ $calendar_pharmacy_id }}" />

    <script type="text/javascript">
        
        $(document).ready(function(){

            $('.update-use-calendar').change(function(){

                var use_calendar = $(this).val();

                $.ajax({

                    type: "POST",
                    url: "/bookings/update_use_calendar_process",
                    // processData: false,
                    // contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    data: {

                        'use_calendar' : use_calendar

                    },
                    
                    beforeSend: function(result) {

                        $("#loading").css("display","block");
                        $('#crud_errors_div').addClass('d-none');
                        $('#crud_errors_ul').html('');

                    },
                    
                    success: function(response) {

                        $("#loading").css("display","none");
                          
                        if (response.status == 'success') {
                              
                            mc_notify('success', response.message);

                            location.reload();

                        }

                        $('#crud_errors_div').addClass('d-none');
                        $('#crud_errors_ul').html('');

                        // console.log(response);

                    },
                      
                    error: function(xhr, status, error) {

                        $("#loading").css("display","none");

                        $.each(xhr.responseJSON.errors, function(key, item) {

                            // mc_notify('danger', item);
                              
                            $('#crud_errors_div').removeClass('d-none');
                            $('#crud_errors_ul').removeClass('d-none');

                            var new_html = '<li> ' + item + ' </li>';
                            $('#crud_errors_ul').append(new_html);

                        });

                    }

                }); // $.ajax

            }); // .update-use-calendar

            $('#switch-off-days').click(function(){

                var _token = $('meta[name="csrf-token"]').attr('content');
                var _this = this;

                $.ajax({

                    type: "GET",
                    url: "/bookings/switch_off_dates",
                    
                    /*data: {
                        'day_number': day_number,
                        _token: _token
                    },*/

                    beforeSend: function(result) {
                        //$("#overlay").removeClass("hidden");
                    },
                    success: function(response) {


                        $("#loading").css("display", "none");

                        // swal(response);

                        var popup_title = 'Switch Off Days';

                        $('#mc-popup-dialog').addClass('modal-md');

                        // Set Heading
                        $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                        // Set Body
                        $('#general_bootstrap_ajax_popup_body').html(response);

                        $('#general_bootstrap_ajax_popup').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                    } // success

                }); // $.ajax

            }); // click => .switch-off-days

            $('.week-day-switch').change(function(){

                var day_status = '';
                var slot_day_number = $(this).val();

                if( $(this).prop('checked') == true ){

                    // Turn the day on
                    day_status = 'ON';

                } else if( $(this).prop('checked') == false ){

                    // Turn the day off
                    day_status = 'OFF';

                } // if( $(this).prop('checked') == true )

                // alert(slot_day_number+' - '+day_status);

                $.ajax({

                    type: "POST",
                    url: "{{ route('update_booking_slot_day_status') }}",
                    // processData: false,
                    // contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        
                        'slot_day_number' : slot_day_number,
                        'day_status' : day_status
                    },

                    beforeSend: function(result) {
                        
                        $("#loading").css("display","block");

                    },
                    success: function(response) {
                        
                        // $("#loading").css("display","none");

                        location.reload();
                       
                    } // success

                }); // $.ajax

            }); // .week-day-switch

            /////////// Function to Manage Day Slots ///////////

            $('.manage-day-slots').click(function(){

                var day_number = $(this).attr('data-day-number');

                var _token = $('meta[name="csrf-token"]').attr('content');
                var _this = this;

                $.ajax({

                    type: "GET",
                    url: "/bookings/manage_day_slots/" + day_number,
                    
                    /*data: {
                        'day_number': day_number,
                        _token: _token
                    },*/

                    beforeSend: function(result) {
                        //$("#overlay").removeClass("hidden");
                    },
                    success: function(response) {


                        $("#loading").css("display", "none");

                        // swal(response);

                        var popup_title = 'Manage Slots';

                        $('#mc-popup-dialog').addClass('modal-md');

                        // Set Heading
                        $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                        // Set Body
                        $('#general_bootstrap_ajax_popup_body').html(response);

                        $('#general_bootstrap_ajax_popup').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                    } // success

                }); // $.ajax

            }); // click => .manage-day-slots

        }); // ready

    </script>

@endsection