<form method="POST" id="add-edit-coupon-form">

  @csrf()

    @if(!empty($coupon_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($coupon_details->hash_id) ? $coupon_details->hash_id : '' }}" />

    <div class="row">

      <div class="col-md-12">
          <div class="form-group">
              <label class="form-label">Title <span class="text-red">*</span></label>
              <input type="text" id="title" name="title" class="form-control"  value="{{ !empty($coupon_details->title) ? $coupon_details->title : '' }}"  name="title" required>
          </div>
      </div>

      <div class="col-md-12">
          <div class="form-group">
              <label class="form-label">Description</label>
              @include('backend.admin.components.editor', ['item_details' => !empty($coupon_details->description) ? $coupon_details->description : '','resource' => 'description'])
          </div>
      </div>

      <div class="col-md-6">
          <div class="form-group">
              <label class="form-label">Coupon Code <span class="text-red">*</span></label>
              <input type="text" class="form-control"  value="{{ !empty($coupon_details->coupon_code) ? $coupon_details->coupon_code : '' }}" name="coupon_code" id="coupon_code">
          </div>
      </div>

      <div class="col-md-6">
          <div class="form-group">
              <label class="form-label">Coupon Type <span class="text-red">*</span></label>
              <select id="coupon_type" name="coupon_type" class="form-control custom-select select2" required>
                  <option value="FIXED_PRICE" @if(!empty($coupon_details) && $coupon_details->coupon_type == 'FIXED_PRICE') selected="true" @endif>Fixed Price</option>
                  <option value="PERCENTAGE" @if(!empty($coupon_details) && $coupon_details->coupon_type == 'PERCENTAGE') selected="true" @endif>Percentage</option>
              </select>
          </div>
      </div>

      <div class="col-md-12" >
          <div class="form-group" id="fixed">
              <label class="form-label">Discount Price (£)</label>
              <input type="text" class="form-control" value="{{ !empty($coupon_details->discount_price) ? $coupon_details->discount_price : '' }}" name="discount_price" id="discount_price">
          </div>
      </div>

      <div class="col-md-12" >
          <div class="form-group" id="percent">
              <label class="form-label">Discount Percentage</label>
              <input type="text" class="form-control" value="{{ !empty($coupon_details->discount_percentage) ? $coupon_details->discount_percentage : '' }}" name="discount_percentage" id="dis_percent">
          </div>
      </div>

      <div class="col-md-12">
          <div class="form-group">
              <label class="form-label">Usage Limit <span class="text-red">*</span></label>
              <input type="number" class="form-control" name="usage_limit" id="usage_limit"  value="{{ !empty($coupon_details->usage_limit) ? $coupon_details->usage_limit : 1 }}">
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-group">
              <div class="mt-5">
              <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" name="has_expiry_date" id="has_expiry_date" value="1"  @if(!empty($coupon_details) && $coupon_details->has_expiry_date == '1') checked @endif> <span class="custom-control-label">Has Expiry?</span> </label>
              </div>
          </div>
      </div>

      <div class="col-md-6" >
          <div class="form-group" id="ex_date">
              <label class="form-label">Expiry Date</label>
              <input type="date" class="form-control" name="expiry_date_time" id="expiry_date"  value="{{ !empty($coupon_details) ? $coupon_details->expiry_date_time : '' }}">
              <span class="text-danger error-text expiry_date_err"></span>
          </div>
      </div>

      <div class="col-md-6">
          <div class="form-group">
              <label class="form-label">Expired Status</label>
              <select id="expired_status" name="is_expired" class="form-control custom-select select2" required>
                  <option value="0" @if(!empty($coupon_details) && $coupon_details->is_expired == 0) selected @endif>Not Expired</option>
                  <option value="1" @if(!empty($coupon_details) && $coupon_details->is_expired == 1) selected @endif>Expired</option>
              </select>
          </div>
      </div>

      <div class="col-md-6">
          <div class="form-group">
              <label class="form-label">Active Status</label>
              <select id="active_status" name="status" class="form-control custom-select select2" required>
                  <option value="1"  @if(!empty($coupon_details) && $coupon_details->status == 1) selected @endif>Active</option>
                  <option value="0" @if(!empty($coupon_details) && $coupon_details->status == 0) selected @endif>InActive</option>
              </select>
          </div>
      </div>

    </div>

  <hr />
  <div class="row">
    <div class="col-md-3 offset-9">
      <button class="btn btn-indigo" type="button" id="add-edit-coupon-btn">Submit</button>
      <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
    </div>
  </div>

</form>

<script type="text/javascript">

    $(document).ready(function(){

        // Save
        $('#add-edit-coupon-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'coupons/'+hash_id : 'coupons' ;

            var request_data = new FormData(document.getElementById("add-edit-coupon-form"));

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
                    $("#add-edit-coupon-btn").attr("disabled", true);
                    $('#add-edit-coupon-btn').html('Loading..');
                    $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {
                    $("#add-edit-coupon-btn").attr("disabled", false);
                    $('#add-edit-coupon-btn').html('Submit');
                    $("#loading").css("display","none");

                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);

                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-coupon-btn").attr("disabled", false);
                    $('#add-edit-coupon-btn').html('Submit');
                    mcShowErrorsPost(xhr, status, error);
                }

                // success

            }); // $.ajax

        }); // click => #add-edit-banner-btn

        $('#description').summernote({
              height: 100,
        });

        if($("#has_expiry_date").prop('checked') == false){
          $('#ex_date').hide();
        }

        $('#has_expiry_date').click(function () {
            $('#ex_date').toggle();
        });

    }); // .ready

</script>
