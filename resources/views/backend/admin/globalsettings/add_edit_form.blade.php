<form method="POST" id="add-edit-global-settings-form">

    @csrf()

    @if(!empty($global_settings_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($global_settings_details->hash_id) ? $global_settings_details->hash_id : '' }}" />

    @if(!empty($global_settings_details))
         <input type="hidden" class="form-control" id="title" name="setting_key_old" value="{{ $global_settings_details->setting_key}}">
    @endif()

    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Title <span class="text-red">*</span></label>
                <input type="text" class="form-control" id="title" name="setting_title" value="{{ !empty($global_settings_details) ? $global_settings_details->setting_title : '' }}" required>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Key <span class="text-red">*</span></label>
                <input type="text"  value="{{ !empty($global_settings_details) ? $global_settings_details->setting_key : '' }}" class="form-control" id="title" name="setting_key" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">value <span class="text-red">*</span></label>
                <input type="text" class="form-control" id="title" value="{{ !empty($global_settings_details) ? $global_settings_details->setting_value : '' }}" name="setting_value" required>
            </div>
        </div>
    </div>
    <hr />
    <div class="row">
       <div class="col-md-3 offset-9">
         <button class="btn btn-indigo" type="button" id="add-edit-global-settings-btn">Submit</button>
         <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
      </div>
    </div>

</form>

<script type="text/javascript">

    $(document).ready(function(){

        // Save
        $('#add-edit-global-settings-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'global-settings/'+hash_id : 'global-settings' ;

            var request_data = new FormData(document.getElementById("add-edit-global-settings-form"));

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
                    $("#add-edit-global-settings-btn").attr("disabled", true);
                    $('#add-edit-global-settings-btn').html('Loading..');
                    $("#loading").css("display","block");
                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {
                    $("#add-edit-global-settings-btn").attr("disabled", false);
                    $('#add-edit-global-settings-btn').html('Submit');
                    $("#loading").css("display","none");
                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);

                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-global-settings-btn").attr("disabled", false);
                    $('#add-edit-global-settings-btn').html('Submit');
                    mcShowErrorsPost(xhr, status, error);
                }
                // success
            }); // $.ajax
        }); // click => #add-edit-banner-btn

        $('#description').summernote({
              height: 100,
        });

    }); // .ready

</script>
