
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />


<style type="text/css">
    
    .datepicker {
        
        border: 1px solid #ddd;
        
        padding: 8px;

        z-index: 1100 !important; 

    }

</style>

<form class="custom-validation" id="mc-form">

    <div class="row d-none" id="crud_errors_div">

        <div class="col-md-12">

            <div class="alert alert-danger">

                <!-- Contain Dynamic Errors -->
                <ul class="mb-0 d-none" id="crud_errors_ul">
                </ul>

                <!-- Contain Input File Errors -->
                <ul class="mb-0 d-none" id="file_error_ul"></ul>

            </div>

        </div>

    </div>

    <div class="row">
                                    
        <div class="col-lg-6 ">
            <p><strong class="mr-2">Full Name: </strong> {!! ucfirst($data_arr['patient_details']['first_name']).' '.ucfirst($data_arr['patient_details']['last_name']) !!}</p>
        </div> 

        <div class="col-lg-6">
            
            <p>
                
                <strong class="mr-2">Status: </strong>
                    
                    <?php
                    // Verify if weekday is past
                    $date_today = date('Y-m-d');
                    if( strtotime($data_arr['booking_details']['slot_date']) < strtotime($date_today) ){
                        ?>

                        <span class="badge badge-warning">
                            Missed Booking
                        </span>

                        <?php
                    } else {
                        ?>

                        <span class="badge badge-info">
                            New Booking
                        </span>

                        <?php
                    } // if( strtotime($data_arr['booking_details']['slot_date']) < strtotime($date_today) )
                    ?>

                </span>

            </p>

        </div> 

        <div class="col-lg-6">
            <p><strong class="mr-2">Booking Type: </strong> {{ ($data_arr['booking_details']['booking_type'] == 'INHOUSE') ? 'In House' : 'Online' }} </p>
        </div>

        <div class="col-lg-6">
            <p><strong class="mr-2">Booking ID: </strong> {{ $data_arr['booking_details']['id'] }} </p>
        </div>

    </div>

    <div class="row">
     
        <div class="col-lg-12">

            <div class="form-group">
                
                <label> Select a Service to book </label>
                
                <select class="form-control" id="service_id" name="service_id" required="required">

                    <option value=""> Select </option>

                    <?php
                    if(!empty($data_arr['shared_services_list'])){
                        foreach($data_arr['shared_services_list'] as $service){

                            ?>

                            <option {{ ($data_arr['booking_details']['service_id'] == $service['id']) ? 'selected="selected"' : '' }} value="{!! ucfirst($service['id']) !!}"> {!! ucfirst($service['title']) !!} </option>

                            <?php

                        } // foreach($data_arr['shared_services_list'] as $service)
                    } // if(!empty($data_arr['shared_services_list']))
                    ?>
                    
                </select>

            </div>
        </div>

    </div>

    <div class="row " id="booking_details_div">

        <div class="col-lg-12 mb-3">
            
            <label> Select Date & Time </label>

            <div class="input-group">
                
                <input type="text" class="form-control mc-datepicker" id="slot_date" name="slot_date" value="{{ date('d/m/Y', strtotime($data_arr['booking_details']['slot_date'])) }}"  />

                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>

            </div>

        </div> 

        <div class="col-lg-12 mb-3">
           
            <!-- Ajax div contains booking slots -->
           <div class="row ml-2 mr-2 p-3" style="border:1px solid #ccc;" id="booking_time_slots_div"></div>    
            
        </div>

        <input type="hidden" id="booking_patient_id" name="patient_id" value="{{ $data_arr['booking_details']['patient_id'] }}" readonly="readonly" />

        <div class="col-lg-12 mb-3">

             <div class="form-group">
                <label> Note </label>
                <div>
                    <textarea class="form-control" id="booking_note" name="booking_note" rows="5" required="required">{!! $data_arr['booking_details']['booking_note'] !!}</textarea>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-12">
            <div class="form-group">
                
                <label>Status </label>
                <select class="form-control" id="booking_status" name="booking_status">
                    
                    <option {{ ($data_arr['booking_details']['booking_status'] == 'PENDING') ? 'selected="selected"' : '' }} value="PENDING"> Pending </option>
                    
                    <option {{ ($data_arr['booking_details']['booking_status'] == 'COMPLETED') ? 'selected="selected"' : '' }} value="COMPLETED"> Completed </option>
                    
                    <option {{ ($data_arr['booking_details']['booking_status'] == 'CANCELLED') ? 'selected="selected"' : '' }} value="CANCELLED"> Cancelled </option>
                    
                </select>

            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="form-group mb-0">
                
                <div>
                    
                    <button type="button" class="btn btn-primary waves-effect waves-light mr-1" id="mc_frm_submit_btn">
                        Submit
                    </button>

                    <button data-dismiss="modal" class="btn btn-danger waves-effect waves-light mr-1">
                        Cancel
                    </button>

                </div>

            </div>

        </div>
    </div>

    <input type="hidden" id="booking_id" name="booking_id" value="{{ $data_arr['booking_details']['id'] }}" readonly="readonly" />

</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {

    $('#search_patient').change(function(){

        $('#booking_patient_id').val( $(this).val() );

    }); // change => #search_patient

    $('#service_id').change(function(){

        if( $(this).val() == '' ){

            // $('#booking_details_div').addClass('d-none');

        } else {

            // $('#booking_details_div').removeClass('d-none');

            get_week_day_available_slots( $('#slot_date').val() )

        } // if( $(this).val() == '' )

    }); // change => #service_id

    $('#slot_date').datepicker({
        
        format: 'dd/mm/yyyy',
        // startDate: new Date(),
        autoclose: true,

    }).on('changeDate', function(e) {
        
        get_week_day_available_slots( $(this).val() );

    });

    // Trigger change to load the default selected date booking slots
    get_week_day_available_slots( "{{ date('d/m/Y', strtotime($data_arr['request_arr']['week_day'])) }}" );

    $("#mc_frm_submit_btn").click(function(event){

        event.preventDefault();

        var data = new FormData(document.getElementById("mc-form"));
        
        $.ajax({

            type: "POST",
            url: "/bookings/edit_booking_process",
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            data: data,
            beforeSend: function(result) {

                $("#loading").css("display","block");
                $('#crud_errors_div').addClass('d-none');
                $('#crud_errors_ul').html('');

            },
            success: function(response) {


                $("#loading").css("display","none");
                
                if (response.status == 'success') {
                    
                    // mc_notify('success', response.message);

                    $("#general_bootstrap_ajax_popup").modal('hide');
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

    });

});

// Start => function get_week_day_available_slots(week_date='')
function get_week_day_available_slots(week_date=''){

    var service_id = $('#service_id').val();
    
    var week_day = week_date;

    var edit_slot_start_time = "{{ $data_arr['booking_details']['slot_start_time'] }}";

    var edit_booking_id = "{{ $data_arr['booking_details']['id'] }}";

    // Refresh time slots according to the new date
    $.ajax({

        type: "POST",
        url: "{{ route('get_week_day_available_slots') }}",
        // processData: false,
        // contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        data: {
            
            'service_id' : service_id,
            'week_day' : week_day,

            'edit_slot_start_time' : edit_slot_start_time,
            'edit_booking_id' : edit_booking_id

        },

        beforeSend: function(result) {

            $("#loading").css("display","block");

            $('#crud_errors_div').addClass('d-none');
            $('#crud_errors_ul').html('');

        },
        
        success: function(response) {
            
            $("#loading").css("display","none");

            $("#booking_time_slots_div").html(response);
            
        } // success

    }); // $.ajax

} // End => function get_week_day_available_slots(week_date='')

</script>