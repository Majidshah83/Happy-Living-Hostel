<?php $full_path = env('MEDIA_PATH_HTTP');?>

<form action="javascript:;" id="booking_process_form">

    <input type="hidden" name="booking_id" value="{{ $booking_details['id'] }}" readonly="readonly" />

    <div class="row">

        <div class="col-md-5 col-sm-12">

            @if(!empty($pharmacy_settings->logo_1))

                <img src="{{ $full_path.'pharmacyprofile/'.$pharmacy_settings->logo_1 }}"
                class="img-fluid mt-3" />

            @endif

        </div>

        <div class="col-md-2 col-sm-12 text-center">

        </div>

        <div class="col-md-5 col-sm-12">

            {{ $pharmacy_details->business_name }}
            
            <br />

            @php

            $prescriber_address = '';

            $prescriber_address .= ($prescriber_details->address_1) ? $prescriber_details->address_1 : '' ;
            $prescriber_address .= ($prescriber_details->address_2) ? ', '.$prescriber_details->address_2 : '' ;
            $prescriber_address .= ($prescriber_details->address_3) ? ', '.$prescriber_details->address_3 : '' ;
            $prescriber_address .= ($prescriber_details->city) ? ', '.$prescriber_details->city : '' ;
            $prescriber_address .= ($prescriber_details->postcode) ? ', '.$prescriber_details->postcode : '' ;

            @endphp

            {{ $prescriber_address }}
            
            <br />

            Tel:

            <a href="tel:{{ (!empty($prescriber_details->phone_no)) ? $prescriber_details->phone_no : '' }}">
                
                {{ (!empty($prescriber_details->phone_no)) ? $prescriber_details->phone_no : '' }}

            </a>
            
            <br />
            
            Email:

            <a href="mailto:{{ (!empty($prescriber_details->email)) ? $prescriber_details->email : '' }}">
                
                {{ (!empty($prescriber_details->email)) ? $prescriber_details->email : '' }}

            </a>

            <br />

            <a href="{{ env('FRONT_WEBSITE_URL') }}" target="_blank">
                
                {{ env('FRONT_WEBSITE_URL') }}

            </a>

        </div>

    </div>

    <div class="row mt-5">

        <div class="col-md-12 col-sm-12">

            <p>

                IgM Test and PCR swab taken at the same time at the same site

                <input type="text" class="" id="pcr_test_date" name="pcr_test_date" value="{{ !empty($booking_details['pcr_test_date']) ? $booking_details['pcr_test_date'] : '' }}" />.

            </p>

            <p>

                Client Name -

                {{ $patient_details['first_name'] }}
                {{ $patient_details['last_name'] }}

            </p>

            <p>
                Passport Number: {{ $patient_details['passport_number'] }}
            </p>

            <!--
            <div class="form-group">

                <label> Passport Number </label>
                
                <input type="text" class="form-control w-25" id="passport_number" name="passport_number" value="{{ !empty($booking_details['passport_number']) ? $booking_details['passport_number'] : '' }}" />
                
            </div>
            -->

            <p>

                Date Of Birth - {{ date('d M Y', strtotime($patient_details['dob'])) }}

            </p>

            <p>

                UK Address - {{ $patient_details['address'] }}, {{ $patient_details['town_city'] }}, {{ $patient_details['postcode'] }}

            </p>

        </div>

    </div>

    <div class="row mt-4 mb-4">

        <div class="col-md-12 col-sm-12">

            <p>
                
                <div class="form-group">

                    <label> Igm result: </label>

                    <label class="ml-2">

                        <input type="radio" id="igm" name="igm" value="Negative" {{ !empty($booking_details['igm_result']) && $booking_details['igm_result'] == 'Negative' ? 'checked' : '' }} />

                        Negative

                    </label>

                    <label class="ml-2">

                        <input type="radio" id="igm" name="igm" value="Positive" {{ !empty($booking_details['igm_result']) && $booking_details['igm_result'] == 'Positive' ? 'checked' : '' }} />

                        Positive

                    </label>

                </div>

            </p>

        </div>

    </div>

    <div class="row mt-4 mb-4">

        <div class="col-md-12 col-sm-12">

            <p>
                
                <strong> PCR test sent to our partner laboratory, Epistem Ltd, 48 Grafton Street, Incubator building, Manchester, M13 9XX for processing. </strong>

            </p>

        </div>

    </div>

    <div class="row mt-4 mb-4">

        <div class="col-md-12 col-sm-12">

            <p>
                
                Signed

                <br />

                @if(!empty(($prescriber_details->signature)))
        
                    <img src="{{ $full_path.'signature/'.$prescriber_details->signature }}" class="img-fluid img-responsive" width="200px" />

                @endif

                <br />

                {{ $prescriber_details->first_name }}
                {{ $prescriber_details->last_name }}

                {{ $prescriber_details->qualification }},

                GPhC number {{ $prescriber_details->reg_no }}

                <br />

                Email address: <a href="mailto:{{ $prescriber_details->email }}"> {{ $prescriber_details->email }} </a>

            </p>

        </div>

    </div>

    <div class="row mt-4 mb-4">

        <div class="col-md-7 col-sm-8 text-right"></div>

        <div class="col-md-3 col-sm-2 text-right">

            Company number {{ $pharmacy_details->gphc_reg_number }}

            <br />

            VAT number {{ $pharmacy_details->vat_number }}

        </div>

        <div class="col-md-2 col-sm-2 text-right">

            @if(!empty($pharmacy_details->nhs_logo))

                <?php

                $full_path = env('MEDIA_PATH_HTTP').'website/nhs_logo/'.$pharmacy_details->nhs_logo;

                ?>

                <img src="{!! !empty($pharmacy_details->nhs_logo) ? $full_path : asset('assets/images/no-img.jpg') !!}" class="img-fluid img-responsive" width="200px" />

            @endif

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-md-12 col-sm-12">
            
            <hr />

        </div>

        <div class="col-md-2 col-sm-6"></div>

        <div class="col-md-4 col-sm-2 text-right">

            <div class="form-group">

                <select class="form-control" id="booking_status" name="booking_status">

                    <option {{ $booking_details['booking_status'] == 'PENDING' ? 'selected' : '' }} value="PENDING"> Pending </option>

                    <option {{ $booking_details['booking_status'] == 'CANCELLED' ? 'selected' : '' }} value="CANCELLED"> Cancelled </option>

                    <option {{ $booking_details['booking_status'] == 'COMPLETED' ? 'selected' : '' }} value="COMPLETED"> Completed </option>
                    
                </select>

            </div>

        </div>

        <div class="col-md-6 col-sm-6 text-right">

            <button type="button" class="btn btn-success save-booking-process" data-action="save_close"> Save &amp; Close </button>

            <button type="button" class="btn btn-info save-booking-process" data-action="save_print"> Save &amp; Print </button>

            <a href="{{ route("print_booking", ["booking_id" => $booking_details["id"]]) }}" class="btn btn-warning"> Print </a>

        </div>

    </div>

