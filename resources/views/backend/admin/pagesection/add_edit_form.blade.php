<form method="POST" id="add-edit-page-section-form">

  @csrf()

    @if(!empty($page_section_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($page_section_details->hash_id) ? $page_section_details->hash_id : '' }}" />

    <div class="row">

         <div class="col-md-12">
            <div class="form-group">

               <label class="form-label">Title <span class="text-red">*</span></label>
               <input type="text" class="form-control" id="title" name="title" value="{{ !empty($page_section_details->title) ? $page_section_details->title : '' }}" required />

            </div>
         </div>

        @if(!empty($page_section_details))
          <div class="col-md-12">
              <div class="form-group">
                  <label class="form-label">Section ID (unique ID to call section on website)<span class="text-red">*</span></label>
                  <input type="text" class="form-control" id="url_slug" name="url_slug" value="{{ !empty($page_section_details->url_slug) ? $page_section_details->url_slug : '' }}">
              </div>
          </div>
        @endif()

        <div class="col-md-12">
            <div class="form-group">
               <label class="form-label">Text<span class="text-red">*</span></label></label>
               @include('backend.admin.components.editor', ['item_details' => !empty($page_section_details->description) ? $page_section_details->description : '','resource' => 'description'])
            </div>
        </div>

    </div>

    <div class="col-md-6">
        <div class="form-group">

           <label class="form-label">Status<span class="text-red">*</span></label>
           <select class="form-control" name="status" id="status">

              <option {{ empty($page_section_details) || (!empty($page_section_details) && $page_section_details->status == '1') ? 'selected="selected"' : '' }} value="1" >Active</option>

              <option {{ !empty($page_section_details) && $page_section_details->status == '0' ? 'selected="selected"' : '' }} value="0" >Inactive</option>

           </select>

        </div>
     </div>
  </div>

  <hr />
 <div class="row">
      <div class="col-md-3 offset-9">
      <button class="btn btn-indigo text-left" type="button" id="add-edit-page-section-btn">Submit</button>
      <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
    </div>
  </div>

</form>

<script type="text/javascript">

    $(document).ready(function(){

        // Save
        $('#add-edit-page-section-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'page-sections/'+hash_id : 'page-sections' ;

            var request_data = new FormData(document.getElementById("add-edit-page-section-form"));

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
                    $("#add-edit-page-section-btn").attr("disabled", true);
                    $('#add-edit-page-section-btn').html('Loading..');
                    $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {
                    $("#add-edit-page-section-btn").attr("disabled", false);
                    $('#add-edit-page-section-btn').html('Submit');

                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);

                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-page-section-btn").attr("disabled", false);
                    $('#add-edit-page-section-btn').html('Submit');

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
