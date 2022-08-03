<form method="POST" id="add-edit-faq-category-form">
    @csrf()
    @if(!empty($floor_details))
        <input type="hidden" name="_method" value="PUT">
    @endif
    <input type="hidden" id="hash_id" value="{{ !empty($floor_details->hash_id) ? $floor_details->hash_id : '' }}" />
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Name<span class="text-red">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="{{ !empty($floor_details->title) ? $floor_details->title : '' }}" required />
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
       <div class="col-md-3 offset-9">
            <button class="btn btn-indigo" type="button" id="add-edit-faq-category-btn">Submit</button>
            <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
        </div>
    </div>

</form>

<script type="text/javascript">

    $(document).ready(function(){

      // Save
        $('#add-edit-faq-category-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'floors/'+hash_id : 'floors' ;

            var request_data = new FormData(document.getElementById("add-edit-faq-category-form"));

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
                    $("#add-edit-faq-category-btn").attr("disabled", true);
                    $('#add-edit-faq-category-btn').html('Loading..');
                    // $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {
                    $("#add-edit-faq-category-btn").attr("disabled", false);
                    $('#add-edit-faq-category-btn').html('Submit');
                    $("#loading").css("display","none");

                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);

                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-faq-category-btn").attr("disabled", false);
                    $('#add-edit-faq-category-btn').html('Submit');
                    // console.log( xhr.responseJSON.error_msg );
                    mcShowErrorsPost(xhr, status, error);
                }

                // success

            }); // $.ajax

        }); // click => #add-edit-banner-btn

        $('#email_body').summernote({
            height: 100,
        });

    }); // .ready

</script>
