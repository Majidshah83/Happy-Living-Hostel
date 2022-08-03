
    <div class="row d-none" id="crud_errors_div">

        <div class="col-md-12">

            <div class="alert alert-danger">

                <!-- Contain Dynamic Errors -->
                <ul class="mb-0 d-none" id="crud_errors_ul"></ul>

                <!-- Contain Input File Errors -->
                <ul class="mb-0 d-none" id="file_error_ul"></ul>

            </div>

        </div>

    </div>

    <div class="row mt-3">

        <div class="col-lg-6 ">
            <p><strong class="mr-2">Day: </strong> {{ date('d/m/Y', strtotime($slot_date)) }} </p>
        </div>

        <div class="col-lg-6">

            <!--
            <p>

              <strong class="mr-2">Status: </strong>

              <span class="badge {{ !empty($week_day_on_off_status) ? 'badge-danger' : 'badge-success' }}"> {{ !empty($week_day_on_off_status) ? 'Off' : 'On' }} </span>

            </p>
            -->

        </div>

    </div>

    <div class="row mt-3">

        <div class="col-lg-12">
            <p><i class="fa fa-info-circle mr-1"></i> Enter the time interval and start time to add slots one by one</p>
        </div>

    </div>

    <form method="POST" id="add-slot-process-form">

      @csrf()

      <input type="hidden" id="slot_date" name="slot_date" value="{{ $slot_date }}" readonly="readonly" />

      <div class="row mt-3">

        <div class="col-lg-3">
            <div class="form-group">
                <label>Start Time</label>
                <input type="text" class="form-control mc-timepicker" id="shift_start_time" name="start_time" value="{{ date('g:i a') }}" readonly="readonly" />
            </div>
        </div>

        <div class="col-lg-3">
            <div class="form-group">
                <label>End Time</label>
                <input type="text" class="form-control mc-timepicker" id="shift_end_time" name="end_time" value="{{ date('g:i a') }}" readonly="readonly">
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">

                <label>Time Interval </label>

                <select class="form-control" id="shift_interval" name="time_interval">

                    <option value="5"> 5 Mins </option>

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

        <div class="col-lg-2 mt-0">
            <div class="form-group">

              <label> Action </label>
              <a href="javascript:;" class="btn btn-primary btn-block" id="add-slot-process-btn">
                  Add
              </a>

            </div>
        </div>

      </div>

    </form>

    <div class="row mt-3">

        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">

                    <thead>
                        <tr>
                            <th width="30%">Time Slots</th>
                            <th width="25%">Allowed</th>
                            <th width="35%">Status</th>
                            <th width="10%">Action</th>

                        </tr>
                    </thead>
                    <tbody>

                      @php

                      if(!empty($week_day_slots)){

                        foreach($week_day_slots as $day_slot){

                            if( !in_array($day_slot['slot_start_time'], $week_date_slots_arr_column) ){

                                  $status_class = '';
                                  
                                  if($day_slot['slot_status'] == 'ACTIVE'){

                                    $status_class = '';

                                  } else if($day_slot['slot_status'] == 'RESERVED'){

                                    $status_class = 'bg-warning text-white';

                                  } else if($day_slot['slot_status'] == 'CANCELLED'){

                                    $status_class = 'bg-danger text-white';

                                  } // if($day_slot['slot_status'] == 'ACTIVE')

                                  @endphp

                                  <tr>

                                      <td>
                                          
                                          <a data-toggle="modal" href="#view_booking" class="btn btn-default mb-2 d-block btn-sm">

                                            {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                          </a>

                                      </td>

                                      <td>

                                        <input type="number" step="1" min="1" max="10" class="form-control change-allowed-bookings" data-item-id="{{ $day_slot['id'] }}" data-is-master-slot="1" data-slot-date="{{ $slot_date }}" id="allowed_bookings" name="allowed_bookings" value="{{ $day_slot['allowed_bookings'] }}" />

                                    </td>

                                      <td>
                                          
                                          <select class="form-control {{ $status_class }} change-slot-status" data-item-id="{{ $day_slot['id'] }}" data-is-master-slot="1" data-slot-date="{{ $slot_date }}">
                                              
                                              <option {{ ($day_slot['slot_status'] == 'ACTIVE') ? 'selected="selected"' : '' }} value="ACTIVE"> Active </option>
                                              
                                              <option {{ ($day_slot['slot_status'] == 'RESERVED') ? 'selected="selected"' : '' }} value="RESERVED"> Reserved </option>
                                              
                                              <option {{ ($day_slot['slot_status'] == 'CANCELLED') ? 'selected="selected"' : '' }} value="CANCELLED"> Cancelled </option>

                                          </select>

                                      </td>

                                      <td>
                                         
                                        <a href="javascript:;" class="btn btn-danger mb-2 btn-sm waves-effect remove-slot" data-item-id="{{ $day_slot['id'] }}" data-is-master-slot="1" data-slot-date="{{ $slot_date }}">

                                          <i class="fa fa-trash"></i>

                                        </a>

                                      </td>
                                      
                                  </tr>

                                @php

                            } // if( !in_array($day_slot['slot_start_time'], $week_date_slots_arr_column) )

                        } // foreach($week_day_slots as $day_slot)
                      
                      } else {

                        @endphp

                        <tr>
                          
                          <td colspan="4" class="text-center"> No Slots </td>

                        </tr>

                        @php

                      } // if(!empty($week_day_slots))

                      @endphp

                      <!-- Local slots -->

                      @php

                      if(!empty($week_date_slots)){

                        foreach($week_date_slots as $day_slot){

                          if( empty($day_slot['is_deleted']) || $day_slot['is_deleted'] == 'N' ){

                            $status_class = '';
                            
                            if($day_slot['slot_status'] == 'ACTIVE'){

                              $status_class = '';

                            } else if($day_slot['slot_status'] == 'RESERVED'){

                              $status_class = 'bg-warning text-white';

                            } else if($day_slot['slot_status'] == 'CANCELLED'){

                              $status_class = 'bg-danger text-white';

                            } // if($day_slot['slot_status'] == 'ACTIVE')

                            @endphp

                            <tr>

                                <td>
                                    
                                    <a data-toggle="modal" href="#view_booking" class="btn btn-default mb-2 d-block btn-sm">

                                      {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                    </a>

                                </td>

                                <td>

                                  <input type="number" step="1" min="1" max="10" class="form-control change-allowed-bookings" data-item-id="{{ $day_slot['id'] }}" data-is-master-slot="" data-slot-date="{{ $slot_date }}" id="allowed_bookings" name="allowed_bookings" value="{{ $day_slot['allowed_bookings'] }}" />

                              </td>

                                <td>
                                    
                                    <select class="form-control {{ $status_class }} change-slot-status" data-item-id="{{ $day_slot['id'] }}" data-is-master-slot="" data-slot-date="{{ $slot_date }}">
                                        
                                        <option {{ ($day_slot['slot_status'] == 'ACTIVE') ? 'selected="selected"' : '' }} value="ACTIVE"> Active </option>
                                        
                                        <option {{ ($day_slot['slot_status'] == 'RESERVED') ? 'selected="selected"' : '' }} value="RESERVED"> Reserved </option>
                                        
                                        <option {{ ($day_slot['slot_status'] == 'CANCELLED') ? 'selected="selected"' : '' }} value="CANCELLED"> Cancelled </option>

                                    </select>

                                </td>

                                <td>
                                   
                                  <a href="javascript:;" class="btn btn-danger mb-2 btn-sm waves-effect remove-slot" data-item-id="{{ $day_slot['id'] }}" data-is-master-slot="" data-slot-date="{{ $slot_date }}">

                                    <i class="fa fa-trash"></i>

                                  </a>

                                </td>
                                
                            </tr>

                            @php

                          } // if( empty($day_slot['is_deleted']) || $day_slot['is_deleted'] == 'N' )

                        } // foreach($week_date_slots as $day_slot)
                      
                      } // if(!empty($week_date_slots))

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

                    <input type="hidden" name="pharmacy_id" value="11" readonly="readonly" />

                    <button type="button" class="btn btn-primary mr-1" id="mc_frm_submit_btn">
                        Submit
                    </button>

                    <button data-dismiss="modal" class="btn btn-danger mr-1">
                        Cancel
                    </button>

                </div>

            </div>

        </div>
    </div>
    -->

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

<script type="text/javascript">
    $(document).ready(function() {
        $('.delete-item').click(function(){

            var hash_id = $('#General_bootstrap_delete_popup_hash_id').val();


            $.ajax({

                type: 'POST',

                url: "{{ url('booking_slots/remove_slots') }}"+ "/" + hash_id,

                // processData: false,
                // contentType: false,

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {

                    '_method' : 'DELETE'
                },

                beforeSend: function(result) {

                    // $("#loading").css("display","block");

                    $('#delete_crud_errors_div').addClass('d-none');
                    $('#delete_crud_errors_ul').html('');

                },
                success: function(response) {

                    // $("#loading").css("display","none");

                    // swal(response);
                    location.reload();

                },

                error: function(xhr, status, error) {

                    mcShowErrorsPost(xhr, status, error)
                }

                // success

            }); // $.ajax

        }); // click => .delete-item

        $('.remove-slot').click(function(){

            var _this = this;

            var item_id = $(this).attr('data-item-id');

            var is_master_slot = $(this).attr('data-is-master-slot');

            var slot_date = $(this).attr('data-slot-date');

            $.ajax({
                
                url:"{{ url('booking_slots/date_remove_slots') }}",

                type:'POST',

                dataType:'json',

                data: {item_id: item_id, is_master_slot: is_master_slot, slot_date: slot_date},

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success:function (response){

                  $(_this).parent().parent().remove();

                } // success:function (response)

            });

        }); // click => .remove-slot

        $('#add-slot-process-btn').click(function () {

            var hash_id = "";

            var request_type = (hash_id != '') ? 'POST' : 'POST';


            var request_data = new FormData(document.getElementById("add-slot-process-form"));

            $.ajax({

                type: request_type,

                url: "{{ url('/booking_slots/date_add_slots_process') }}",

                processData: false,

                contentType: false,

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: request_data,

                beforeSend: function (result) {

                    $("#loader").show();
                    $("#add-slot-process-btn").attr("disabled", true);
                    $('#add-slot-process-btn').html('Loading..');

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function (response) {

                    $("#add-slot-process-btn").attr("disabled", false);
                    $('#add-slot-process-btn').html('Add');
                    $("#loading").css("display", "none");
                    // swal(response);
                    // location.reload();
                    // $('#loader').delay(2000).hide(100);

                    location.reload();

                },

                error: function (xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-slot-process-btn").attr("disabled", false);
                    $('#add-slot-process-btn').html('Add');
                    mcShowErrorsPost(xhr, status, error);
                }

                // success

            }); // $.ajax

        });

        $('.change-slot-status').change(function () {

            var _this = this;

            var value = $(this).val();
            var item_id = $(this).attr('data-item-id');

            var is_master_slot = $(this).attr('data-is-master-slot');

            var slot_date = $(this).attr('data-slot-date');

            $.ajax({
                
                url:"{{ url('booking_slots/date_change_slot_status') }}",

                type:'POST',

                dataType:'json',

                data: {item_id: item_id, value: value, is_master_slot: is_master_slot, slot_date: slot_date},

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success:function (response){

                  $(_this).removeClass('bg-warning');
                  $(_this).removeClass('bg-danger');
                  $(_this).removeClass('text-white');

                  if(value == 'ACTIVE'){

                  } else if(value == 'RESERVED'){

                    $(_this).addClass('bg-warning');
                    $(_this).addClass('text-white');

                  } else if(value == 'CANCELLED'){

                    $(_this).addClass('bg-danger');
                    $(_this).addClass('text-white');

                  } // if(value == 'ACTIVE')

                } // success:function (response)

            });
        });

        $('.change-allowed-bookings').change(function () {

            var _this = this;

            var value = $(this).val();
            var item_id = $(this).attr('data-item-id');

            var is_master_slot = $(this).attr('data-is-master-slot');

            var slot_date = $(this).attr('data-slot-date');

            $.ajax({
                
                url:"{{ url('booking_slots/date_allowed_quantity') }}",

                type:'POST',

                dataType:'json',

                data: {item_id: item_id, value: value, is_master_slot: is_master_slot, slot_date: slot_date},

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success:function (response){

                  

                } // success:function (response)

            });
        });

    });
</script>
