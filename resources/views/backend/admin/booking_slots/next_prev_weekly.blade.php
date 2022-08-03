
    <div class="row mb-4">
        
        <div class="col-lg-4 col-sm-12">
            
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

                            $week_day_number = date('N', strtotime($week_day));
                            
                            // Verify if the day is on or off => LOCAL settings got top proprity for both ON / OFF
                            $globaly_is_off = !empty($week_day_on_off_status[$week_day_number]) ? '1' : '' ;

                            // Get localy OFF row for the week_day

                            $localy_date_off_row = CommonEloHelper::get_table_row_where_arr('mc_booking_slots_off_dates', array('off_date' => $week_day));

                            $localy_is_off = !empty($localy_date_off_row) ? '1' : '' ;

                            // Get localy ON row for the week_day

                            $localy_date_on_row = CommonEloHelper::get_table_row_where_arr('mc_booking_slots_on_dates', array('on_date' => $week_day));

                            $localy_is_on = !empty($localy_date_on_row) ? '1' : '' ;

                            $the_day_is_off = ( !empty($globaly_is_off) || !empty($localy_is_off) ) && empty($localy_is_on) ? '1' : '' ;

                            ?>

                            <th>

                                <div class="row">

                                    <div class="col-md-6">

                                        <?php echo ($week_day) ? date('D', strtotime($week_day)) : '' ; ?>

                                        <?php echo ($week_day) ? date('d', strtotime($week_day)) : '' ; ?>

                                    </div>

                                    <div class="col-md-6">

                                            <span class="pull-right">

                                                <div class="form-group">
                                                    <div class="form-label"></div>
                                                    <label class="custom-switch">
                                                        
                                                        <input type="checkbox" class="custom-switch-input week-date-switch" id="date_on_off_switch" name="week_day_onn_off_switch" value="{{ $week_day }}" {{ !empty($the_day_is_off) ? '' : 'checked="checked"' }} />
                                                        <span class="custom-switch-indicator">

                                                        </span>
                                                    </label>
                                                </div>

                                            </span>


                                    </div>

                                </div>

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

                            $week_day_number = date('N', strtotime($week_day));

                            // Verify if the day is on or off => LOCAL settings got top proprity for both ON / OFF
                            $globaly_is_off = !empty($week_day_on_off_status[$week_day_number]) ? '1' : '' ;

                            // Get localy OFF row for the week_day

                            $localy_date_off_row = CommonEloHelper::get_table_row_where_arr('mc_booking_slots_off_dates', array('off_date' => $week_day));

                            $localy_is_off = !empty($localy_date_off_row) ? '1' : '' ;

                            // Get localy ON row for the week_day

                            $localy_date_on_row = CommonEloHelper::get_table_row_where_arr('mc_booking_slots_on_dates', array('on_date' => $week_day));

                            $localy_is_on = !empty($localy_date_on_row) ? '1' : '' ;

                            $the_day_is_off = ( !empty($globaly_is_off) || !empty($localy_is_off) ) && empty($localy_is_on) ? '1' : '' ;

                            ?>

                            <td class="{{ !empty($the_day_is_off) ? 'bg-danger' : '' }}">

                                <div class="row mb-2">

                                    <div class="col-md-12 text-right">

                                        <a href="javascript:;" class="btn btn-sm d-block btn-success manage-date-slots-trigger" data-date="{{ $week_day }}"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                                    </div>

                                </div>
                                
                                @php
                                
                                if(!empty($week_day_slots[$week_day_number])){

                                    foreach($week_day_slots[$week_day_number] as $day_slot){

                                        if( !in_array($day_slot['slot_start_time'], $week_date_slots_arr_column[$week_day]) ){

                                            @endphp

                                            <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                                {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                            </a>

                                            @php

                                        } // if( !in_array($day_slot['slot_start_time'], $week_date_slots_arr_column[$week_day]) )

                                    } // foreach($week_day_slots[$week_day_number] as $day_slot)

                                } else {

                                    @endphp
                                    
                                        <!-- <p class="text-center text-mute"> No slots </p> -->

                                    @php
                                
                                } // if(!empty($week_day_slots[$week_day_number]))

                                @endphp

                                <!-- Show local by date -->

                                @php
                                
                                if(!empty($week_date_slots[$week_day])){

                                    foreach($week_date_slots[$week_day] as $day_slot){

                                        if( empty($day_slot['is_deleted']) || $day_slot['is_deleted'] == 'N' ){

                                            @endphp

                                            <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                                {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                            </a>

                                            @php

                                        } // if( empty($day_slot['is_deleted']) || $day_slot['is_deleted'] == 'N' )

                                    } // foreach($week_date_slots[$week_day] as $day_slot)

                                } // if(!empty($week_date_slots[$week_day]))

                                @endphp

                            </td>

                            <?php

                        } // foreach($data_arr['week_list'] as $key => $week_day)
                    } // if($data_arr['week_list'])
                    
                    ?>

                </tr>

            </tbody>

        </table>

    </div>