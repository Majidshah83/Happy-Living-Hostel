
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />


<style type="text/css">
    
    .datepicker {
        
        border: 1px solid #ddd;
        
        padding: 8px;

        z-index: 1100 !important; 

    }

</style>

<link rel="stylesheet" type="text/css" href="{{asset('assets/third-party/select2-develop/dist/css/select2.min.css')}}">

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
     
        <div class="col-lg-12">

            <div class="form-group">
                
                <label> Select a Service to book </label>
                
                <select class="form-control" id="service_id" name="service_id" required="required">

                    <option value=""> Select </option>

                    <?php
                    if(!empty($data_arr['shared_services_list'])){
                        foreach($data_arr['shared_services_list'] as $service){

                            ?>

                            <option value="{!! ucfirst($service['id']) !!}"> {!! ucfirst($service['title']) !!} </option>

                            <?php

                        } // foreach($data_arr['shared_services_list'] as $service)
                    } // if(!empty($data_arr['shared_services_list']))
                    ?>
                    
                </select>

            </div>
        </div>

    </div>

    <div class="row d-none" id="booking_details_div">

        <div class="col-lg-12 mb-3">
            
            <label> Select Date & Time </label>

            <div class="input-group">
                
                <input type="text" class="form-control mc-datepicker" id="slot_date" name="slot_date" value="{{ date('d/m/Y', strtotime($data_arr['request_arr']['week_day'])) }}"  />

                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>

            </div>

        </div> 

        <div class="col-lg-12 mb-3">
           
            <!-- Ajax div contains booking slots -->
           <div class="row ml-2 mr-2 p-3" style="border:1px solid #ccc;" id="booking_time_slots_div"></div>    
            
        </div>

        <div class="col-md-12 mb-3">
                
            <label>Search a patient by last name </label>
            
            <div class="form-group">

                <!-- For defining autocomplete -->
                <select id="search_patient" class="form-control" style="width: 100%;">

                  <option value='0'> Select Patient </option>

                </select>

            </div>

        </div>

        <!--
        <a href="javascript:;" class="btn btn-sm btn-primary add-new-patient-popup"><i class="fa fa-plus mr-1"></i> Add Patient </a>
        -->

        <input type="hidden" id="booking_patient_id" name="patient_id" value="" readonly="readonly" />

        <div class="col-lg-12 mb-3">

             <div class="form-group">
                <label> Note </label>
                <div>
                    <textarea class="form-control" id="booking_note" name="booking_note" rows="5" required="required"></textarea>
                </div>
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

</form>

<!-- add_patient_bootstrap_ajax_popup -->
<div class="modal" id="add_patient_bootstrap_ajax_popup">
    <div class="modal-dialog" id="mc-add-patient-popup-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="add_patient_bootstrap_ajax_popup_heading"></h4>
                <button type="button" class="close add_patient_bootstrap_ajax_popup_close_btn"
                     onClick="$('#add_patient_bootstrap_ajax_popup').modal('hide');">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="add_patient_bootstrap_ajax_popup_body">
                
                <div class="row d-none" id="add_patient_crud_errors_div">

                    <div class="col-md-12">

                        <div class="alert alert-danger">

                            <!-- Contain Dynamic Errors -->
                            <ul class="mb-0" id="add_patient_crud_errors_ul"></ul>

                            <!-- Contain Input File Errors -->
                            <ul class="mb-0" id="add_patient_file_error_ul"></ul>

                        </div>

                    </div>

                </div>

                <!-- Contain Dynamic Contents -->
                <div id="add_patient_crud_contents"></div>

            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

<script src="{{asset('assets/third-party/select2-develop/dist/js/select2.min.js')}}" type="text/javascript"></script>

<!-- Script -->
<script>
        
    $(document).ready(function(){

        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $( "#search_patient" ).select2({

            ajax: {
                
                url: "{{route('search_patient_ajax')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                
                data: function (params) {
                    return {

                        _token: CSRF_TOKEN,
                        search: params.term,
                        page: params.page || 1,

                    };
                },
                
                processResults: function (response, params) {

                    // console.log(response.total_count); return;

                    params.page = params.page || 1;

                    return {
                        
                        results: response.data,
                        "pagination": {
                            "more": response.total_count
                        }

                    };

                },
                
                cache: false

            } // ajax

        }); // $( "#search_patient" ).select2

    }); // ready

</script>

<script>
$(document).ready(function() {

    $('#search_patient').change(function(){

        $('#booking_patient_id').val( $(this).val() );

    }); // change => #search_patient

    $('.add-new-patient-popup').click(function(){

        $.ajax({

            type: "GET",
            
            url: "{{ route('add_new_patient_popup') }}",
            // url: "/patient/add_edit",
            
            // processData: false,
            // contentType: false,
            
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            beforeSend: function(result) {
                
                $("#loading").css("display","block");

                $('#add_patient_crud_errors_div').addClass('d-none');
                $('#add_patient_crud_errors_ul').html('');

            },
            success: function(response) {
                
                $("#loading").css("display","none");

                // swal(response);

                var popup_title = 'Add New Patient';


                $('#mc-add-patient-popup-dialog').addClass('modal-lg');

                // Set Heading
                $('#add_patient_bootstrap_ajax_popup_heading').html(popup_title);

                // Set Body
                $('#add_patient_crud_contents').html(response);

                // Set Footer
                $('#add_patient_bootstrap_ajax_popup_footer').prepend('');

                $('#add_patient_bootstrap_ajax_popup').modal({
                    backdrop: 'static',
                    keyboard: false
                });

            } // success

        }); // $.ajax

    }); // click => .add-new-patient-popup


    $('#service_id').change(function(){

        if( $(this).val() == '' ){

            $('#booking_details_div').addClass('d-none');

        } else {

            $('#booking_details_div').removeClass('d-none');

            get_week_day_available_slots( $('#slot_date').val() )

        } // if( $(this).val() == '' )

    }); // change => #service_id

    $('#slot_date').datepicker({
        
        format: 'dd/mm/yyyy',
        // startDate: new Date(),
        autoclose: true,

    }).on('changeDate', function(e) {
        
        $('[id^="slot_start_time"]').val('');

        $('.mc-booking-slot').removeClass('btn-success');
        $('.mc-booking-slot').removeClass('btn-secondary');
        
        $('.mc-booking-slot').addClass('btn-secondary');

        get_week_day_available_slots( $(this).val() );

    });

    // Trigger change to load the default selected date booking slots
    get_week_day_available_slots( "{{ date('d/m/Y', strtotime($data_arr['request_arr']['week_day'])) }}" );

    $("#mc_frm_submit_btn").click(function(event){

        event.preventDefault();

        var data = new FormData(document.getElementById("mc-form"));
        
        $.ajax({

            type: "POST",
            url: "/bookings/add_new_inhouse_booking_process",
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
            'week_day' : week_day

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