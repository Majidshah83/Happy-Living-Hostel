<div id="ajax-alert" class="alert" style="display:none"></div>
<form method="POST" id="update-password-form" action="javascript:;">

  @csrf()

    <input type="hidden" id="hash_id" name="hash_id" value="{{ !empty($row_detail->hash_id) ? $row_detail->hash_id : '' }}" />

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">New Password <span class="text-red">*</span></label>
                <input type="password" id="password" class="form-control" name="password">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Confirm New Password <span class="text-red">*</span></label>
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
            </div>
        </div>
    </div>

  <hr />
 <div class="row">
    <div class="col-md-12 text-right">
      <button class="btn btn-indigo" type="button" id="update-btn">Change</button>
      <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
    </div>
  </div>
</form>

<script type="text/javascript">

    $(document).ready(function(){

        // Save
        $('#update-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_data = new FormData(document.getElementById("update-password-form"));

            $.ajax({

                type: request_type,

                url: '{{url('/update-user-password')}}',

                processData: false,

                contentType: false,

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: request_data,

                beforeSend: function(result) {
                    $("#loader").show();
                    $("#update-btn").attr("disabled", true);
                    $('#update-btn').html('Loading..');
                    // $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');


                },
                success: function(response) {
                    $("#update-btn").attr("disabled", false);
                    $('#update-btn').html('Change');
                    // $("#loading").css("display","none");

                    // swal(response);
                    location.reload();
                    $('#ajax-alert').addClass('alert-success').show(function(){
                        $(this).html(response.message[0]);
                    });
                    $('#loader').delay(2000).hide(100);

                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#update-btn").attr("disabled", false);
                    $('#update-btn').html('Change');
                    // console.log( xhr.responseJSON.error_msg );
                    mcShowErrorsPost(xhr, status, error);
                }

                // success

            }); // $.ajax

        }); // click => #add-edit-banner-btn

    }); // .ready

</script>
