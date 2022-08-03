
<style type="text/css">
  label.error {
      color: red;
  }
</style>
<form method="POST" id="add-edit-student-form">

  @csrf()

    @if(!empty($student_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($student_details->hash_id) ? $student_details->hash_id : '' }}" />

    <div class="row">

         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">First Name <span class="text-red">*</span></label>
               <input type="text" class="form-control" id="first_name" name="first_name" value="{{ !empty($student_details->first_name) ? $student_details->first_name : '' }}" required />
            </div>
         </div>

         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Last Name<span class="text-red">*</span></label>
               <input type="text" class="form-control" id="last_name" name="last_name" value="{{ !empty($student_details->last_name) ? $student_details->last_name : '' }}" required />
            </div>
         </div>

         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Father</label>
               <input type="text" class="form-control" id="father_name" name="father_name" value="{{ !empty($student_details->father_name) ? $student_details->father_name : '' }}" required />
            </div>
         </div>

     
         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">CNIC</label>
               <input type="text" class="form-control" id="cnic" name="cnic" value="{{ !empty($student_details->cnic) ? $student_details->cnic : '' }}" required />
            </div>
         </div>

         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Father Cell No</label>
               <input type="text" class="form-control" id="father_cell_no" name="father_cell_no" value="{{ !empty($student_details->father_cell_no) ? $student_details->father_cell_no : '' }}"  />
            </div>
         </div>

         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Gender</label>
               <select name="gender" class="form-control" id="gender">
                 <option value="">Select Gender</option>}
                 <option value="Male" @if(!empty($student_details->gender)== 'Male') selected @endif>   Male </option>
                 <option value="Female" @if(!empty($student_details->gender)== 'Female') selected @endif> Female </option>
               </select>
            </div>
         </div>

         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Date Of Birth</label>
               <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ !empty($student_details->date_of_birth) ? $student_details->date_of_birth : '' }}" required />
            </div>
         </div>

          <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Father Accup</label>
               <input type="text" class="form-control" id="father_accupation" name="father_accupation" placeholder="Father Accupation" value="{{ !empty($student_details->father_accupation) ? $student_details->father_accupation : '' }}"  />
            </div>
         </div>

         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Department/Faculty</label>
               <input type="text" class="form-control" id="department_faculty" name="department_faculty" value="{{ !empty($student_details->department_faculty) ? $student_details->department_faculty : '' }}"  />
            </div>
         </div>

          <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Relation With Guardian</label>
               <input type="text" class="form-control" id="relation_with_guardian" name="relation_with_guardian" value="{{ !empty($student_details->relation_with_guardian) ? $student_details->relation_with_guardian : '' }}"  />
            </div>
         </div>

          <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">University/Company Name</label>
               <input type="text" class="form-control" id="uni_company_name" name="uni_company_name" value="{{ !empty($student_details->uni_company_name) ? $student_details->uni_company_name : '' }}"  />
            </div>
         </div>

         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">University/Company Id</label>
               <input type="text" class="form-control" id="uni_company_id" name="uni_company_id" value="{{ !empty($student_details->uni_company_id) ? $student_details->uni_company_id : '' }}"  />
            </div>
         </div>
       
        <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Semester</label>
               <input type="text" class="form-control" id="semester" name="semester" value="{{ !empty($student_details->semester) ? $student_details->semester : '' }}"  />
            </div>
         </div>

        <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Email</label>
               <input type="text" class="form-control" id="email" name="email" value="{{ !empty($student_details->email) ? $student_details->email : '' }}"  />
            </div>
         </div>

        <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">City</label>
               <input type="text" class="form-control" id="city" name="city" value="{{ !empty($student_details->city) ? $student_details->city : '' }}"  />
            </div>
         </div>

         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Nationality</label>
               <input type="text" class="form-control" id="nationality" name="nationality" value="{{ !empty($student_details->nationality) ? $student_details->nationality : '' }}"  />
            </div>
         </div>

        <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Admission Date</label>
               <input type="date" class="form-control" id="admission_date" name="admission_date" value="{{ !empty($student_details->admission_date) ? $student_details->admission_date : '' }}"  />
            </div>
         </div>

        <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Admission Fee *</label>
               <input type="text" class="form-control" id="admission_fee" name="admission_fee" value="{{ !empty($student_details->admission_fee) ? $student_details->admission_fee : '' }}"  required/>
            </div>
         </div>

          <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Security Fee *</label>
               <input type="TEXT" class="form-control" id="security_fee" name="security_fee" value="{{ !empty($student_details->security_fee) ? $student_details->security_fee : '' }}"  required />
            </div>
         </div>

      
         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Monthely Fee *</label>
               <input type="text" class="form-control" id="monthely_fee" name="monthely_fee" value="{{ !empty($student_details->monthely_fee) ? $student_details->monthely_fee : '' }}"  required />
            </div>
         </div>



         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Address</label>
               <input type="text" class="form-control" id="address" name="address"  value="{{ !empty($student_details->address) ? $student_details->address : '' }}"  />
            </div>
         </div>

         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Mobile Number</label>
               <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{ !empty($student_details->mobile_number) ? $student_details->mobile_number : '' }}"  />
            </div>
         </div>

         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label">Home Number</label>
               <input type="text" class="form-control" id="home_number" name="home_number" value="{{ !empty($student_details->home_number) ? $student_details->home_number : '' }}"   />
            </div>
         </div>

         <div class="col-md-2">
            <div class="form-group">
               <label class="form-label"> Profession </label>
               <input type="text" class="form-control" id="profession" name="profession" value="{{ !empty($student_details->profession) ? $student_details->profession : '' }}"  />
            </div>
         </div>

        <div class="col-md-2">
          <div class="form-group">
             <label class="form-label">Status<span class="text-red">*</span></label>
             <select class="form-control" name="status" id="status">
                <option {{ empty($student_details) || (!empty($student_details) && $student_details->status == '1') ? 'selected="selected"' : '' }} value="1" >Active</option>
                <option {{ !empty($student_details) && $student_details->status == '0' ? 'selected="selected"' : '' }} value="0" >Inactive</option>
             </select>
          </div>
       </div>

        <div class="col-md-2">
          <div class="form-group">
             <label class="form-label">Floor<span class="text-red">*</span></label>
             <select class="form-control" name="floor" id="floor">
              <option value="">Select Floor</option>}
              @foreach($floors as $floor)
                <option value="{{$floor->id}}" @if(!empty($student_details->floor_id) && $student_details->floor_id == $floor->id) selected @endif>{{$floor->title}}</option>
              @endforeach
             </select>
          </div>
       </div>

       <div class="col-md-2">
          <div class="form-group">
             <label class="form-label">Rooms<span class="text-red">*</span></label>
             <select class="form-control" name="room" id="room">
             <option value="">Select Room</option>
             @if(!empty($student_details))
               @foreach($rooms as $room)
                 <option value="{{$room->id}}" @if($student_details->room_id == $room->id) selected @endif>{{$room->room_name}}</option>
              @endforeach
            @endif
          </select>
          </div>
       </div>

        <div class="col-md-2">
            <div class="form-group">

               <label class="form-label">Upload Image</label>
               <input type="file" name="image" id="image"  />

            </div>
         </div>
         <div class="col-md-2">
               <div class="imagepreview mt-2 mb-2" id="imagepreview">
                  @if(!empty($student_details->image))
                    <img src="{{asset('storage/student/'.$student_details->image)}}" height="20" class="img-fluid img-responsive" id="edit_file"/>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="remove_image" name="remove_image" value="1" />
                            Check to remove this image
                        </label>
                    </div>
                  @endif
              </div>
        </div>

    <div class="col-md-2 offset-md-10">
      <button class="btn btn-indigo" type="button" id="add-edit-student-btn">Submit</button>
      <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
    </div>
  </div>

</form>

 <script src="{{ asset('assets/js/mc_scripts/form_validation/dist/jquery.validate.js') }}"></script>
 <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.js"></script>


<script type="text/javascript">

    $(document).ready(function(){

          $('#add-edit-student-btn').click(function(){

            var validator = $('#add-edit-student-form').validate();

            if(validator.form() != false){

                   var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'students/'+hash_id : 'students' ;

            var request_data = new FormData(document.getElementById("add-edit-student-form"));

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



            } // if(validator.form() == true)

        }); // click => #step1_form_sbt

      


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
