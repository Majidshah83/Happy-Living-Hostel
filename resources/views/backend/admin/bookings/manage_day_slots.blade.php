
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css" integrity="sha512-E4kKreeYBpruCG4YNe4A/jIj3ZoPdpWhWgj9qwrr19ui84pU5gvNafQZKyghqpFIHHE4ELK7L9bqAv7wfIXULQ==" crossorigin="anonymous" />

<style type="text/css">
    
    .timerpicker {
        
        border: 1px solid #ddd;
        
        padding: 8px;

        z-index: 1100 !important; 

    }

</style>

<form class="custom-validation" id="mc-form">

    <div class="row d-none" id="crud_errors_div">

        <div class="col-md-12">

            <div class="alert alert-danger">

                <!-- Contain Dynamic Errors -->
                <ul class="mb-0 d-none" id="crud_errors_ul">
                </ul>

                <!-- Contain Input File Errors -->
                <ul class="mb-0 d-none" id="file_error_ul"></ul>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-6 ">
            <p><strong class="mr-2">Day: </strong> {{ $week_day_name }} </p>
        </div> 

        <div class="col-lg-6">
            
            <p>
              
              <strong class="mr-2">Status: </strong>
              
              @if(!empty($week_day_on_off_status))

                <span class="badge badge-danger">Off</span>

              @else

                <span class="badge badge-success">On</span>

              @endif

            </p>

        </div> 

        <div class="col-lg-12">
            <p><i class="fa fa-info-circle mr-1"></i> Enter the time interval and start time to add slots one by one</p>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <label>Start Time</label>
                <input type="text" class="form-control mc-timepicker" id="shift_start_time" value="{{ date('g:i a') }}" readonly="readonly" />
            </div>
        </div>
        

        <div class="col-lg-4">
            <div class="form-group">
                
                <label>Time Interval </label>

                <select class="form-control" id="shift_interval">
                    
                    <option value="10"> 10 Mins </option>
                    
                    <option value="15"> 15 Mins </option>
                    
                    <option value="20"> 20 Mins </option>
                    
                    <option value="25"> 25 Mins </option>
                    
                    <option value="30"> 30 Mins </option>
                    
                    <option value="35"> 35 Mins </option>
                    
                    <option value="40"> 40 Mins </option>
                    
                    <option value="45"> 45 Mins </option>
                    
                    <option value="50"> 50 Mins </option>

                    <option value="55"> 55 Mins </option>
                    
                    <option value="60"> 60 Mins </option>

                </select>

            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label>Total</label>
                <input type="text" class="form-control" id="shift_total_slots" />
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
          
                    <label class="text-white"> Action </label>
                    <a href="javascript:;" class="btn btn-primary waves-effect waves-light" id="add-interval-slots">
                        Add
                    </a>
                
            </div>
        </div> 

        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-bordered table-condensed mb-0">

                    <thead>
                        <tr>
                            <th>Time Slots</th>
                            <th width="40%">Status</th>
                            <th width="20%">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        
                        @php

                        if(!empty($week_day_slots)){

                          foreach($week_day_slots as $day_slot){

                            $status_class = '';
                            
                            if($day_slot['slot_status'] == 'ACTIVE'){

                              $status_class = '';

                            } else if($day_slot['slot_status'] == 'INACTIVE'){

                              $status_class = 'bg-danger text-white';

                            } else if($day_slot['slot_status'] == 'BOOKED'){

                              $status_class = 'bg-success text-white';

                            } // if($day_slot['slot_status'] == 'ACTIVE')

                            @endphp

                            <tr>

                                <td>
                                    
                                    <a data-toggle="modal" href="#view_booking" class="btn btn-secondary mb-2 d-block btn-sm waves-effect">

                                      {{ CommonCustomHelper::time_format($day_slot['slot_start_time']) }}

                                    </a>

                                </td>

                                <td>
                                    
                                    <select class="form-control form-control-sm {{ $status_class }} change-slot-status" data-item-id="{{ $day_slot['id'] }}">
                                        
                                        <option {{ ($day_slot['slot_status'] == 'ACTIVE') ? 'selected="selected"' : '' }} value="ACTIVE"> Active </option>
                                        
                                        <option {{ ($day_slot['slot_status'] == 'INACTIVE') ? 'selected="selected"' : '' }} value="INACTIVE"> Inactive </option>
                                        
                                        <option {{ ($day_slot['slot_status'] == 'BOOKED') ? 'selected="selected"' : '' }} value="BOOKED"> Booked </option>

                                    </select>

                                </td>

                                <td>
                                   
                                  <a href="javascript:;" class="btn btn-danger mb-2 btn-sm waves-effect remove-slot" data-item-id="{{ $day_slot['id'] }}">

                                    <i class="fa fa-trash"></i>

                                  </a>

                                </td>
                                
                            </tr>

                            @php

                          } // foreach($week_day_slots as $day_slot)
                        
                        } else {

                          @endphp

                          <tr>
                            
                            <td colspan="3" class="text-center"> No Slots </td>

                          </tr>

                          @php

                        } // if(!empty($week_day_slots))

                        @endphp

                    </tbody>
                </table>
            </div>
        </div> 

    </div>

    <!--
    <div class="row mt-3">
        <div class="col-lg-12">

            <div class="form-group mb-0">
                
                <div>
                    
                    <input type="hidden" name="pharmacy_id" value="{{ session()->get('pharmacy_id') }}" readonly="readonly" />

                    <button type="button" class="btn btn-primary waves-effect waves-light mr-1" id="mc_frm_submit_btn">
                        Submit
                    </button>

                    <button data-dismiss="modal" class="btn btn-danger waves-effect waves-light mr-1">
                        Cancel
                    </button>

                </div>

            </div>

        </div>
    </div>
    -->

