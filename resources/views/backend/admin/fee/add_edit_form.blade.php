<form method="POST" id="add-edit-fee-form">

  @csrf()

    @if(!empty($student_fee_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($student_fee_details->hash_id) ? $student_fee_details->hash_id : '' }}" />
    <input type="hidden" id="student_id" name="student_id" value="{{ !empty($student->id) ? $student->id : '' }}" />

    <div class="row">

        
         <div class="col-md-12">
            <div class="form-group">
               <label class="form-label">Student Name</label>
               <input type="text" class="form-control" id="due" name="due" value="{{ !empty($student) ? $student->first_name .' '.$student->last_name : '' }}" required />
            </div>
         </div>

         <div class="col-md-12">
            <div class="form-group">
               <label class="form-label">Due <span class="text-red">*</span></label>
               <input type="text" class="form-control" id="due" name="due" value="{{ !empty($student_fee_details->due) ? $student_fee_details->due : '' }}" required />
            </div>
         </div>

         <div class="col-md-12">
            <div class="form-group">
               <label class="form-label">Date <span class="text-red">*</span></label>
               <input type="date" class="form-control" id="date" name="date" value="{{ !empty($student_fee_details->date) ? $student_fee_details->date : '' }}" required />
            </div>
         </div>

        <div class="col-md-12">
          <div class="form-group">
             <label class="form-label">Fee Type<span class="text-red">*</span></label>
             <select class="form-control" name="fee_type_id" id="fee_type_id">
              <option value="">Select Fee Type</option>}
              @foreach($fee_type as $type)
                <option value="{{$type->id}}" @if(!empty($student_fee_details->fee_type_id) && $student_fee_details->fee_type_id == $type->id) selected @endif>{{$type->title}}</option>
              @endforeach
             </select>
          </div>
       </div>

      <div class="col-md-12">
          <div class="form-group">
             <label class="form-label">Description</label>
             @include('backend.admin.components.editor', ['item_details' => !empty($student_fee_details->description) ? $student_fee_details->description : '','resource' => 'description' ])
          </div>
       </div>


    </div>



  </div>

  <hr />

  <div class="row">
    <div class="col-md-3 offset-9">
      <button class="btn btn-indigo" type="button" id="add-edit-fee-btn">Submit</button>
      <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
    </div>
  </div>

</form>

<script type="text/javascript">

    $(document).ready(function(){

        // Save
        $('#add-edit-fee-btn').click(function(){

            var hash_id = $('#hash_id').val();
          
            var request_type = (hash_id != '') ? 'POST' : 'POST' ;
            var request_url = (hash_id != '') ? '{{url('student/fee/update')}}/'+hash_id : '{{url('student/fee/store')}}' ;
            var request_data = new FormData(document.getElementById("add-edit-fee-form"));

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
                    $("#add-edit-student-btn").attr("disabled", true);
                    $('#add-edit-student-btn').html('Loading..');

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {

                    $("#add-edit-student-btn").attr("disabled", false);
                    $('#add-edit-student-btn').html('Submit');
                    $("#loading").css("display","none");
                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);


                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-student-btn").attr("disabled", false);
                    $('#add-edit-student-btn').html('Submit');
                    mcShowErrorsPost(xhr, status, error);
                }

                // success

            }); // $.ajax



        }); // click => #add-edit-banner-btn


            $('#floor').change(function() {
                id = $(this).val();
                 $.ajax({

                type: 'post',

                url: '{{url('get-floor-rooms')}}',

                // processData: false,

                // contentType: false,

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {'id':id},

                beforeSend: function(result) {

                    // $("#loader").show();
                    // $("#add-edit-student-btn").attr("disabled", true);
                    // $('#add-edit-student-btn').html('Loading..');

                    // $('#crud_errors_div').addClass('d-none');
                    // $('#crud_errors_ul').html('');

                },
                success: function(response) {
                    $('#room').html(response);
                    // $("#add-edit-student-btn").attr("disabled", false);
                    // $('#add-edit-student-btn').html('Submit');
                    // $("#loading").css("display","none");
                    // // swal(response);
                    // location.reload();
                    // $('#loader').delay(2000).hide(100);


                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-student-btn").attr("disabled", false);
                    $('#add-edit-student-btn').html('Submit');
                    mcShowErrorsPost(xhr, status, error);
                }

                // success

            }); // $.ajax

            });

        $('#description').summernote({
              height: 100,
        });

    }); // .ready

</script>
