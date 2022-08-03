
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
                                                        
                                                        <input type="checkbox" class="custom-switch-input week-day-switch" id="mon_day_onn_off_switch" name="week_day_onn_off_switch" value="1" {{ !empty($week_day_on_off_status['1']) ? '' : 'checked="checked"' }} />
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

                    <td class="{{ !empty($week_day_on_off_status['1']) ? 'bg-danger' : '' }}">

                        <div class="row mb-2">

                            <div class="col-md-12 text-right">

                                <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="1"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                            </div>

                        </div>
                        
                        @php
                        
                        if(!empty($week_day_slots[1])){

                            foreach($week_day_slots[1] as $day_slot){

                                @endphp

                                <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                    {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                </a>

                                @php

                            } // foreach($week_day_slots[1] as $day_slot)

                        } else {

                            @endphp
                            
                                <p class="text-center text-mute"> No slots </p>

                            @php
                        
                        } // if(!empty($week_day_slots[1]))

                        @endphp

                    </td>

                    <td class="{{ !empty($week_day_on_off_status['2']) ? 'bg-danger' : '' }}">

                        <div class="row mb-2">

                            <div class="col-md-12 text-right">

                                <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="2"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                            </div>

                        </div>
                        
                        @php
                        
                        if(!empty($week_day_slots[2])){

                            foreach($week_day_slots[2] as $day_slot){

                                @endphp

                                <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                    {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                </a>

                                @php

                            } // foreach($week_day_slots[2] as $day_slot)

                        } else {

                            @endphp
                            
                                <p class="text-center text-mute"> No slots </p>

                            @php
                        
                        } // if(!empty($week_day_slots[2]))

                        @endphp

                    </td>

                    <td class="{{ !empty($week_day_on_off_status['3']) ? 'bg-danger' : '' }}">

                        <div class="row mb-2">

                            <div class="col-md-12 text-right">

                                <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="3"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                            </div>

                        </div>
                        
                        @php
                        
                        if(!empty($week_day_slots[3])){

                            foreach($week_day_slots[3] as $day_slot){

                                @endphp

                                <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                    {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                </a>

                                @php

                            } // foreach($week_day_slots[3] as $day_slot)

                        } else {

                            @endphp
                            
                                <p class="text-center text-mute"> No slots </p>

                            @php
                        
                        } // if(!empty($week_day_slots[3]))

                        @endphp

                    </td>

                    <td class="{{ !empty($week_day_on_off_status['4']) ? 'bg-danger' : '' }}">

                        <div class="row mb-2">

                            <div class="col-md-12 text-right">

                                <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="4"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                            </div>

                        </div>
                        
                        @php
                        
                        if(!empty($week_day_slots[4])){

                            foreach($week_day_slots[4] as $day_slot){

                                @endphp

                                <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                    {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                </a>

                                @php

                            } // foreach($week_day_slots[4] as $day_slot)

                        } else {

                            @endphp
                            
                                <p class="text-center text-mute"> No slots </p>

                            @php
                        
                        } // if(!empty($week_day_slots[4]))

                        @endphp

                    </td>

                    <td class="{{ !empty($week_day_on_off_status['5']) ? 'bg-danger' : '' }}">

                        <div class="row mb-2">

                            <div class="col-md-12 text-right">

                                <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="5"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                            </div>

                        </div>
                        
                        @php
                        
                        if(!empty($week_day_slots[5])){

                            foreach($week_day_slots[5] as $day_slot){

                                @endphp

                                <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                    {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                </a>

                                @php

                            } // foreach($week_day_slots[5] as $day_slot)

                        } else {

                            @endphp
                            
                                <p class="text-center text-mute"> No slots </p>

                            @php
                        
                        } // if(!empty($week_day_slots[5]))

                        @endphp

                    </td>

                    <td class="{{ !empty($week_day_on_off_status['6']) ? 'bg-danger' : '' }}">

                        <div class="row mb-2">

                            <div class="col-md-12 text-right">

                                <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="6"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                            </div>

                        </div>
                        
                        @php
                        
                        if(!empty($week_day_slots[6])){

                            foreach($week_day_slots[6] as $day_slot){

                                @endphp

                                <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                    {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                </a>

                                @php

                            } // foreach($week_day_slots[6] as $day_slot)

                        } else {

                            @endphp
                            
                                <p class="text-center text-mute"> No slots </p>

                            @php
                        
                        } // if(!empty($week_day_slots[6]))

                        @endphp

                    </td>

                    <td class="{{ !empty($week_day_on_off_status['7']) ? 'bg-danger' : '' }}">

                        <div class="row mb-2">

                            <div class="col-md-12 text-right">

                                <a href="javascript:;" class="btn btn-sm d-block btn-success manage-day-slots-trigger" data-day-number="7"> <i class="fa fa-clock-o mr-1"></i> Manage Slots </a>

                            </div>

                        </div>
                        
                        @php
                        
                        if(!empty($week_day_slots[7])){

                            foreach($week_day_slots[7] as $day_slot){

                                @endphp

                                <a href="#" class="btn btn-sm d-block btn-default mb-1">

                                    {{ date('g:i a', strtotime($day_slot['slot_start_time'])) }}

                                </a>

                                @php

                            } // foreach($week_day_slots[7] as $day_slot)

                        } else {

                            @endphp
                            
                                <p class="text-center text-mute"> No slots </p>

                            @php
                        
                        } // if(!empty($week_day_slots[7]))

                        @endphp

                    </td>
                    
                </tr>

            </tbody>

        </table>

    </div>