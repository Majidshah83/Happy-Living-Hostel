
<style type="text/css">
  label.error {
      color: red;
  }
</style>
<form method="POST" id="add-edit-banner-form">

  @csrf()

    @if(!empty($edit_details))

        <input type="hidden" name="_method" value="PUT">

    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($edit_details->hash_id) ? $edit_details->hash_id : '' }}" />

    <div class="row">

      <div class="col-md-2">
        <div class="form-group">

           <label class="form-label">Select Room<span class="text-red">*</span></label>
           <select class="form-control" name="room" id="room" required>
              <option value="">Select Room</option>
              @foreach($rooms as $room)
                  <option value="{{$room->id}}" @if(!empty($edit_details) && $edit_details->room == $room->id) selected @endif>{{$room->room_name}}</option>
              @endforeach()
           </select>
        </div>
     </div>

     <div class="col-md-2">
        <div class="form-group">
           <label class="form-label">Select Customer<span class="text-red">*</span></label>
           <select class="form-control" name="student" id="student" required>
              @if(!empty($edit_details))
                @foreach($students as $student)
                  <option value="{{$student->id}}" @if($edit_details->student == $student->id)  selected @endif>{{$student->first_name}} {{$student->last_name}}</option>
                @endforeach
              @endif
           </select>
        </div>
     </div>

  
      <div class="col-md-2">
        <div class="form-group">
             <label class="form-label">Admission Fee</label>
             <input type="number" class="form-control fee" id="admission_fee" name="admission_fee"  @if(!empty($edit_details)) value="{{$edit_details->admission_fee}}"  @else value="0" @endif />
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
             <label class="form-label">Hostel Fee</label>
             <input type="number"  class="form-control fee" id="hostel_fee" name="hostel_fee" @if(!empty($edit_details)) value="{{$edit_details->hostel_fee}}"  @else value="0" @endif/>
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
             <label class="form-label">Security Fee</label>
              <input type="number"  class="form-control fee" id="security_fee" name="security_fee"  @if(!empty($edit_details)) value="{{$edit_details->security_fee}}" @else value="0" @endif />
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
              <label class="form-label">Ac Fee</label>
              <input type="number" class="form-control"  id="ac_fee" name="ac_fee"  @if(!empty($edit_details)) value="{{$edit_details->ac_fee}}"  @else value="0" @endif />
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
            <label class="form-label">Gayser Charges</label>
            <input type="number"  class="form-control fee" id="gayser_fee" name="gayser_fee"  @if(!empty($edit_details)) value="{{$edit_details->gayser_fee}}"  @else value="0" @endif />
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
             <label class="form-label">Late Fee Fine</label>
             <input type="number"  class="form-control fee" id="late_fee_fine" name="late_fee_fine"  @if(!empty($edit_details)) value="{{$edit_details->late_fee_fine}}"  @else value="0" @endif />
        </div>
      </div>


      <div class="col-md-2">
        <div class="form-group">
             <label class="form-label">Miscellaneous Fee</label>
             <input type="number"  class="form-control fee" id="miscellaneous_fee" name="miscellaneous_fee"  @if(!empty($edit_details)) value="{{$edit_details->miscellaneous_fee}}"  @else value="0" @endif />
        </div>
      </div>
 
        <div class="col-md-2">
          <div class="form-group">
               <label class="form-label">electricty Fee</label>
               <input type="number"  class="form-control fee" id="electricty_fee" name="electricty_fee"  @if(!empty($edit_details)) value="{{$edit_details->electricty_fee}}"  @else value="0" @endif />
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
               <label class="form-label">Per units</label>
               <input type="number"  class="form-control" id="per_units" name="per_units"   @if(!empty($edit_details)) value="{{$edit_details->per_units}}"  @else value="0" @endif />
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
               <label class="form-label">Current Units</label>
               <input type="number"  class="form-control" id="current_units" name="current_units"  @if(!empty($edit_details)) value="{{$edit_details->current_units}}"  @else value="0" @endif />
          </div>
        </div>

      <div class="col-md-2">
          <?php 
             $months = ['01' => 'January','02' => 'February','02' => 'March','04' => 'April' ,'05' => 'May','06' => 'June','07' => 'July','08' => 'August','09' => 'September','10' => 'October','11' => 'November','12' => 'December'];
             $current_month = date('m');
          ?>
          <div class="form-group">
             <label class="form-label">Select Month</label>
             <select name="month_fee" class="form-control" id="month_fee">
                @if(!empty($edit_details) ) 
                <option value="{{$edit_details->month_fee}}">{{$months[$edit_details->month_fee]}}</option>
                @endif 
                @foreach($months as $key => $month)
                  <option value="{{$key}}" @if(empty($edit_details) && $key == $current_month) selected @endif>{{$month}}</option>
                @endforeach()
             </select>
          </div>
       </div>
        <div class="col-md-2">
          <?php 
             $current_year = date('Y');
          ?>
          <div class="form-group">
             <label class="form-label">Select Year</label>
             <select name="year_fee" class="form-control" id="year_fee">
                  {{ $last= date('Y')-60 }}
                  {{ $now = date('Y') }}
                  @if(!empty($edit_details))
                  <option value="{{$edit_details->year_fee}}">{{$edit_details->year_fee}}</option>                  @endif
                  @for ($i = $now; $i >= $last; $i--)
                      <option value="{{ $i }}" >{{ $i }}</option>
                  @endfor
             </select>
          </div>
       </div>
       <div class="col-md-2">
          <div class="form-group">
             <label class="form-label">Payment Type</label>
             <select name="payment_type" class="form-control" id="payment_type">
                <option value="offline" @if(!empty($edit_details) && $edit_details->payment_type == 'offline') selected @endif>Cash</option>
                <option value="online" @if(!empty($edit_details) && $edit_details->payment_type == 'online') selected @endif>Online</option>
             </select>
          </div>
       </div>
       <div class="col-md-3 @if(!empty($edit_details) && $edit_details->payment_type == 'online') selected @else d-none @endif" id="online_payment">
        <div class="form-group">
           <label class="form-label">Select Online Payment</label>
           <select name="payment_company" class="form-control" id="online_payment_type">
              <option value="Bank" @if(!empty($edit_details) && $edit_details->payment_company == 'Bank') selected @endif>Bank</option>
              <option value="Easypaisa" @if(!empty($edit_details) && $edit_details->payment_company == 'Easypaisa') selected @endif>Easy Paisa</option>
              <option value="Jazzcash" @if(!empty($edit_details) && $edit_details->payment_company == 'Jazzcash') selected @endif>Jazz Cash</option>
              <option value="Other"  @if(!empty($edit_details) && $edit_details->payment_company == 'Other') selected @endif>Other</option>                
           </select>
        </div>
      </div>
      <div class="col-md-3 @if(!empty($edit_details) && $edit_details->payment_type == 'online') selected @else d-none @endif"  id="online_td_id">
        <div class="form-group">
             <label class="form-label">Transaction Id</label>
             <input type="transaction_id"  class="form-control" id="transaction_id" name="transaction_id"  @if(!empty($edit_details)) value="{{$edit_details->transaction_id}}"  @else value="0" @endif />
        </div>
      </div>
  </div>

  <div class="row">
     
      <div class="col-md-4">
        <div class="form-group">
             <label class="form-label">Previous Remaining Amount</label>
             <input type="text" class="form-control" readonly id="remaining_amount" name="remaining_amount" @if(!empty($amount)) value="{{$amount}}" @else value="0" @endif />
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
             <label class="form-label">Total Amount</label>
             <input type="text" value="0" class="form-control" readonly id="total_amount" name="total_amount"  required />
        </div>
      </div>

      <hr>

      <div class="col-md-4">
        <div class="form-group">
             <label class="form-label">Recived Amount</label>
             <input type="text" class="form-control" id="due_fee" name="due_fee"  @if(!empty($edit_details)) value="{{$edit_details->due_fee}}"  @else value="0" @endif />
        </div>
      </div>

    <div class="col-md-2 offset-10">
      <button class="btn btn-indigo" type="button" id="add-edit-banner-btn">Submit</button>
      <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
    </div>
  </div>

