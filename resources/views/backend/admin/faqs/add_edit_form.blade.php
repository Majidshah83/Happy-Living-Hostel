<form method="POST" id="add-edit-faq-form">

  @csrf()

    @if(!empty($faq_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($faq_details->hash_id) ? $faq_details->hash_id : '' }}" />

    <div class="row">

        <div class="col-md-12">
          <div class="form-group">
             <label class="form-label">Faq Category<span class="text-red">*</span></label>
             <select class="form-control" name="category_id" id="category_id">
                @foreach($faq_category as $category)
                   <option value="{{$category->id}}" @if(!empty($faq_details->category_id) && $faq_details->category_id == $category->id) selected="true" @endif>{{$category->title}}</option>
                @endforeach()
             </select>
          </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
               <label class="form-label">Question <span class="text-red">*</span></label>
               @include('backend.admin.components.editor', ['item_details' => !empty($faq_details->question) ? $faq_details->question : '','resource' => 'question'])

            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Answer <span class="text-red">*</span></label>
                 @include('backend.admin.components.editor', ['item_details' => !empty($faq_details->answer) ? $faq_details->answer : '','resource' => 'answer'])
            </div>
        </div>

    </div>

    <div class="row">

     <div class="col-md-6">
        <div class="form-group">

           <label class="form-label">Display Order</label>
           <select class="form-control custom-select select2" id="display_order" name="display_order">

              @for ($i = 1; $i < 51; $i++)

                <option {{ !empty($faq_details) && $faq_details->display_order == $i ? 'selected="selected"' : '' }} value="{{ $i }}">{{ $i }}</option>

              @endfor

           </select>

        </div>
     </div>
     <div class="col-md-6">
        <div class="form-group">

           <label class="form-label">Status<span class="text-red">*</span></label>
           <select class="form-control" name="status" id="status">

              <option {{ empty($faq_details) || (!empty($faq_details) && $faq_details->status == '1') ? 'selected="selected"' : '' }} value="1" >Active</option>

              <option {{ !empty($faq_details) && $faq_details->status == '0' ? 'selected="selected"' : '' }} value="0" >Inactive</option>

           </select>

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

            var request_url = (hash_id != '') ? 'faqs/'+hash_id : 'faqs' ;

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
