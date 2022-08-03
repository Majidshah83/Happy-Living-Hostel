@extends('backend.admin.master')
@section('title', 'Pharmacy Profile')
@section('style')
<style type="text/css" media="screen">
    .image_perview{
            height: 48px;
            width: 117px;
    }
    input:read-only, textarea:read-only {
      background-color: #ccc;
    }
</style>
@stop
@section('content')
<div class="app-content page-body">
    <div class="container">
         <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Edit Pharmacy</h4>
            </div>
            <div class="page-rightheader ml-auto d-lg-flex d-none">
            </div>
        </div>
        <!--End Page header-->
        <!--Row-->
        @include('backend.admin.components.messages')
        <!--Row-->
          <!-- Row -->
        <?php $full_path = env('MEDIA_PATH_HTTP');?>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                   <form method="post" action="{{url('pharmacy-profile/update')}}" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" value="{{Session::get('selected_tab')}}" id="get_selected_tab">
                    <input type="hidden" value="pharmacy_info" name="selected_tab" id="selected_tab">
                    <div class="card-body">
                        <div class="tab_wrapper first_tab">
                        <ul class="tab_list">
                            <li class="pharmacy_info" onclick="selectedTab('pharmacy_info')">
                             Pharmacy Info</li>
                            <li class="pharmacy_settings" onclick="selectedTab('pharmacy_settings')"> Pharmacy Settings</li>
                            <li onclick="selectedTab('opening_hours')" class="opening_hours"> Opening Hours</li>
                            <li class="social_media" onclick="selectedTab('social_media')">Social Media</li>
                            <li class="upload_media" onclick="selectedTab('upload_media')">Upload Media</li>
                        </ul>
                        <div class="content_wrapper">
                            <div class="tab_content active pharmacy_info" >
                                <div class="card-title font-weight-bold">Basic info:</div>
                                <div class="row">
                                   
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Pharmacy Name<span>*</span></label>
                                            <input type="text" name="pharmacy_name" @if($pharmacy_info) value="{{$pharmacy_info->pharmacy_name}}" @endif() class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Business Name</label>
                                            <input type="text" @if($pharmacy_info) value="{{$pharmacy_info->business_name}}" @endif() name="business_name" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Contact Number <small>(Primary)</small></label>
                                            <input type="text" name="contact_number_primary" @if($pharmacy_info) value="{{$pharmacy_info->contact_number_p}}"
                                            @endif class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Contact Number <small>(Secondary)</small></label>
                                            <input type="text" name="contact_number_secondary" @if($pharmacy_info) value="{{$pharmacy_info->contact_number_s}}"
                                            @endif class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label"> Email Address <small>(Primary)</small></label>
                                            <input type="text" name="email_address_primary" class="form-control" value="{{$pharmacy_info->email_address_primary}}" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Email Address <small>(Secondary)</small></label>
                                            <input type="text" name="email_address_secondary" class="form-control" 
                                            value="{{$pharmacy_info->email_address_secondary}}" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Mobile Number </label>
                                            <input type="text" @if($pharmacy_info) value="{{$pharmacy_info->mobile_number}}" @endif name="mobile_number" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Whats Number </label>
                                            <input type="text" name="whats_number" class="form-control" @if($pharmacy_info) value="{{$pharmacy_info->whats_number}}" @endif placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label"> Fax Number </label>
                                            <input type="text" name="fax_number" class="form-control" @if($pharmacy_info) value="{{$pharmacy_info->fax_number}}" @endif placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Company Number </label>
                                            <input type="text" name="company_number" class="form-control" @if($pharmacy_info) value="{{$pharmacy_info->company_number}}"
                                            @endif placeholder="">
                                        </div>
                                    </div>
                                
                                   <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">GPhC Reg Number </label>
                                            <input type="text" name="gphc_reg_number" class="form-control" @if($pharmacy_info) value="{{$pharmacy_info->gphc_reg_number}}"
                                            @endif placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">VAT Number </label>
                                            <input type="text" name="vat_number" class="form-control" @if($pharmacy_info) value="{{$pharmacy_info->vat_number}}" @endif placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Company  Register In</label>
                                            <input type="text" name="company_register_in" class="form-control" @if($pharmacy_info) value="{{$pharmacy_info->company_register_in}}"
                                            @endif placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Superintendent Pharmacist </label>
                                            <input type="text" name="superintendent_pharmacist" class="form-control" @if($pharmacy_info) value="{{$pharmacy_info->superintendent_pharmacist}}" @endif placeholder="">
                                        </div>
                                    </div>

                                </div>
                                <div class="card-title font-weight-bold">Pharmacy Address:</div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Address 1 </label>
                                            <input type="text" name="address_1" class="form-control" @if($pharmacy_info) value="{{$pharmacy_info->address_1}}" @endif placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Address 2 </label>
                                            <input type="text" name="address_2" class="form-control" @if($pharmacy_info) value="{{$pharmacy_info->address_2}}" @endif placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Address 3 </label>
                                            <input type="text" name="address_3" class="form-control" @if($pharmacy_info) value="{{$pharmacy_info->address_3}}" @endif placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">City/Town </label>
                                            <input type="text" name="city" class="form-control" @if($pharmacy_info) value="{{$pharmacy_info->city}}" @endif placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">County </label>
                                            <input type="text" name="county" class="form-control" @if($pharmacy_info) value="{{$pharmacy_info->county}}" @endif placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Postcode </label>
                                            <input type="text" name="post_code" class="form-control" @if($pharmacy_info) value="{{$pharmacy_info->post_code}}" @endif placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab_content pharmacy_settings">
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Meta Title </label>
                                            <input type="text" name="meta_title" @if($pharmacy_settings) value="{{$pharmacy_settings->meta_title}}" @endif class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Meta Keywords </label>
                                            <input type="text" name="meta_kewords" @if($pharmacy_settings) value="{{$pharmacy_settings->meta_title}}" @endif class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Meta Description </label>
                                            <textarea class="form-control" name="meta_description" cols="8">@if($pharmacy_settings) {{$pharmacy_settings->meta_description}} @endif</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label"> Recaptcha </label>
                                            <input type="text" name="recaptcha" @if($pharmacy_settings)
                                            value="{{$pharmacy_settings->recaptcha}}" @endif class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">NHS URl </label>
                                            <input type="text" name="nhs_url" @if($pharmacy_settings)
                                            value="{{$pharmacy_settings->nhs_url}}" @endif class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Script 1 </label>
                                            <textarea class="form-control" name="script_1" cols="8"> @if($pharmacy_settings) {{$pharmacy_settings->script_1}} @endif </textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Script 2 </label>
                                            <textarea class="form-control" name="script_2" cols="8">@if($pharmacy_settings){{$pharmacy_settings->script_2}} @endif </textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Script 3 </label>
                                            <textarea class="form-control" name="script_3" cols="8">@if($pharmacy_settings) {{$pharmacy_settings->script_3}} @endif </textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Script 4</label>
                                            <textarea class="form-control" name="script_4" cols="8">@if($pharmacy_settings) {{$pharmacy_settings->script_4}} @endif</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab_content opening_hours">
                            <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap mb-0">
                            <thead >
                                <tr>
                                    <th>Day</th>
                                    <th>Opening Time</th>
                                    <th>Closing Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Monday</th>
                                    <td><input type="text" class="mon" name="mon_open_time" @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->mon_open_time}}" @endif
                                    @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_mon_closed == 1) readonly @endif></td>
                                    <td><input type="text" class="mon" @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->mon_close_time}}" @endif name="mon_close_time"  @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_mon_closed == 1) readonly @endif></td>
                                    <td><input type="checkbox" class="closed_time" data-id="mon" name="is_mon_closed"  @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_mon_closed == 1) checked="true" @endif/> </td>
                                </tr>
                                <tr>
                                    <th scope="row">Tuesday</th>
                                    <td><input type="text" @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->tue_open_time}}" @endif name="tue_open_time" class="tue" @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_tue_closed == 1) readonly @endif></td>
                                    <td><input type="text"  @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->tue_close_time}}" @endif
                                        name="tue_close_time"
                                        class="tue"  @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_tue_closed == 1) readonly @endif></td>
                                    <td><input type="checkbox" name="is_tue_closed" id="is_tue_closed" class="closed_time" data-id="tue" @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_tue_closed == 1) checked="true" @endif /> </td>
                                </tr>
                                <tr>
                                    <th scope="row">Wednesday</th>
                                    <td><input type="text" @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->wed_open_time}}" @endif name="wed_open_time" class="wed"  @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_wed_closed == 1) readonly @endif></td>
                                    <td><input type="text"  @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->wed_close_time}}" @endif name="wed_close_time" class="wed"  @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_wed_closed == 1) readonly @endif></td>
                                    <td><input type="checkbox" class="closed_time" data-id="wed" name="is_wed_closed" id="is_wed_closed" @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_wed_closed == 1) checked="true" @endif/> </td>
                                </tr>
                                <tr>
                                    <th scope="row">Thursday</th>
                                    <td><input type="text" @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->thu_open_time}}" @endif name="thu_open_time" class="thu"  @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_thu_closed == 1) readonly @endif></td>
                                    <td><input type="text" @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->thu_close_time}}" @endif name="thu_close_time" class="thu"  @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_thu_closed == 1) readonly @endif></td>
                                    <td><input type="checkbox" class="closed_time" data-id="thu" name="is_thu_closed" id="is_thu_closed"  @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_thu_closed == 1) checked="true" @endif/> </td>
                                </tr>
                                <tr>
                                    <th scope="row">Friday</th>
                                    <td><input type="text" @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->fri_open_time}}" @endif name="fri_open_time" class="fri"  @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_fri_closed == 1) readonly @endif></td>
                                    <td><input type="text" @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->fri_close_time}}" @endif name="fri_close_time" class="fri"  @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_fri_closed == 1) readonly @endif></td>
                                    <td><input type="checkbox" name="is_fri_closed" id="is_fri_closed" class="closed_time" data-id="fri" @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_fri_closed == 1) checked="true" @endif/> </td>
                                </tr>
                                <tr>
                                    <th scope="row">Saturday</th>
                                    <td><input type="text" @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->sat_open_time}}" @endif name="sat_open_time" class="sat"  @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_sat_closed == 1) readonly @endif></td>
                                    <td><input type="text" @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->sat_close_time}}" @endif name="sat_close_time" class="sat"  @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_sat_closed == 1) readonly @endif></td>
                                    <td><input type="checkbox"  name="is_sat_closed" id="is_sat_closed" class="closed_time" data-id="sat" @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_sat_closed == 1) checked="true" @endif/> </td>
                                </tr>
                                <tr>
                                    <th scope="row">Sunday</th>
                                    <td><input type="text" @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->sun_open_time}}" @endif name="sun_open_time" class="sun"  @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_sun_closed == 1) readonly @endif></td>
                                    <td><input type="text" @if($pharmacy_opening_hour) value="{{$pharmacy_opening_hour->sun_close_time}}" @endif name="sun_close_time" class="sun" @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_sun_closed == 1) readonly @endif></td>
                                    <td><input type="checkbox" name="is_sun_closed" id="is_sun_closed" class="closed_time" data-id="sun" @if($pharmacy_opening_hour && $pharmacy_opening_hour->is_sun_closed == 1) checked="true" @endif/> </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                            </div>
                            <div class="tab_content social_media">
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Facebook URL </label>
                                            <input type="text" name="facebook_url" @if($pharmacy_info) value="{{$pharmacy_info->facebook_url}}" @endif  class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Instagram URL </label>
                                            <input type="text" name="instagram_url" @if($pharmacy_info)
                                            value="{{$pharmacy_info->instagram_url}}" @endif class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Twitter URL </label>
                                            <input type="text" class="form-control" name="twitter_url"
                                            @if($pharmacy_info) value="{{$pharmacy_info->twitter_url}}" @endif placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Linkedin URL </label>
                                            <input type="text" class="form-control" name="linkedin_url"
                                            @if($pharmacy_info) value="{{$pharmacy_info->linkedin_url}}" @endif placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Youtube URL </label>
                                            <input type="text" name="youtube_url" @if($pharmacy_info) value="{{$pharmacy_info->youtube_url}}" @endif class="form-control" placeholder="">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab_content upload_media">
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Upload Logo 1 </label>
                                            <input type="file" accept="image/png, image/jpeg" class="form-control" name="logo_1"/>
                                        </div>
                                    </div>
                                    @if($pharmacy_settings && $pharmacy_settings->logo_1 != null)
                                        <div class="col-sm-6 col-md-6">
                                            <div class="imagepreviewdiv">
                                                <img src="{{ $full_path.'pharmacyprofile/'.$pharmacy_settings->logo_1 }}" class="img-fluid image_perview"  />
                                            </div>
                                            <label><input type="checkbox" name="checkbox_logo_1"> Check to remove</label>
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Upload Logo 2 </label>
                                            <input type="file" class="form-control" name="logo_2" />
                                        </div>
                                    </div>
                                    @if($pharmacy_settings && $pharmacy_settings->logo_2 != null)
                                        <div class="col-sm-6 col-md-6">
                                            <div class="imagepreviewdiv">
                                              <img src="{{ $full_path.'pharmacyprofile/'.$pharmacy_settings->logo_2 }}" class="img-fluid image_perview"  />
                                            </div>
                                            <label><input type="checkbox" name="checkbox_logo_2"> Check to remove</label>
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Favicon </label>
                                            <input type="file" class="form-control" name="favicon"/>
                                        </div>
                                    </div>
                                    @if($pharmacy_settings && $pharmacy_settings->favicon != null)
                                        <div class="col-sm-6 col-md-6">
                                            <div class="imagepreviewdiv">
                                                 <img src="{{ $full_path.'pharmacyprofile/'.$pharmacy_settings->favicon }}" class="img-fluid image_perview"  />
                                            </div>
                                            <label><input type="checkbox" name="checkbox_favicon"> Check to remove</label>
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">NHS Logo </label>
                                            <input type="file" class="form-control"  name="nhs_logo"/>
                                        </div>
                                    </div>
                                    @if($pharmacy_settings && $pharmacy_settings->nhs_logo != null)
                                        <div class="col-sm-6 col-md-6">
                                            <div class="imagepreviewdiv">
                                                 <img src="{{ $full_path.'pharmacyprofile/'.$pharmacy_settings->nhs_logo }}" class="img-fluid image_perview"  />
                                            </div>
                                            <label><input type="checkbox" name="checkbox_nhs_logo"> Check to remove</label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-lg btn-primary">Updated</button>
                        <a href="#" class="btn btn-lg btn-danger">Cancle</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!-- End Row-->
        <!--End row-->
        </div>
    </div><!-- end app-content-->
    </div>
@stop
@section('scripts')

    <script type="text/javascript">

        function selectedTab(tab){
            document.getElementById('selected_tab').value = tab;
        }
        $(document).ready(function(){
            let selected_tab = $('#get_selected_tab').val();
            if(selected_tab){
              $("li."+selected_tab).click();
              $('li'+selected_tab).addClass('active');
            }
            $('.closed_time').change(function(){
              var days = $(this).attr('data-id');
              if( $(this).prop('checked') == true ){
                  $('.'+days).attr('readonly', true);
              } else {
                  $('.'+days).attr('readonly', false);
              } // if( $(this).prop('checked') == true )
             }); // change
        })

    </script>

@stop
