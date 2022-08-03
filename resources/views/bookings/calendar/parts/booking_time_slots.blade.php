    
    <?php
    if(!empty($data_arr['service_start_date_error'])){
        
        ?>

        <div class="row mb-3">
            
            <div class="col-md-12 text-right">
                <a  href="#" class="btn btn-sm d-block btn-danger">
                    <i class="fa fa-times mr-1"></i>
                    {!! $data_arr['service_start_date_error'] !!}
                </a>
            </div>

        </div>
        
        <?php

    } else {

        ?>

        <?php
        
        if( !empty($data_arr['day_off']) || !empty($data_arr['date_off']) || !empty($data_arr['service_day_off']) || !empty($data_arr['service_date_off']) ){

            ?>

            <div class="row mb-3">
            
                <div class="col-md-12 text-right">
                    <a  href="#" class="btn btn-sm d-block btn-danger"> <i class="fa fa-times mr-1"></i> DAY OFF </a>
                </div>

            </div>

            <?php

        } else {

            if(!empty($data_arr['week_day_available_slots'])){
                foreach($data_arr['week_day_available_slots'] as $slot){

                    $week_day_mysql_format = date('Y-m-d', strtotime( str_replace('/', '-', $data_arr['request_arr']['week_day']) ));

                    if(!empty($data_arr['edit_booking_id'])){

                        // $where_raw = ' (id != "'.$data_arr['edit_booking_id'].'" AND (booking_status = "PENDING" OR booking_status = "COMPLETED") ) ';

                        $where_raw = ' id != "'.$data_arr['edit_booking_id'].'" AND booking_status != "CANCELLED" ';

                    } else {

                        $where_raw = ' booking_status != "CANCELLED" ';

                    } // if(!empty($data_arr['edit_booking_id']))

                    // Check if slot is not booked already
                    $booking_exist = CommonEloHelper::get_table_row_where_arr_str('service_bookings', array('slot_date' => $week_day_mysql_format, 'slot_start_time' => $slot['slot_start_time']), $where_raw);

                    if(empty($booking_exist)){

                        ?>

                        <div class="col-md-2 col-6 mb-2">
                            <a href="javascript:;" class="btn  d-block btn-sm waves-effect mc-booking-slot {{ (!empty($data_arr['edit_slot_start_time'] && $data_arr['week_day_mysql_format'] == $data_arr['booking_details']['slot_date']) && $data_arr['edit_slot_start_time'] == $slot['slot_start_time']) ? 'btn-success' : 'btn-secondary' }}" data-slot-time="{!! $slot['slot_start_time'] !!}">
                                
                                {!! date('g:i a', strtotime($slot['slot_start_time'])) !!}

                            </a>
                        </div>

                        <?php

                    } // if(empty($booking_exist))

                } // foreach($data_arr['week_day_available_slots'] as $slot)
            } // if(!empty($data_arr['week_day_available_slots']))
            ?>

            <?php

        } // if( !empty($data_arr['day_off']) || !empty($data_arr['date_off']) )

        ?>
    
    <?php } // if(!empty($data_arr['service_start_date_error'])) ?>

    <input type="hidden" id="slot_start_time" name="slot_start_time" value="{{ !empty($data_arr['edit_slot_start_time']) && $data_arr['week_day_mysql_format'] == $data_arr['booking_details']['slot_date'] ? $data_arr['edit_slot_start_time'] : '' }}" readonly="readonly" />

    <script type="text/javascript">
        
        $(document).ready(function(){

            $('.mc-booking-slot').click(function(){

                $('.mc-booking-slot').removeClass('btn-success');
                $('.mc-booking-slot').removeClass('btn-secondary');
                
                $('.mc-booking-slot').addClass('btn-secondary');
                
                $(this).removeClass('btn-secondary');
                $(this).addClass('btn-success');

                var slot_start_time = $(this).attr('data-slot-time');
                $('#slot_start_time').val(slot_start_time);

            }); // click => .mc-booking-slot

        }); // ready

    </script>