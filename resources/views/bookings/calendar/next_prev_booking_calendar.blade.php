
    <div class="row mb-3">
        
        <div class="col-lg-4 col-sm-12">
            <table>
                <tr>
                    <td><a href="" class="btn btn-info btn-sm d-block text-center">New Booking</a></td>
                   
                    <td><a href="" class="btn btn-success btn-sm d-block text-center">Completed</a></td>
                    
                </tr>
                <tr>
                    <td width="50%"><a href="" class="btn btn-danger btn-sm d-block text-center ">Cancelled</a></td>
                   
                    <td width="50%"><a href="" class="btn btn-warning btn-sm d-block text-center ">Missed</a></td> 
                   
                </tr>
                
            </table>
         
        </div>

        <div class="col-lg-4 col-8 text-center">
            
            <!-- Select Date -->
            <div class="bookingmaster-date d-inline">
                
                <span id="rxdate_weekly" rel="<?php echo $data_arr['new_current_date']; ?>" class="pointer">
                
                  <span id="date_link_weekly">

                    <h4 class="font-size-18 mt-3">

                        <?php echo ($data_arr['week_list']) ? date('d M', strtotime($data_arr['week_list'][0])).' - '.date('d', strtotime($data_arr['week_list'][6])).' '.date('M', strtotime($data_arr['week_list'][6])) : '' ;?>
                            

                    </h4>

                  </span>
                  
                  <span id="current_day_weekly"></span>

                  <input class="sch_date" id="sch_date_weekly" name="date_check_current_next_pre" type="text" value="<?php echo date('d/m/Y', strtotime(str_replace('/','-',$data_arr['new_current_date'])));?>" readonly style="visibility: hidden; width: 0%;position:absolute" />

                </span>

            </div>

        </div>

        <div class="col-lg-4 col-4 text-right">
            
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                
                <label class="btn btn-primary" id="prev_day_weekly">
                   <span class="fa fa-chevron-left"></span>
                </label>
                
                <label class="btn btn-primary" {!! ($data_arr['calendar_end_date'] && in_array($data_arr['calendar_end_date'], $data_arr['week_list'])) ? '' : 'id="next_day_weekly"' !!} >
                    
                    <span class="fa fa-chevron-right"></span>

                </label>

            </div>

        </div>

    </div>

    <div class="table-responsive">
        <table class="table table-bordered mb-0">

            <thead>
                <tr>

                    <?php
                    if($data_arr['week_list']){
                        foreach($data_arr['week_list'] as $key => $week_day){
                            
                            ?>

                            <th>

                                <?php echo ($week_day) ? date('D', strtotime($week_day)) : '' ; ?>

                                <?php echo ($week_day) ? date('d', strtotime($week_day)) : '' ; ?>

                            </th>
                            
                            <?php
                            
                        } // foreach($data_arr['week_list'] as $week_day)

                    } // if($data_arr['week_list'])
                    ?>

                </tr>
            </thead>
            <tbody>
                
                <tr>

                    <?php

                    if($data_arr['week_list']){
                        foreach($data_arr['week_list'] as $key => $week_day){

                            ?>

                            <td>
                                
                                <?php

                                if( !empty($data_arr['week_off_days'][$week_day]) || !empty($data_arr['week_off_dates'][$week_day]) ){

                                    ?>

                                    <div class="row mb-3">
                                    
                                        <div class="col-md-12 text-right">
                                            <a  href="#" class="btn btn-sm d-block btn-danger"> <i class="fa fa-times mr-1"></i> DAY OFF </a>
                                        </div>

                                    </div>

                                    <?php

                                } else {

                                    ?>

                                    <?php

                                    $date_today = date('Y-m-d');
                                    if( strtotime($week_day) >= strtotime($date_today) ){

                                        ?>

                                        <div class="row mb-3">
                    
                                             <div class="col-md-12 text-right">

                                                <a href="javascript:;" class="btn btn-sm btn-secondary add-new-inhouse-booking" data-week-day="{{ $week_day }}">

                                                    <i class="fa fa-plus mr-1"></i>

                                                    Available

                                                    <span class="badge badge-success">

                                                        {{ !empty($data_arr['week_day_available_slots'][$week_day]) ? count($data_arr['week_day_available_slots'][$week_day]) : '0' }} 

                                                    </span>

                                                </a>

                                            </div>

                                        </div>

                                        <?php
                                    } // if( strtotime($week_day) < strtotime($date_today) )
                                    ?>

                                    <?php
                                    if(!empty($data_arr['week_day_bookings'][$week_day])){
                                        foreach($data_arr['week_day_bookings'][$week_day] as $booking_details){

                                            // Get booking patient details
                                            if(!empty($booking_details['patient_id'])){
                                                $patient_details = CommonEloHelper::get_table_row('patients', $booking_details['patient_id']);
                                            } // if(!empty($booking_details['patient_id']))

                                            // Get booking service details
                                            $service_details = CommonEloHelper::get_table_row('services', $booking_details['service_id']);

                                            ?>

                                            <?php if($booking_details['booking_status'] == 'PENDING'){ ?>

                                                <?php

                                                // Verify if weekday is past
                                                $date_today = date('Y-m-d');
                                                if( strtotime($week_day) < strtotime($date_today) ){
                                                    ?>

                                                    <a href="javascript:;" class="btn btn-warning mb-2 d-block btn-sm waves-effect edit-booking" data-week-day="{{ $week_day }}" data-booking-id="{{ $booking_details['id'] }}">
                                                        
                                                        {!! date('g:i a', strtotime($booking_details['slot_start_time'])) !!}

                                                        <br />

                                                        {!! !empty($patient_details) ? ucfirst($patient_details['first_name']).' '.ucfirst($patient_details['last_name']) : '' !!}

                                                        <br />

                                                        {!! !empty($service_details) ? ucfirst($service_details['title']) : '' !!}

                                                    </a>

                                                    <?php

                                                } else {

                                                    ?>

                                                    <a href="javascript:;" class="btn btn-info mb-2 d-block btn-sm waves-effect edit-booking" data-week-day="{{ $week_day }}" data-booking-id="{{ $booking_details['id'] }}">

                                                        {!! date('g:i a', strtotime($booking_details['slot_start_time'])) !!}

                                                        <br />

                                                        {!! !empty($patient_details) ? ucfirst($patient_details['first_name']).' '.ucfirst($patient_details['last_name']) : '' !!}

                                                        <br />

                                                        {!! !empty($service_details) ? ucfirst($service_details['title']) : '' !!}

                                                    </a>

                                                    <?php
                                                }// if( $date_today >= $week_day )

                                                ?>

                                            <?php } else if($booking_details['booking_status'] == 'COMPLETED'){ ?>

                                                <a href="javascript:;" class="btn btn-success mb-2 d-block btn-sm waves-effect">

                                                    {!! date('g:i a', strtotime($booking_details['slot_start_time'])) !!}

                                                    <br />

                                                    {!! !empty($patient_details) ? ucfirst($patient_details['first_name']).' '.ucfirst($patient_details['last_name']) : '' !!}

                                                    <br />

                                                    {!! !empty($service_details) ? ucfirst($service_details['title']) : '' !!}

                                                </a> 

                                            <?php } else if($booking_details['booking_status'] == 'CANCELLED'){ ?>

                                                <a href="javascript:;" class="btn btn-danger mb-2 d-block btn-sm waves-effect">

                                                    {!! date('g:i a', strtotime($booking_details['slot_start_time'])) !!}

                                                    <br />

                                                    {!! !empty($patient_details) ? ucfirst($patient_details['first_name']).' '.ucfirst($patient_details['last_name']) : '' !!}

                                                    <br />

                                                    {!! !empty($service_details) ? ucfirst($service_details['title']) : '' !!}

                                                </a>

                                            <?php } // if($booking_details['booking_status'] == 'PENDING') ?>

                                            <?php
                                        } // foreach($data_arr['week_day_bookings'][$week_day] as $booking_details)
                                    } // if(!empty($data_arr['week_day_bookings'][$week_day]))
                                    ?>
                                    
                                    <?php
                                } // if( !empty($data_arr['week_off_days'][$week_day]) || !empty($data_arr['week_off_dates'][$week_day]) )
                                ?>

                            </td>

                            <?php

                        } // foreach($data_arr['week_list'] as $key => $week_day)
                    } // if($data_arr['week_list'])
                    
                    ?>

                </tr>
                
            </tbody>
        </table>
    </div>