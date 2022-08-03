<form method="POST" id="add-edit-staff-form">

    @csrf()

    @if(!empty($staff_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($staff_details->hash_id) ? $staff_details->hash_id : '' }}" />

    <div class="row">

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">First Name <span class="text-red">*</span></label>
                <input type="text" id="first_name" class="form-control" name="first_name" value="{{ !empty($staff_details->first_name) ? $staff_details->first_name : '' }}" required>
                <span class="text-danger error-text first_name_err"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Last Name <span class="text-red">*</span></label>
                <input type="text" id="last_name" class="form-control" name="last_name" value="{{ !empty($staff_details->last_name) ? $staff_details->last_name : '' }}" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">User Type <span class="text-red">*</span></label>
                <select id="user_type_id" name="user_type_id" class="form-control" required>
                    <option value="">--Select User Type--</option>
                    @foreach($user_types as $key=>$type)
                        <option {{ !empty($staff_details) && $staff_details->user_type_id == $type->id ? 'selected="selected"' : '' }} value="{{$type->id}}">{{$type->title}}</option>
                    @endforeach()
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Role <span class="text-red">*</span></label>
                <select class="form-control" name="role" id="role">
                    <option value="">--Select User Role--</option>
                    <option value="Admin" {{ empty($staff_details) || (!empty($staff_details) && $staff_details->role == 'Admin') ? 'selected="selected"' : '' }}>Admin</option>
                    <option value="Manager" {{ empty($staff_details) || (!empty($staff_details) && $staff_details->role == 'Manager') ? 'selected="selected"' : '' }}>Manager</option>
                 {{--    <option value="Prescriber" {{ empty($staff_details) || (!empty($staff_details) && $staff_details->role == 'Prescriber') ? 'selected="selected"' : '' }}>Prescriber</option>
                    <option value="Dispenser" {{ empty($staff_details) || (!empty($staff_details) && $staff_details->role == 'Dispenser') ? 'selected="selected"' : '' }}>Dispenser</option> --}}
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Reg No </label>
                <input type="text" class="form-control" name="reg_no" id="reg_no" value="{{ !empty($staff_details->reg_no) ? $staff_details->reg_no : '' }}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Professional Title (MBChB MRCGP DCH DRCOG) </label>
                <input type="text" class="form-control" name="professional_title" id="professional_title" value="{{ !empty($staff_details->professional_title) ? $staff_details->professional_title : '' }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Phone Number </label>
                <input type="text" class="form-control" name="phone_no" id="phone_no" value="{{ !empty($staff_details->phone_no) ? $staff_details->phone_no : '' }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Fax Number </label>
                <input type="text" class="form-control" name="fax_no" id="fax_no" value="{{ !empty($staff_details->fax_no) ? $staff_details->fax_no : '' }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Address 1 <span class="text-red">*</span></label>
                <input type="text" class="form-control" name="address_1" id="address_1" value="{{ !empty($staff_details->address_1) ? $staff_details->address_1 : '' }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Address 2 </label>
                <input type="text" class="form-control" name="address_2" id="address_2" value="{{ !empty($staff_details->address_2) ? $staff_details->address_2 : '' }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Address 3 </label>
                <input type="text" class="form-control" name="address_3" id="address_3" value="{{ !empty($staff_details->address_3) ? $staff_details->address_3 : '' }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">City/Town <span class="text-red">*</span></label>
                <input type="text" class="form-control" name="city" id="city" required value="{{ !empty($staff_details->city) ? $staff_details->city : '' }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">County </label>
                <input type="text" class="form-control" name="county" id="county" value="{{ !empty($staff_details->county) ? $staff_details->county : '' }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Postcode <span class="text-red">*</span></label>
                <input type="text" class="form-control" name="postcode" id="postcode" required value="{{ !empty($staff_details->postcode) ? $staff_details->postcode : '' }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Upload Signature </label>
                <input type="file" class="form-control" name="signature" accept="image/png, image/jpeg" id="signature">
            </div>
            <div class="imagepreview mt-3 mb-3" id="imagepreview_sig">
                @php

                    if(!empty($staff_details->signature)){

                        $full_path = env('MEDIA_PATH_HTTP').'signature/'.$staff_details->signature;

                    } else {

                        $full_path = '';

                    }

                @endphp
                @if(!empty($full_path))
                    <img src="{{ $full_path }}" class="img-fluid img-responsive" id="edit_file" width="190px"/>
                @endif
                @if(!empty($staff_details->signature))

                    <div class="form-group">

                        <label>

                            <input type="checkbox" id="remove_image" name="remove_signature_image" value="1" />

                            Check to remove this image

                        </label>

                    </div>

                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Upload Profile Image </label>
                <input type="file" class="form-control" name="profile_image" accept="image/png, image/jpeg" id="profile_image">
            </div>
            <div class="imagepreview mt-3 mb-3" id="imagepreview_profile">
                @php

                    if(!empty($staff_details->profile_image)){

                        $full_path = env('MEDIA_PATH_HTTP').'profile/'.$staff_details->profile_image;

                    } else {

                        $full_path = '';

                    }

                @endphp
                @if(!empty($full_path))
                    <img src="{{ $full_path }}" class="img-fluid img-responsive" width="190px"/>
                @endif
                @if(!empty($staff_details->profile_image))

                    <div class="form-group">

                        <label>

                            <input type="checkbox" id="remove_image" name="remove_profile_image" value="1" />

                            Check to remove this image

                        </label>

                    </div>

                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Email <span class="text-red">*</span></label>
                <input type="email" class="form-control" name="email" id="email" required value="{{ !empty($staff_details->email) ? $staff_details->email : '' }}">
                <span class="text-danger error-text email_err"></span>
            </div>
        </div>
        {{-- 
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Password <span class="text-red">*</span></label>
                <input type="password" class="form-control" name="password" id="password" required value="{{ !empty($staff_details->password) ? $staff_details->password : '' }}">
                <span class="text-danger error-text password_err"></span>
            </div>
        </div> --}}

    </div>


    <hr />
    <div class="row">
        <div class="col-md-3 offset-9">
            <button class="btn btn-indigo" type="button" id="add-edit-staff-btn">Submit</button>

            <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
        </div>
    </div>

</form>

<script type="text/javascript">

    $(document).ready(function(){

        // Save
        $('#add-edit-staff-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'staffs/'+hash_id : 'staffs' ;

            var request_data = new FormData(document.getElementById("add-edit-staff-form"));

            $.ajax({

                type: request_type,

                url: request_url,

                processData: false,

                contentType: false,

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: request_data,

                beforeSend: function(result) {
                    $("#loader").show();
                    $("#add-edit-staff-btn").attr("disabled", true);
                    $('#add-edit-staff-btn').html('Loading..');
                    // $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {

                    $("#add-edit-staff-btn").attr("disabled", false);
                    $('#add-edit-staff-btn').html('Submit');
                    // $("#loading").css("display","none");

                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);

                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-staff-btn").attr("disabled", false);
                    $('#add-edit-staff-btn').html('Submit');
                    // console.log( xhr.responseJSON.error_msg );
                    mcShowErrorsPost(xhr, status, error);
                }

                // success

            }); // $.ajax

        }); // click => #add-edit-banner-btn


    }); // .ready

</script>
