<form method="POST" id="add-edit-faq-form">

  @csrf()

    @if(!empty($room_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($room_details->hash_id) ? $room_details->hash_id : '' }}" />

    <div class="row">

        <div class="col-md-12">
          <div class="form-group">
             <label class="form-label">Floor<span class="text-red">*</span></label>
             <select class="form-control" name="floor_id" id="floor_id">
                @foreach($floors as $floor)
                   <option value="{{$floor->id}}" @if(!empty($room_details->floor_id) && $room_details->floor_id == $floor->id) selected="true" @endif>{{$floor->title}}</option>
                @endforeach()
             </select>
          </div>
        </div>


    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Name<span class="text-red">*</span></label>
                <input type="text" class="form-control" id="room_name" name="room_name" value="{{ !empty($room_details->room_name) ? $room_details->room_name : '' }}" required />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Capacity<span class="text-red">*</span></label>
                <input type="number" class="form-control" id="capacity" name="capacity" value="{{ !empty($room_details->capacity) ? $room_details->capacity : '' }}" required />
            </div>
        </div>
    </div>
  </div>

  <hr />
 <div class="row">
    <div class="col-md-3 offset-9">
      <button class="btn btn-indigo" type="button" id="add-edit-faq-btn">Submit</button>
      <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
    </div>
  </div>
</form>

<script type="text/javascript">

    $(document).ready(function(){

        // Save
        $('#add-edit-faq-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'rooms/'+hash_id : 'rooms' ;

            var request_data = new FormData(document.getElementById("add-edit-faq-form"));

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
                    $("#add-edit-faq-btn").attr("disabled", true);
                    $('#add-edit-faq-btn').html('Loading..');
                    // $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {
                    $("#add-edit-faq-btn").attr("disabled", false);
                    $('#add-edit-faq-btn').html('Submit');
                    // $("#loading").css("display","none");

                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);

                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-faq-btn").attr("disabled", false);
                    $('#add-edit-faq-btn').html('Submit');
                    // console.log( xhr.responseJSON.error_msg );
                    mcShowErrorsPost(xhr, status, error);
                }

                // success

            }); // $.ajax

        }); // click => #add-edit-banner-btn

        $('#question').summernote({
              height: 100,
        });
        $('#answer').summernote({
            height: 100,
        });

    }); // .ready

</script>
