<form class="custom-validation" id="mc-add-patient-form">
    <div class="row">

        <div class="col-lg-6">
            <div class="form-group">
                <label>First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="first_name"
                    value="{!! !empty($item_details) ? CommonCustomHelper::filter_string($item_details->first_name) : '' !!}">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="last_name"
                    value="{!! !empty($item_details) ? CommonCustomHelper::filter_string($item_details->last_name) : '' !!}">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Contact No </label>
                <input type="text" class="form-control" name="contact_no"
                    value="{!! !empty($item_details) ? CommonCustomHelper::filter_string($item_details->contact_no) : '' !!}">
            </div>
        </div>


        <div class="col-lg-6">
            <div class="form-group">
                <label>NHS Number</label>
                <input type="text" class="form-control" name="nhs_no"
                    value="{!! !empty($item_details) ? CommonCustomHelper::filter_string($item_details->nhs_no) : '' !!}">
            </div>
        </div>


        <div class="col-lg-12 col-sm-12">



            <div class="form-group has-success">
                
                <label class="d-block"> Gender <span class="text-danger">*</span> </label>
                
                <label>
                    
                    <input type="radio" class="custom-radio" name="gender" id="gender1" value="MALE" {{  !empty($item_details) && ($item_details->gender == 'MALE') ? 'checked' : '' }} /> Male

                </label>
                
                <label>

                    <input type="radio" class="custom-radio ml-2" name="gender" id="gender1" value="FEMALE" {{ !empty($item_details) && ($item_details->gender == 'FEMALE') ? 'checked' : '' }}>
                    Female

                </label>

                <label>

                    <input type="radio" class="custom-radio ml-2" name="gender" id="gender1" value="OTHER" {{ !empty($item_details) && ($item_details->gender == 'OTHER') ? 'checked' : '' }}>
                    Other

                </label>

            </div>

        </div>

        <div class="col-lg-12 col-sm-12">

            <div class="form-group mb-0 pb-0">

                <label> Date Of Birth <span class="text-danger">*</span> </label>

            </div>

        </div>

        <div class="col-lg-4 col-sm-12">

            <div class="form-group">

                <label> Day </label>

                <select class="form-control" id="day" name="day">
                    <option value="">Select Day</option>

                    @if(isset($item_details))
                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}"
                        {{ (  \Carbon\Carbon::parse($item_details->dob)->format('d')  == $i) ? 'selected' : '' }}>
                        {{ $i }}
                        </option>
                        @endfor

                        @endisset
                        @if(!isset($item_details))
                        @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}"> {{ $i }} </option>
                            @endfor
                            @endisset


                </select>
            </div>

        </div>
        <div class="col-lg-4 col-sm-12">

            <div class="form-group">
                <label> Month </label>
                <select class="form-control" id="month" name="month">
                    <option value="">Select Month</option>

                    @if(isset($item_details))
                    @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}"
                        {{ (  \Carbon\Carbon::parse($item_details->dob)->format('m') == $i) ? 'selected' : '' }}>
                        {{ $i }}
                        </option>
                        @endfor

                        @endisset
                        @if(!isset($item_details))
                        @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}"> {{ $i }} </option>
                            @endfor
                            @endisset


                </select>
            </div>

        </div>

        <div class="col-lg-4 col-sm-12">

            <div class="form-group">
                <label>Year</label>
                <select class="form-control" id="year" name="year">
                    <option value="">Select Year </option>

                    @if(isset($item_details))
                    @php
                    $firstYear = (int)date('Y') - 50;
                    $lastYear = $firstYear + 50;
                    $selected = \Carbon\Carbon::parse($item_details->dob)->format('Y');
                    @endphp
                    @for($i=$firstYear;$i<=$lastYear;$i++) <option value='{{ $i }}'
                        {{ (  \Carbon\Carbon::parse($item_details->dob)->format('Y') == $i) ? 'selected' : '' }}>
                        {{ $i }}</option>

                        @endfor


                        @endisset
                        @if(!isset($item_details))

                        @php
                        $firstYear = (int)date('Y') - 50;
                        $lastYear = $firstYear + 50;
                        for($i=$firstYear;$i<=$lastYear;$i++) { echo '<option value=' .$i.'>'.$i.'
                            </option>';
                            }

                            @endphp

                            @endisset

                </select>

            </div>

        </div>


        <div class="col-lg-6">
            <div class="form-group">
                <label> Address 1 <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" name="address_1"
                    value="{!! !empty($item_details) ? CommonCustomHelper::filter_string($item_details->address_1) : '' !!}">
            </div>
        </div>


        <div class="col-lg-6">
            <div class="form-group">
                <label> Address 2 </label>
                <input type="text" class="form-control" name="address_2"
                    value="{!! !empty($item_details) ? CommonCustomHelper::filter_string($item_details->address_2) : '' !!}">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label> Address 3 </label>
                <input type="text" class="form-control" name="address_3"
                    value="{!! !empty($item_details) ? CommonCustomHelper::filter_string($item_details->address_3) : '' !!}">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label> Town / City <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" name="town"
                    value="{!! !empty($item_details) ? CommonCustomHelper::filter_string($item_details->town) : '' !!}">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label> County </label>
                <input type="text" class="form-control" name="county"
                    value="{!! !empty($item_details) ? CommonCustomHelper::filter_string($item_details->county) : '' !!}">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label> Postcode <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" name="postcode"
                    value="{!! !empty($item_details) ? CommonCustomHelper::filter_string($item_details->postcode) : '' !!}">
            </div>
        </div>




        <div class="col-lg-6">
            <div class="form-group">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email_address" name="email_address"
                    value="{!! !empty($item_details) ? CommonCustomHelper::filter_string($item_details->email_address) : '' !!}">
            </div>
        </div>

 
        <div class="col-lg-6">
            <div class="form-group">
                <label> Status </label>
                <select class="form-control" id="new_status" name="status">
                    @if(isset($item_details))

                    <option value="Y" {{ ( $item_details->status == 'Y') ? 'selected' : '' }}>
                        Active </option>
                    <option value="N" {{ ( $item_details->status == 'N') ? 'selected' : '' }}>
                        InActive </option>
                    @endisset

                    @if(!isset($item_details))
                    <option value="Y"> Active </option>
                    <option value="N"> InActive </option>
                    @endisset

                </select>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group mb-0">
                <div>

                    <input type="hidden" id="item_id" name="item_id"
                        value="{!! !empty($item_details) ? $item_details->id : '' !!}" readonly="readonly" />

                        <input type="hidden" id="pharmacy_id" name="pharmacy_id"
                        value="{{ session()->get('pharmacy_id') }}" readonly="readonly" />

                    <button type="button" class="btn btn-primary waves-effect waves-light mr-1" id="mc_add_patient_frm_submit_btn">
                        Submit
                    </button>

                    <button type="button" class="btn btn-danger"
                        onClick="$('#add_patient_bootstrap_ajax_popup').modal('hide');">Close</button>


                </div>
            </div>
        </div>


    </div>
