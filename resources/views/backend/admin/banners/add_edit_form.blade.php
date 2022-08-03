<form method="POST" id="add-edit-banner-form">

  @csrf()

    @if(!empty($banner_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($banner_details->hash_id) ? $banner_details->hash_id : '' }}" />

    <div class="row">

      

         <div class="col-md-12">
            <div class="form-group">
               <label class="form-label">Banner Title <span class="text-red">*</span></label>
               <input type="text" class="form-control" id="title" name="title" value="{{ !empty($banner_details->title) ? $banner_details->title : '' }}" required />
            </div>
         </div>

         <div class="col-md-12">
            <div class="form-group">
               <label class="form-label">Banner Text</label>
               @include('backend.admin.components.editor', ['item_details' => !empty($banner_details->description) ? $banner_details->description : '','resource' => 'description' ])
            </div>
         </div>

    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="form-group">

               <label class="form-label">Upload Banner Image</label>
               <input type="file" name="image" id="image"  />

            </div>
         </div>

         <div class="col-md-6">
               <div class="imagepreview mt-3 mb-3" id="imagepreview">

                    @php

                    if(!empty($banner_details->image)){

                        $full_path = env('MEDIA_PATH_HTTP').'banner/'.$banner_details->image;

                    } else {

                        $full_path = '';

                    } // if(!empty($banner_details->image))

                    @endphp

                    @if(!empty($full_path))
                      <img src="{{ $full_path }}" class="img-fluid img-responsive" id="edit_file"/>
                    @endif

                    @if(!empty($banner_details->image))

                        <div class="form-group">
                            <label>
                                <input type="checkbox" id="remove_image" name="remove_image" value="1" />
                                Check to remove this image
                            </label>
                        </div>

                    @endif

              </div>
        </div>

    </div>

    <div class="row">

     <div class="col-md-6">
        <div class="form-group">

           <label class="form-label">Display Order</label>
           <select class="form-control custom-select select2" id="display_order" name="display_order">

              @for ($i = 1; $i < 51; $i++)

                <option {{ !empty($banner_details) && $banner_details->display_order == $i ? 'selected="selected"' : '' }} value="{{ $i }}">{{ $i }}</option>

              @endfor

           </select>

        </div>
     </div>
     <div class="col-md-6">
        <div class="form-group">

           <label class="form-label">Status<span class="text-red">*</span></label>
           <select class="form-control" name="status" id="status">

              <option {{ empty($banner_details) || (!empty($banner_details) && $banner_details->status == '1') ? 'selected="selected"' : '' }} value="1" >Active</option>

              <option {{ !empty($banner_details) && $banner_details->status == '0' ? 'selected="selected"' : '' }} value="0" >Inactive</option>

           </select>

        </div>
     </div>
  </div>

  <hr />

  <div class="row">
    <div class="col-md-3 offset-9">
      <button class="btn btn-indigo" type="button" id="add-edit-banner-btn">Submit</button>
      <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
    </div>
  </div>

</form>

<script type="text/javascript">

    $(document).ready(function(){

        // Save
        $('#add-edit-banner-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'banner/'+hash_id : 'banner' ;

            var request_data = new FormData(document.getElementById("add-edit-banner-form"));

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
                    $("#add-edit-banner-btn").attr("disabled", true);
                    $('#add-edit-banner-btn').html('Loading..');

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {

                    $("#add-edit-banner-btn").attr("disabled", false);
                    $('#add-edit-banner-btn').html('Submit');
                    $("#loading").css("display","none");
                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);


                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-banner-btn").attr("disabled", false);
                    $('#add-edit-banner-btn').html('Submit');
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