</form>

<script type="text/javascript">
    
    $(document).ready(function(){

        $('.save-booking-process').click(function(){

            var igm_result = $('input[name="igm"]:checked').val();

            if(igm_result == undefined){

                alert('Please select igm result.');
                return false;

            }
            
            var data = new FormData(document.getElementById("booking_process_form"));

            var action = $(this).attr('data-action');

            data.append('action', action);

            $.ajax({

                type: "POST",
                url: "{{ route('save_print_booking_process') }}",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,

                beforeSend: function(result) {

                    $(".bootstrap_loader").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {

                    $(".bootstrap_loader").css("display","none");

                    if(action == 'save_close'){

                        location.reload();

                    } else {

                        window.open('{{ route("print_booking", ["booking_id" => $booking_details["id"]]) }}', '_blank');
                        location.reload();

                    } // if(action == 'save_close')

                    // location.reload();

                },

                error: function(xhr, status, error) {

                    $.each(xhr.responseJSON.errors, function(key, item) {
                        
                        // mc_notify('danger', item);

                        $('#crud_errors_div').removeClass('d-none');
                        $('#crud_errors_ul').append('<li>' + item + '</li>');

                    });
                }

            }); // $.ajax

        }); //click => .save-booking-process

    }); // ready => save-booking-process

</script>