<form method="POST" id="add-edit-business-form">

  @csrf()

    @if(!empty($business_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($business_details->hash_id) ? $business_details->hash_id : '' }}" />


   <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Business Type <span class="text-red">*</span></label></label>
                <select class="form-control" id="business_type_id" name="business_type_id">
                  @foreach($business_type as $business_types)
                   <option value="{{$business_types->id}}" @if(!empty($business_details->business_type_id) && $business_details->business_type_id == $business_types->id) selected @endif> {{$business_types->title}}</option>
                  @endforeach()
                </select>
                <div class="alert-message text-danger error-category" ></div>
            </div>
        </div>
    </div>
    <div class="row">

         <div class="col-md-12">
            <div class="form-group">
               <label class="form-label">Business Name<span class="text-red">*</span></label>
               <input type="text" class="form-control" id="business_name" name="business_name" value="{{ !empty($business_details->business_name) ? $business_details->business_name : '' }}" required />
            </div>
         </div>

         <div class="col-md-12">
            <div class="form-group">
               <label class="form-label">Opening Hour </label>
               <textarea class="form-control" name="opening_hour">{{ !empty($business_details->opening_hour) ? $business_details->opening_hour : '' }}</textarea>
            </div>
         </div>

        <div class="col-md-12">
            <div class="form-group">
               <label class="form-label">Notification</label>
               <textarea class="form-control" name="notification">{{ !empty($business_details->notification) ? $business_details->notification : '' }}</textarea>
            </div>
         </div>

        <div class="col-md-12">
            <div class="form-group">
               <label class="form-label">Website Url<span class="text-red">*</span></label>
               <input type="text" class="form-control" id="website_url" name="website_url" value="{{ !empty($business_details->website_url) ? $business_details->website_url : '' }}" required />
            </div>
         </div>

    </div>

    <div class="row">


        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Address1 <span class="text-red">*</span></label>
                <input type="text" class="form-control" id="address_1" name="address_1" value="{{ !empty($business_details->address_1) ? $business_details->address_1 : '' }}">
            </div>
        </div>
       <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Address2 <span class="text-red">*</span></label>
                <input type="text" class="form-control" id="address_2" name="address_2" value="{{ !empty($business_details->address_2) ? $business_details->address_2 : '' }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Address3 <span class="text-red">*</span></label>
                <input type="text" class="form-control" id="address_3" name="address_3" value="{{ !empty($business_details->address_3) ? $business_details->address_3 : '' }}">
            </div>
        </div>
    
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Town/ City <span class="text-red">*</span></label>
                <input type="text" class="form-control" id="town_city" name="town_city" value="{{ !empty($business_details->town_city) ? $business_details->town_city : '' }}">
                <span class="text-danger error-text town_city_err"></span>
            </div>
        </div>

       <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">County
                <input type="text" class="form-control" id="county" name="county" value="{{ !empty($business_details->county) ? $business_details->county : '' }}">
                <span class="text-danger error-text town_city_err"></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Postcode <span class="text-red">*</span></label>
                <input type="text" class="form-control" name="postcode" id="postcode" value="{{ !empty($business_details->postcode) ? $business_details->postcode : '' }}">
                <span class="text-danger error-text postcode_err"></span>
            </div>
       </div>
       
      <div class="col-md-6">
        <div class="form-group">
           <label class="form-label">Display Order</label>
           <select class="form-control custom-select select2" id="display_order" name="display_order">

              @for ($i = 1; $i < 51; $i++)

                <option {{ !empty($business_details) && $business_details->display_order == $i ? 'selected="selected"' : '' }} value="{{ $i }}">{{ $i }}</option>

              @endfor
           </select>
        </div>
     </div>
     <div class="col-md-6">
        <div class="form-group">
           <label class="form-label">Status<span class="text-red">*</span></label>
           <select class="form-control" name="status" id="status">
              <option {{ empty($business_details) || (!empty($business_details) && $business_details->status == '1') ? 'selected="selected"' : '' }} value="1" >Active</option>
              <option {{ !empty($business_details) && $business_details->status == '0' ? 'selected="selected"' : '' }} value="0" >Inactive</option>
           </select>
        </div>
     </div>
  </div>

  <hr />

  <div class="row">
    <div class="col-md-3 offset-9">
      <button class="btn btn-indigo" type="button" id="add-edit-business-btn">Submit</button>
      <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
    </div>
  </div>

</form>

<script type="text/javascript">

    $(document).ready(function(){

        // Save
        $('#add-edit-business-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'business/'+hash_id : 'business' ;

            var request_data = new FormData(document.getElementById("add-edit-business-form"));

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
