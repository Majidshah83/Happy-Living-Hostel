<form method="POST" id="add-edit-delivery-method-form">

    @csrf()

    @if(!empty($delivery_method_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($delivery_method_details->hash_id) ? $delivery_method_details->hash_id : '' }}" />

    <div class="row">

           <div class="col-md-12">
              <div class="form-group">
                  <label class="form-label">Delivery Method Name <span class="text-red">*</span></label>
                  <input type="text" class="form-control" value="{{ !empty($delivery_method_details->title) ? $delivery_method_details->title : '' }}" name="title" id="title">
              </div>
          </div>
          <div class="col-md-12">
              <div class="form-group">
                  <label class="form-label">Delivery Price (£) <span class="text-red">*</span></label>
                  <input type="text" class="form-control" value="{{ !empty($delivery_method_details->price) ? $delivery_method_details->price : '' }}" name="price" id="price">
              </div>
          </div>

          <div class="col-md-12">
              <div class="form-group">
                  <label class="form-label">Short Descriptions </label>
                  <textarea class="form-control" name="description" id="description">{{ !empty($delivery_method_details->description) ? $delivery_method_details->description : '' }}</textarea>
              </div>
          </div>

          <div class="col-md-12">
              <div class="form-group">
                  <label class="form-label">Long Descriptions </label>
                    @include('backend.admin.components.editor', ['item_details' => !empty($delivery_method_details->long_description) ? $delivery_method_details->long_description : '','resource' => 'long_description'])
              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  <label class="form-label">Select Country</label>
                  <select class="form-control custom-select select2" name="country" id="country">
                      <option value="">Country</option>}
                      @foreach($countries as $country)
                        <option @if(!empty($delivery_method_details) && $delivery_method_details->country == $country->title) selected="true" @endif  value="{{$country->title}}">{{$country->title}}</option>
                      @endforeach()
                  </select>
              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  <label class="form-label">Location</label>
                  <select class="form-control custom-select select2" name="location" id="location">
                      <option {{ (!empty($delivery_method_details) && $delivery_method_details->is_international_delivery == 'Local') ? 'selected="selected"' : '' }} value="Local">Local</option>
                      <option  {{ (!empty($delivery_method_details) && $delivery_method_details->is_international_delivery == 'International') ? 'selected="selected"' : '' }} value="International">International</option>
                  </select>
              </div>
          </div>

          <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Delivery Company Logo </label>
                    <input type="file" name="image" id="image" class="form-control" >
                    <div class="alert-message text-danger error-image"></div>
                </div>
          </div>

                 @php
                      if(!empty($delivery_method_details->image)){
                          $full_path = env('MEDIA_PATH_HTTP').'deliverymethods/'.$delivery_method_details->image;
                      } else {
                          $full_path = '';
                      } // if(!empty($banner_details->image))
                 @endphp

                 @if(!empty($full_path))
                   <div class="col-md-6">
                       <div class="imagepreview mt-3 mb-3" id="imagepreview">
                        @if(!empty($full_path))
                          <img src="{{ $full_path }}" class="img-fluid img-responsive" id="edit_file"/>
                        @endif
                        @if(!empty($delivery_method_details->image))

                            <div class="form-group">

                                <label>
                                    <input type="checkbox" id="remove_image" name="remove_image" value="1" />

                                    Check to remove this image

                                </label>

                            </div>
                        @endif
                  </div>
                </div>
              @endif
              <div class="col-md-6">
                <div class="form-group">
                   <label class="form-label">Display Order</label>
                   <select class="form-control custom-select select2" id="display_order" name="display_order">
                      @for ($i = 1; $i < 51; $i++)
                        <option {{ !empty($delivery_method_details) && $delivery_method_details->display_order == $i ? 'selected="selected"' : '' }} value="{{ $i }}">{{ $i }}</option>
                      @endfor
                   </select>
                </div>
             </div>

             <div class="col-md-6">
                <div class="form-group">
                   <label class="form-label">Status<span class="text-red">*</span></label>
                   <select class="form-control" name="status" id="status">
                      <option {{(!empty($delivery_method_details) && $delivery_method_details->status == '1') ? 'selected="selected"' : '' }} value="1" >Active</option>
                      <option {{ !empty($delivery_method_details) && $delivery_method_details->status == '0' ? 'selected="selected"' : '' }} value="0" >Inactive</option>
                   </select>
                </div>
             </div>

  </div>


  <hr />
  <div class="row">
       <div class="col-md-3 offset-9">
          <button class="btn btn-indigo" type="button" id="add-edit-delivery-method-btn">Submit</button>
          <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
      </div>
  </div>

</form>

<script type="text/javascript">

    $(document).ready(function(){

        $('#long_description').summernote({
           height: 100,
        });

        // Save
        $('#add-edit-delivery-method-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'delivery-methods/'+hash_id : 'delivery-methods' ;

            var request_data = new FormData(document.getElementById("add-edit-delivery-method-form"));

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
                    $("#add-edit-delivery-method-btn").attr("disabled", true);
                    $('#add-edit-delivery-method-btn').html('Loading..');
                    // $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },

                success: function(response) {
                    $("#add-edit-delivery-method-btn").attr("disabled", false);
                    $('#add-edit-delivery-method-btn').html('Submit');
                    $("#loading").css("display","none");

                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);

                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-delivery-method-btn").attr("disabled", false);
                    $('#add-edit-delivery-method-btn').html('Submit');
                    mcShowErrorsPost(xhr, status, error);

                }

                // success

            }); // $.ajax

        }); // click => #add-edit-banner-btn


    }); // .ready

</script>
