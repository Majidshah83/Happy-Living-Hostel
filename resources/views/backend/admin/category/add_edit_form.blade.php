<form method="POST" id="add-edit-category-form">

  @csrf()

    @if(!empty($category_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($category_details->hash_id) ? $category_details->hash_id : '' }}" />

    <div class="row">

         <div class="col-md-12">
            <div class="form-group">
               <label class="form-label">Title <span class="text-red">*</span></label>
               <input type="text" class="form-control" id="title" name="title" value="{{ !empty($category_details->title) ? $category_details->title : '' }}" required />
            </div>
         </div>

         <div class="col-md-12">
            <div class="form-group">Description</label>
               @include('backend.admin.components.editor', ['item_details' => !empty($category_details->description) ? $category_details->description : '','resource' => 'description' ])
            </div>
         </div>

    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="form-group">

               <label class="form-label">Upload Category Image</label>
               <input type="file" name="image" id="image"  />

            </div>
         </div>

         <div class="col-md-6">
               <div class="imagepreview mt-3 mb-3" id="imagepreview">

                    @php

                    if(!empty($category_details->image)){

                        $full_path = env('MEDIA_PATH_HTTP').'category/'.$category_details->image;

                    } else {

                        $full_path = '';

                    } // if(!empty($banner_details->image))

                    @endphp

                    @if(!empty($full_path))
                      <img src="{{ $full_path }}" class="img-fluid img-responsive" id="edit_file"/>
                    @endif

                    @if(!empty($category_details->image))

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

                <option {{ !empty($category_details) && $category_details->display_order == $i ? 'selected="selected"' : '' }} value="{{ $i }}">{{ $i }}</option>

              @endfor

           </select>

        </div>
     </div>
     <div class="col-md-6">
        <div class="form-group">

           <label class="form-label">Status<span class="text-red">*</span></label>
           <select class="form-control" name="status" id="status">

              <option {{ empty($category_details) || (!empty($category_details) && $category_details->status == '1') ? 'selected="selected"' : '' }} value="1" >Active</option>

              <option {{ !empty($category_details) && $category_details->status == '0' ? 'selected="selected"' : '' }} value="0" >Inactive</option>

           </select>

        </div>
     </div>

  </div>

    <div class="row">
        <div class="col-md-12">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="advanced_settings" id="advanced_settings"> <span class="custom-control-label">Advanced Settings</span> </label>
            <div class="alert-message text-danger error-advanced_settings" ></div>
        </div>

         @if(!empty($category_details->slug))

            <div class="col-md-12 ad_settings">
                <div class="form-group">
                    <label class="form-label">Service Slug<span class="text-red">*</span></label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ !empty($category_details->slug) ? $category_details->slug : '' }}" required />
                </div>
            </div>

        @endif

        <div class="col-md-12 ad_settings">
            <div class="form-group">
                <label class="form-label">Meta Title</label>
                <input type="text" class="form-control"  id="meta_title" name="meta_title" value="{{ !empty($category_details->meta_title) ? $category_details->meta_title : '' }}">
                <div class="alert-message text-danger error-meta_title" ></div>
            </div>
        </div>

        <div class="col-md-12 ad_settings">
            <div class="form-group">
                <label class="form-label">Meta Keywords (<small>Comma seperated keywords</small>)</label>
                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ !empty($category_details->meta_keywords) ? $category_details->meta_keywords : '' }}">
                <div class="alert-message text-danger error-meta_keywords" ></div>
            </div>
        </div>
        <div class="col-md-12 ad_settings">
            <div class="form-group">
                <label class="form-label">Meta Description</label>
                <textarea class="form-control" cols="8" id="meta_description" name="meta_description">{{ !empty($category_details->meta_description) ? $category_details->meta_description : '' }}</textarea>
                <div class="alert-message text-danger error-meta_description" ></div>
            </div>
        </div>
    </div>

  <hr />

  <div class="row">
    <div class="col-md-3 offset-9">
      <button class="btn btn-indigo" type="button" id="add-edit-category-btn">Submit</button>
      <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
    </div>
  </div>

</form>

<script type="text/javascript">

    $(document).ready(function(){


        var meta_title_val = $('#meta_title').val();

        if (meta_title_val.length > 0){
            $("#advanced_settings").click();
            console.log(meta_title_val)
            $(".ad_settings").show();
        } else {
            $(".ad_settings").hide();
        }

        // $(".advanced_settings").show();
        $('#advanced_settings').click(function(){
            if($(this).is(':checked')){
                $(".ad_settings").show();
            }else{
                $(".ad_settings").hide();
            }
        });
        $('#bookable').click(function(){
            if($(this).is(':checked')){
                $("#bookable").val(1);
            }else{
                $("#bookable").val(0);
            }
        });
        // Save
        $('#add-edit-category-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'blog-category/'+hash_id : 'blog-category' ;

            var request_data = new FormData(document.getElementById("add-edit-category-form"));

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
