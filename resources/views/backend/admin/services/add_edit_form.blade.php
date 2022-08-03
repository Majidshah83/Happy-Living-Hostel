<form method="POST" id="add-edit-service-form">

    @csrf()

    @if(!empty($service_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($service_details->hash_id) ? $service_details->hash_id : '' }}" />

    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Title<span class="text-red">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="{{ !empty($service_details->title) ? $service_details->title : '' }}" required />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Short Description </label>
                
                <!--
                < textarea class="form-control" cols="8" name="short_description" id="short_description" >{{ !empty($service_details->short_description) ? $service_details->short_description : '' }}< / textarea>
                -->
                
                @include('backend.admin.components.editor', ['item_details' => !empty($service_details->short_description) ? $service_details->short_description : '','resource' => 'short_description'])
                
                <div class="alert-message text-danger error-short_description" ></div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Long Description</label>
                @include('backend.admin.components.editor', ['item_details' => !empty($service_details->long_description) ? $service_details->long_description : '','resource' => 'long_description'])
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Service url</label>
                <input type="text" class="form-control" name="service_url" id="service_url" value="{{ !empty($service_details->service_url) ? $service_details->service_url : '' }}">
                <div class="alert-message text-danger error-service_url" ></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Fa Icon</label>
                <input type="text" class="form-control" name="fa_icon" id="fa_icon" value="{{ !empty($service_details->fa_icon) ? $service_details->fa_icon : '' }}">
                <div class="alert-message text-danger error-fa_icon" ></div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="form-group">

                <label class="form-label">Service Page Image </label>
                <input type="file" name="image" id="image" accept="image/png, image/jpeg" />

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">

                <label class="form-label">Thumbnail Image </label>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/png, image/jpeg" />

            </div>
        </div>


    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="imagepreview mt-3 mb-3" id="imagepreview">

                @php

                    if(!empty($service_details->image)){

                        $full_path = env('MEDIA_PATH_HTTP').'services/'.$service_details->image;

                    } else {

                        $full_path = '';

                    } // if(!empty($banner_details->image))

                @endphp

                @if(!empty($full_path))
                    <img src="{{ $full_path }}" class="img-fluid img-responsive" id="edit_file"/>
                @endif

                @if(!empty($service_details->image))

                    <div class="form-group">

                        <label>

                            <input type="checkbox" id="remove_image" name="remove_image" value="1" />

                            Check to remove this image

                        </label>

                    </div>

                @endif

            </div>
        </div>

        <div class="col-md-6">
            <div class="imagepreview mt-3 mb-3" id="imagepreview">

                @php

                    if(!empty($service_details->thumbnail)){

                        $full_path = env('MEDIA_PATH_HTTP').'services/thumbnail/'.$service_details->thumbnail;

                    } else {

                        $full_path = '';

                    } // if(!empty($banner_details->image))

                @endphp

                @if(!empty($full_path))
                    <img src="{{ $full_path }}" class="img-fluid img-responsive" id="edit_file"/>
                @endif

                @if(!empty($service_details->thumbnail))

                    <div class="form-group">

                        <label>

                            <input type="checkbox" id="remove_thumbnail" name="remove_thumbnail" value="1" />

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
                <label class="form-label">Select Category</label>
                <select class="form-control custom-select select2" id="category" name="category">
                    <option value="NHS Pharmacy Services" {{ empty($service_details) || (!empty($service_details) && $service_details->category == 'NHS Pharmacy Services') ? 'selected="selected"' : '' }}>NHS Pharmacy Services</option>
                    <option value="Private Pharmacy Services" {{ empty($service_details) || (!empty($service_details) && $service_details->category == 'Private Pharmacy Services') ? 'selected="selected"' : '' }}>Private Pharmacy Services</option>
                </select>
                <div class="alert-message text-danger error-category" ></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Select Position</label>
                <select class="form-control custom-select select2" id="position" name="position">
                    <option value="All" {{ empty($service_details) || (!empty($service_details) && $service_details->position == 'All') ? 'selected="selected"' : '' }} >All</option>
                    <option value="Under Banner Services" {{ empty($service_details) || (!empty($service_details) && $service_details->position == 'Under Banner Services') ? 'selected="selected"' : '' }}>Under Banner Services</option>
                    <option value="Page Services" {{ empty($service_details) || (!empty($service_details) && $service_details->position == 'Page Services') ? 'selected="selected"' : '' }}>Page Services</option>
                </select>
                <div class="alert-message text-danger error-postion" ></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="bookable" id="bookable" value="{{ !empty($service_details->bookable) ? $service_details->bookable : 0 }}" {{ !empty($service_details->bookable) ? 'checked' : ''}}><span class="custom-control-label">Can patient book this service ?</span> </label>
            <div class="alert-message text-danger error-book" ></div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Price (£)</label>
                <input type="text" class="form-control" id="price" name="price" value="{{ !empty($service_details->price) ? $service_details->price : 0 }}">
                <div class="alert-message text-danger error-price"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">

                <label class="form-label">Display Order</label>
                <select class="form-control custom-select select2" id="display_order" name="display_order">

                    @for ($i = 1; $i < 51; $i++)

                        <option {{ !empty($service_details) && $service_details->display_order == $i ? 'selected="selected"' : '' }} value="{{ $i }}">{{ $i }}</option>

                    @endfor

                </select>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">

                <label class="form-label">Status<span class="text-red">*</span></label>
                <select class="form-control" name="status" id="status">

                    <option {{ empty($service_details) || (!empty($service_details) && $service_details->status == '1') ? 'selected="selected"' : '' }} value="1" >Active</option>

                    <option {{ !empty($service_details) && $service_details->status == '0' ? 'selected="selected"' : '' }} value="0" >Inactive</option>

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

         @if(!empty($service_details->slug))

            <div class="col-md-12 ad_settings">
                <div class="form-group">
                    <label class="form-label">Service Slug<span class="text-red">*</span></label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ !empty($service_details->slug) ? $service_details->slug : '' }}" required />
                </div>
            </div>

        @endif

        <div class="col-md-12 ad_settings">
            <div class="form-group">
                <label class="form-label">Meta Title</label>
                <input type="text" class="form-control"  id="meta_title" name="meta_title" value="{{ !empty($service_details->meta_title) ? $service_details->meta_title : '' }}">
                <div class="alert-message text-danger error-meta_title" ></div>
            </div>
        </div>

        <div class="col-md-12 ad_settings">
            <div class="form-group">
                <label class="form-label">Meta Keywords (<small>Comma seperated keywords</small>)</label>
                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ !empty($service_details->meta_keywords) ? $service_details->meta_keywords : '' }}">
                <div class="alert-message text-danger error-meta_keywords" ></div>
            </div>
        </div>
        <div class="col-md-12 ad_settings">
            <div class="form-group">
                <label class="form-label">Meta Description</label>
                <textarea class="form-control" cols="8" id="meta_description" name="meta_description">{{ !empty($service_details->meta_description) ? $service_details->meta_description : '' }}</textarea>
                <div class="alert-message text-danger error-meta_description" ></div>
            </div>
        </div>
    </div>
    <hr />
    <div class="row">
       <div class="col-md-3 offset-9">
            <button class="btn btn-indigo" type="button" id="add-edit-service-btn">Submit</button>

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
        $('#add-edit-service-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'services/'+hash_id : 'services' ;

            var request_data = new FormData(document.getElementById("add-edit-service-form"));

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
                    $("#add-edit-service-btn").attr("disabled", true);
                    $('#add-edit-service-btn').html('Loading..');

                    // $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {
                    $("#add-edit-service-btn").attr("disabled", false);
                    $('#add-edit-service-btn').html('Submit');
                    // $("#loading").css("display","none");

                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);

                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-service-btn").attr("disabled", false);
                    $('#add-edit-service-btn').html('Submit');
                    mcShowErrorsPost(xhr, status, error);

                }

                // success

            }); // $.ajax

        }); // click => #add-edit-banner-btn

        $('#long_description').summernote({
            height: 100,
        });
        
        $('#short_description').summernote({
            height: 100,
        });

    }); // .ready

</script>