</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js" integrity="sha512-2xXe2z/uA+2SyT/sTSt9Uq4jDKsT0lV4evd3eoE/oxKih8DSAsOF6LUb+ncafMJPAimWAXdu9W+yMXGrCVOzQA==" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function(){

        $('.mc-timepicker').timepicker({
            showMeridian: true,
            minuteStep: 5,
            icons: {
                    up: 'fa fa-arrow-up',
                    down: 'fa fa-arrow-down'
                }
        });

    }); // ready
</script>

<script>
$(document).ready(function() {

    $('.change-slot-status').change(function(){

      var item_id = $(this).attr('data-item-id');
      var new_status = $(this).val();
      var _this = this;

      $.ajax({

          type: "POST",
          url: "/bookings/change_booking_slot_status_process",
          // processData: false,
          // contentType: false,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },

          data: {

            'item_id' : item_id,
            'new_status' : new_status

          },

          beforeSend: function(result) {

              $("#loading").css("display","block");
              
              $('#crud_errors_div').addClass('d-none');
              $('#crud_errors_ul').html('');

          },
          success: function(response) {

              $("#loading").css("display","none");
              
              if (response.status == 'success') {
                  
                  mc_notify('success', response.message);
                  
                  // Update colors according to the statuses
                  $(_this).removeClass('bg-danger bg-success text-white');

                  if(new_status == 'INACTIVE'){

                    $(_this).addClass('bg-danger text-white');

                  } else if(new_status == 'BOOKED'){

                    $(_this).addClass('bg-success text-white');

                  } // if(new_status == 'INACTIVE')

                  // $("#general_bootstrap_ajax_popup").modal('hide');
                    
                  // $(_this).parent().parent().remove();
                  // location.reload();

              }

              $('#crud_errors_div').addClass('d-none');
              $('#crud_errors_ul').html('');

              // console.log(response);
          },
          error: function(xhr, status, error) {

              $("#loading").css("display","none");

              $.each(xhr.responseJSON.errors, function(key, item) {

                  // mc_notify('danger', item);
                  
                  $('#crud_errors_div').removeClass('d-none');
                  $('#crud_errors_ul').removeClass('d-none');

                  var new_html = '<li> ' + item + ' </li>';
                  $('#crud_errors_ul').append(new_html);

              });
          }

      }); // $.ajax

    }); // click => .change-slot-status

    $('.remove-slot').click(function(){

      var item_id = $(this).attr('data-item-id');
      var _this = this;

      $.ajax({

          type: "GET",
          url: "/bookings/remove_booking_slot_process/"+item_id,
          // processData: false,
          // contentType: false,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },

          /*data: {

            'shift_start_time' : shift_start_time,
            'shift_interval' : shift_interval,
            'shift_total_slots' : shift_total_slots,
            'slot_day_number' : slot_day_number

          },*/
          beforeSend: function(result) {

              $("#loading").css("display","block");
              
              $('#crud_errors_div').addClass('d-none');
              $('#crud_errors_ul').html('');

          },
          success: function(response) {

              $("#loading").css("display","none");
              
              if (response.status == 'success') {
                  
                  mc_notify('success', response.message);
                  
                  // $("#general_bootstrap_ajax_popup").modal('hide');
                    
                  $(_this).parent().parent().remove();
                  // location.reload();

              }

              $('#crud_errors_div').addClass('d-none');
              $('#crud_errors_ul').html('');

              // console.log(response);
          },
          error: function(xhr, status, error) {

              $("#loading").css("display","none");

              $.each(xhr.responseJSON.errors, function(key, item) {

                  // mc_notify('danger', item);
                  
                  $('#crud_errors_div').removeClass('d-none');
                  $('#crud_errors_ul').removeClass('d-none');

                  var new_html = '<li> ' + item + ' </li>';
                  $('#crud_errors_ul').append(new_html);

              });
          }

      }); // $.ajax

    }); // click => .remove-slot

    $('#add-interval-slots').click(function(){

      var shift_start_time = $('#shift_start_time').val();
      var shift_interval = $('#shift_interval').val();
      var shift_total_slots = $('#shift_total_slots').val();
      var slot_day_number = '{{ $day_number }}';

      if(shift_start_time == '' || shift_interval == '' || shift_total_slots == ''){

        alert('Please fill all the fields.');
        return false;

      } // if(shift_start_time == '' || shift_interval == '' || shift_total_slots == '')

      $.ajax({

          type: "POST",
          url: "/bookings/add_shift_interval_day_slots",
          // processData: false,
          // contentType: false,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },

          data: {

            'shift_start_time' : shift_start_time,
            'shift_interval' : shift_interval,
            'shift_total_slots' : shift_total_slots,
            'slot_day_number' : slot_day_number

          },
          beforeSend: function(result) {

              $("#loading").css("display","block");
              $('#crud_errors_div').addClass('d-none');
              $('#crud_errors_ul').html('');

              $("#general_bootstrap_ajax_popup").modal('hide');

          },
          success: function(response) {

              $("#loading").css("display","none");
              
              if (response.status == 'success') {
                  
                  mc_notify('success', response.message);

                  $("#general_bootstrap_ajax_popup").modal('hide');
                  
                  location.reload();

              }

              $('#crud_errors_div').addClass('d-none');
              $('#crud_errors_ul').html('');

              // console.log(response);
          },
          error: function(xhr, status, error) {

              $("#loading").css("display","none");

              $.each(xhr.responseJSON.errors, function(key, item) {

                  // mc_notify('danger', item);
                  
                  $('#crud_errors_div').removeClass('d-none');
                  $('#crud_errors_ul').removeClass('d-none');

                  var new_html = '<li> ' + item + ' </li>';
                  $('#crud_errors_ul').append(new_html);

              });
          }

      }); // $.ajax

    }); // click => #add-interval-slots

    $("#mc_frm_submit_btn").click(function(event) {

        event.preventDefault();

        var data = new FormData(document.getElementById("mc-form"));
        
        $.ajax({

            type: "POST",
            url: "/pharmacy_services/update_calendar_settings",
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            data: data,
            beforeSend: function(result) {

                $("#loading").css("display","block");
                $('#crud_errors_div').addClass('d-none');
                $('#crud_errors_ul').html('');

            },
            success: function(response) {


                $("#loading").css("display","none");
                
                if (response.status == 'success') {
                    mc_notify('success', response.message);
                    $("#general_bootstrap_ajax_popup").modal('hide');
                      location.reload();

                }

                $('#crud_errors_div').addClass('d-none');
                $('#crud_errors_ul').html('');

                // console.log(response);
            },
            error: function(xhr, status, error) {

                $("#loading").css("display","none");

                $.each(xhr.responseJSON.errors, function(key, item) {

                    // mc_notify('danger', item);
                    
                    $('#crud_errors_div').removeClass('d-none');
                    $('#crud_errors_ul').removeClass('d-none');

                    var new_html = '<li> ' + item + ' </li>';
                    $('#crud_errors_ul').append(new_html);

                });
            }

        }); // $.ajax

    });

});
</script>