</form>

<script>
$(document).ready(function() {

    $("#mc_add_patient_frm_submit_btn").click(function(event) {

        /*var is_valid = validate_add_edit_staff_form('mc-add-patient-form');
        // alert(is_valid); return;
        if (is_valid == false) {
            return false;
        }*/

        event.preventDefault();

        var calendar_pharmacy_id = $('#calendar_pharmacy_id').val();

        if(calendar_pharmacy_id != undefined && calendar_pharmacy_id != ''){

            $('#pharmacy_id').val(calendar_pharmacy_id);

        } // if(calendar_pharmacy_id != undefined && calendar_pharmacy_id != '')

        var data = new FormData(document.getElementById("mc-add-patient-form"));

        // data.append('calendar_pharmacy_id', $('#calendar_pharmacy_id').val());

        $.ajax({

            type: "POST",
            url: "{{ route('add_new_patient_popup_process') }}",
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,

            beforeSend: function(result) {

                //$("#overlay").removeClass("hidden");

                $('#add_patient_crud_errors_div').addClass('d-none');
                $('#add_patient_crud_errors_ul').html('');

            },
            success: function(response) {

                
                if (response.status == 'success') {

                    $('#add_patient_crud_errors_div').addClass('d-none');
                    $('#add_patient_crud_errors_ul').html('');

                    mc_notify('success', response.message);

                    $("#add_patient_bootstrap_ajax_popup").modal('hide');

                    // console.log(response.data.id);
                    // alert(response.data.id);

                    // $('#booking_patient_id').val(response.data.id);
                    
                    // $('#search_patient').val('Haseeb');

                    // location.reload();

                }

                console.log(response.code);

                if (response.code == '390') {

                    $('#add_patient_crud_errors_div').removeClass('d-none');
                    
                    var email_val = $("#email").val();
                    
                    var email_message = "Email " + email_val +
                        " is already associated with an account. Please send an invite to person to add him in to the team " +
                        btn;
                    $('#add_patient_crud_errors_ul').append(email_message);

                } // if (response.code == '390')

            },
            error: function(xhr, status, error) {

                $('#add_patient_crud_errors_div').removeClass('d-none');

                $.each(xhr.responseJSON.errors, function(key, item) {

                    var new_html = '<li> ' + item + ' </li>';
                    $('#add_patient_crud_errors_ul').append(new_html);

                });

            }

        }); // $.ajax

    });

});

function getSelected(e) {
    var item_id = e.value;

    $.ajax({

        type: "GET",
        url: "/staff/responsibilities/" + item_id,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'item_d': item_id
        },

        beforeSend: function(result) {
            //$("#overlay").removeClass("hidden");
        },
        success: function(response) {

            if (response.status == 'success') {
                $('#responsibility_id').empty();
                //  mc_notify('success', response.message);
                // $("#add_patient_bootstrap_ajax_popup").modal('hide');
                // location.reload();
                var data = response.data;
                $("#responsibility_id").append('<option value="">None</option>');
                for (var i = 0; i < data.length; i++) {

                    $("#responsibility_id").append('<option value=' + data[i].id + '> ' + data[i].name +
                        '</option>');

                }

            }

            console.log(response);
        },
        error: function(xhr, status, error) {

            $.each(xhr.responseJSON.errors, function(key, item) {
                mc_notify('danger', item);
            });
        }

    }); // $.ajax

}

</script>