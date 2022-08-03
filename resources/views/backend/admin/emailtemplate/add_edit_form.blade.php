<form method="POST" id="add-edit-email-template-form">
    @csrf()
    @if(!empty($email_template_details))
        <input type="hidden" name="_method" value="PUT">
    @endif
    <input type="hidden" id="hash_id" value="{{ !empty($email_template_details->hash_id) ? $email_template_details->hash_id : '' }}" />
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Email Title<span class="text-red">*</span></label>
                <input type="text" class="form-control" id="title" name="email_title" value="{{ !empty($email_template_details->email_title) ? $email_template_details->email_title : '' }}" required />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Email Subject
                <input type="text" class="form-control" id="email_subject" name="email_subject" value="{{ !empty($email_template_details->email_subject) ? $email_template_details->email_subject : '' }}" required />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Description</label>
                @include('backend.admin.components.editor', ['item_details' => !empty($email_template_details->email_body) ? $email_template_details->email_body : '','resource' => 'email_body'])
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Status<span class="text-red">*</span></label>
                <select class="form-control" name="status" id="status">
                    <option {{ empty($email_template_details) || (!empty($email_template_details) && $email_template_details->status == '1') ? 'selected="selected"' : '' }} value="1" >Active</option>
                    <option {{ !empty($email_template_details) && $email_template_details->status == '0' ? 'selected="selected"' : '' }} value="0" >Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
       <div class="col-md-3 offset-9">
            <button class="btn btn-indigo" type="button" id="add-edit-email-template-btn">Submit</button>
            <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
        </div>
    </div>

</form>

<script type="text/javascript">

    $(document).ready(function(){

      // Save
        $('#add-edit-email-template-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'email-templates/'+hash_id : 'email-templates' ;

            var request_data = new FormData(document.getElementById("add-edit-email-template-form"));

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
                    $("#add-edit-email-template-btn").attr("disabled", true);
                    $('#add-edit-email-template-btn').html('Loading..');
                    // $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {
                    $("#add-edit-email-template-btn").attr("disabled", false);
                    $('#add-edit-email-template-btn').html('Submit');
                    $("#loading").css("display","none");

                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);

                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-email-template-btn").attr("disabled", false);
                    $('#add-edit-email-template-btn').html('Submit');
                    // console.log( xhr.responseJSON.error_msg );

                    mcShowErrorsPost(xhr, status, error)
                }

                // success

            }); // $.ajax

        }); // click => #add-edit-banner-btn

        $('#email_body').summernote({
            height: 100,
        });

    }); // .ready

</script>
