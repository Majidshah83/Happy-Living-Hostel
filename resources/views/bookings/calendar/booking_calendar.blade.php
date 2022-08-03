@extends('layouts.app')

@section('title', 'Booking Calendar')

@section('main-content')

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row align-items-center">
            
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4 class="font-size-18">Booking Calendar</h4>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Calendar</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="float-right d-none d-md-block">
                    
                    

                </div>
            </div>
            
        </div>     
        <!-- end page title -->

        <div class="row">

            <div class="col-lg-12">
                <div class="card" id="main-parent-ajax-div">
                    <div class="card-body">

                        <!-- Full Calendar Ajax Contents [ next_prev ] -->
                        <div id="full_calendar_div"></div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->    

    </div> <!-- container-fluid -->

    <!-- Page Scripts -->
    <script>
    (function($){
      
      $('#calendar_pharmacy_id').change(function(){

        var calendar_pharmacy_id = $('#calendar_pharmacy_id').val();

        $.ajax({

            type: "POST",
            url: "{{ route('next_prev_booking_calendar') }}",
            // processData: false,
            // contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            data: {
                'action': 'current_day',
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

      }); // change => #calendar_pharmacy_id

      $('#full_calendar_div').on('click', '#prev_day_weekly, #next_day_weekly, #current_day_weekly', function (e) 
      {

        var action = $(this).attr('id');
        var current_day = $('#rxdate_weekly').attr('rel');

        var calendar_pharmacy_id = $('#calendar_pharmacy_id').val();

        $.ajax({

            type: "POST",
            url: "{{ route('next_prev_booking_calendar') }}",
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

        // get document width
        var document_width = $(document).width();

        var calendar_pharmacy_id = $('#calendar_pharmacy_id').val();

        $.ajax({

            type: "POST",
            url: "{{ route('next_prev_booking_calendar') }}",
            // processData: false,
            // contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'action': 'current_day',
                'document_width':document_width,
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

        ///////////////// add-new-inhouse-booking ////////////////

        $('#full_calendar_div').on('click', '.add-new-inhouse-booking', function(){

            var calendar_pharmacy_id = $(this).attr('data-calendar-pharmacy-id');
            
            var booking_slots_reference_pharmacy_id = $(this).attr('data-booking-slots-reference-pharmacy-id');
            
            var week_day = $(this).attr('data-week-day');

            // alert( calendar_pharmacy_id + ' - ' + booking_slots_reference_pharmacy_id + ' - ' + week_day );

            $.ajax({

                type: "POST",
                url: "{{ route('add_new_inhouse_booking') }}",
                // processData: false,
                // contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {

                    'calendar_pharmacy_id' : calendar_pharmacy_id,

                    'booking_slots_reference_pharmacy_id' : booking_slots_reference_pharmacy_id,

                    'week_day' : week_day
                },

                beforeSend: function(result) {
                    
                    $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {
                    
                    $("#loading").css("display","none");

                    // swal(response);

                    var popup_title = 'Add New Booking';


                    $('#mc-popup-dialog').addClass('modal-lg');

                    // Set Heading
                    $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                    // Set Body
                    $('#crud_contents').html(response);

                    // Set Footer
                    $('#general_bootstrap_ajax_popup_footer').prepend('');

                    $('#general_bootstrap_ajax_popup').modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                } // success

            }); // $.ajax

        }); // $('#full_calendar_div').on('click', '.add-new-inhouse-booking', function()

        ///////////////// edit-booking //////////////////

        $('#full_calendar_div').on('click', '.edit-booking', function(){

            var calendar_pharmacy_id = $(this).attr('data-calendar-pharmacy-id');
            
            var booking_slots_reference_pharmacy_id = $(this).attr('data-booking-slots-reference-pharmacy-id');
            
            var week_day = $(this).attr('data-week-day');

            var booking_id = $(this).attr('data-booking-id');

            // alert( calendar_pharmacy_id + ' - ' + booking_slots_reference_pharmacy_id + ' - ' + week_day );

            $.ajax({

                type: "POST",
                url: "{{ route('edit_booking') }}",
                // processData: false,
                // contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {

                    'calendar_pharmacy_id' : calendar_pharmacy_id,

                    'booking_slots_reference_pharmacy_id' : booking_slots_reference_pharmacy_id,

                    'week_day' : week_day,

                    'booking_id' : booking_id
                },

                beforeSend: function(result) {
                    
                    $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {
                    
                    $("#loading").css("display","none");

                    // swal(response);

                    var popup_title = 'Edit Booking';
                    
                    $('#mc-popup-dialog').addClass('modal-lg');

                    // Set Heading
                    $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                    // Set Body
                    $('#crud_contents').html(response);

                    // Set Footer
                    $('#general_bootstrap_ajax_popup_footer').prepend('');

                    $('#general_bootstrap_ajax_popup').modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                } // success

            }); // $.ajax

        }); // $('#full_calendar_div').on('click', '.edit-booking', function()

      }); // documen.ready function

    })( jQuery );

    </script>

@endsection