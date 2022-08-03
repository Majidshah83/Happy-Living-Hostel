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
                <select id="role" name="role" class="form-control" required>
                    <option value="Admin" {{ empty($staff_details) || (!empty($staff_details) && $staff_details->role == 'Admin') ? 'selected="selected"' : '' }}>Admin</option>
                    <option value="Employee" {{ empty($staff_details) || (!empty($staff_details) && $staff_details->role == 'Employee') ? 'selected="selected"' : '' }}>Employee</option>
                </select>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Email <span class="text-red">*</span></label>
                <input type="email" class="form-control" name="email" id="email" required value="{{ !empty($staff_details->email) ? $staff_details->email : '' }}">
            </div>
        </div>

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

            var request_url = (hash_id != '') ? 'users/'+hash_id : 'users' ;

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