</form>
 <script src="{{ asset('assets/js/mc_scripts/form_validation/dist/jquery.validate.js') }}"></script>
 <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.js"></script>

<script type="text/javascript">

    $(document).ready(function(){



       let admission_fee = $('#admission_fee').val();
       let hostel_fee = $('#hostel_fee').val();
       let security_fee = $('#security_fee').val();
       let ac_fee = $('#ac_fee').val();
       let gayser_fee = $('#gayser_fee').val();
       let late_fee_fine = $('#late_fee_fine').val();
       let miscellaneous_fee = $('#miscellaneous_fee').val();
       let electricty_fee = $('#electricty_fee').val();
       let remaining_amount = $('#remaining_amount').val();

       let total_amount = parseInt(admission_fee) + parseInt(hostel_fee) + parseInt(security_fee)
       +parseInt(ac_fee)+parseInt(gayser_fee)+parseInt(late_fee_fine)
       +parseInt(miscellaneous_fee)+parseInt(electricty_fee) +parseInt(remaining_amount);
       console.log(total_amount);
       $('#total_amount').val(total_amount);

       $('.fee').change(function(){
        
         let admission_fee = $('#admission_fee').val();
         let hostel_fee = $('#hostel_fee').val();
         let security_fee = $('#security_fee').val();
         let ac_fee = $('#ac_fee').val();
         let gayser_fee = $('#gayser_fee').val();
         let late_fee_fine = $('#late_fee_fine').val();
         let miscellaneous_fee = $('#miscellaneous_fee').val();
         let electricty_fee = $('#electricty_fee').val();
         let remaining_amount = $('#remaining_amount').val();
         let total_amount = parseInt(admission_fee) + parseInt(hostel_fee) + parseInt(security_fee)
         +parseInt(ac_fee)+parseInt(gayser_fee)+parseInt(late_fee_fine)
         +parseInt(miscellaneous_fee)+parseInt(electricty_fee) +parseInt(remaining_amount);
         $('#total_amount').val(total_amount);

       });

       $('#room').change(function() {
                id = $(this).val();
                 $.ajax({

                type: 'post',

                url: '{{url('get-room-student')}}',

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
                    $('#student').html(response);
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

        $('#student').change(function() {
                id = $(this).val();
                 $.ajax({

                type: 'post',

                url: '{{url('get-student-fee')}}',

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
                    console.log(response);
                    $('#hostel_fee').val(response.month_fee);
                    $('#admission_fee').val(response.admission_fee);
                    $('#security_fee').val(response.security_fee);
                    $('#late_fee_fine').val(response.fine);
                 
                   let admission_fee = $('#admission_fee').val();
                   let hostel_fee = $('#hostel_fee').val();
                   let security_fee = $('#security_fee').val();
                   let ac_fee = $('#ac_fee').val();
                   let gayser_fee = $('#gayser_fee').val();
                   let late_fee_fine = $('#late_fee_fine').val();
                   let miscellaneous_fee = $('#miscellaneous_fee').val();
                   let electricty_fee = $('#electricty_fee').val();
                   let remaining_amount = $('#remaining_amount').val();
                   let new_total_amount = parseInt(admission_fee) + parseInt(hostel_fee) + parseInt(security_fee)
                   +parseInt(ac_fee)+parseInt(gayser_fee)+parseInt(late_fee_fine)
                   +parseInt(miscellaneous_fee)+parseInt(electricty_fee) +parseInt(remaining_amount);
                   $('#total_amount').val(new_total_amount);

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


        // Save
        $('#add-edit-banner-btn').click(function(){
            var validator = $('#add-edit-banner-form').validate();
            if(validator.form() != false){
              var hash_id = $('#hash_id').val();
              var request_type = (hash_id != '') ? 'POST' : 'POST' ;
              var request_url = (hash_id != '') ? 'student-fee/'+hash_id : 'student-fee' ;
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
                  
                      $('#loader').delay(2000).hide(100);
                      $("#add-edit-banner-btn").attr("disabled", false);
                      $('#add-edit-banner-btn').html('Submit');
                      $("#loading").css("display","none");
                      $('#general_bootstrap_ajax_popup').modal('hide');
                      let base_url = "{{url('/')}}"+'/fee-details-print/'+response;
                      window.open(base_url, '_blank');
                      location.reload();
                 
                  },
                  error: function(xhr, status, error) {

                      $('#loader').delay(2000).hide(100);
                      $("#add-edit-banner-btn").attr("disabled", false);
                      $('#add-edit-banner-btn').html('Submit');
                      mcShowErrorsPost(xhr, status, error);

                  }
                  // success
              }); // $.ajax
            }
        }); // click => #add-edit-banner-btn

        $('#description').summernote({
              height: 100,
        });

        $('#payment_type').change(function(){
           var payment_type = $(this).val();
           if(payment_type == 'offline'){
             $('#online_payment').addClass('d-none');
             $('#online_td_id').addClass('d-none');
           }else{
             $('#online_payment').removeClass('d-none');
             $('#online_td_id').removeClass('d-none');
           } 
        });

    }); // .ready

</script>
