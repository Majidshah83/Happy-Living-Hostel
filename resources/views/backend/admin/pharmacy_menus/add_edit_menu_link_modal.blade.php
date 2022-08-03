<form class="custom-validation" id="add-edit-menu-link-form">

    <!-- ERRORS Div -->
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

        <div class="col-lg-12">

            <div class="form-group">

                @php

                // Get active positions list
                
                $menu_parent_list = CommonEloHelper::get_table_result_where_arr_str('kod_menu_links', array('menu_id' => $menu_id, 'status' => '1'), ' parent_id IS NULL OR parent_id = "0" ', array('display_order' => 'ASC'));

                @endphp
                
                <label> Parent Category </label>
                <select class="form-control" id="parent_id" name="parent_id">

                    <option value=""> No Parent </option>

                    @if(count($menu_parent_list) > 0)

                        @foreach($menu_parent_list as $parent)

                            <option value="{{ $parent['id'] }}" {{ ( !empty($row_details) && $row_details->parent_id == $parent['id']) ? 'selected' : '' }}> {{ $parent['title'] }} </option>

                        @endforeach

                    @endif
                    
                </select>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="form-group">
                
                <label class="mr-5">
                    
                    <input type="radio" class="mr-1" id="reference_type_service" name="reference_type" value="SERVICE" {{ !empty($row_details) && $row_details['reference_type'] == 'SERVICE' ? 'checked="checked"' : '' }} />
                    Link A Service

                </label>

                <label class="mr-5">
                    
                    <input type="radio" class="mr-1" id="reference_type_page" name="reference_type" value="PAGE" {{ !empty($row_details) && $row_details['reference_type'] == 'PAGE' ? 'checked="checked"' : '' }} />
                    Link A Page

                </label>

                <label class="mr-5">
                    
                    <input type="radio" class="mr-1" id="reference_type_static_page" name="reference_type" value="STATIC_PAGE" {{ !empty($row_details) && $row_details['reference_type'] == 'STATIC_PAGE' ? 'checked="checked"' : '' }} />
                    Link A Static Page

                </label>

                <label>
                    
                    <input type="radio" class="mr-1" id="reference_type_url" name="reference_type" value="URL" {{ !empty($row_details) && $row_details['reference_type'] == 'URL' ? 'checked="checked"' : '' }} />
                    External URL

                </label>

            </div>
            
        </div>

    </div>

    <!-- Services Dropdown -->
    <div class="row {{ !empty($row_details) && $row_details['reference_type'] == 'SERVICE' ? '' : 'd-none' }}" id="services_dropdown_div">

        <div class="col-md-12">

            <div class="form-group">

                <select class="form-control" id="service_id" name="service_id" required="required">
                    
                    <option value=""> Select a service </option>

                    @php

                    // Get active services list
                    
                    $active_services_list = CommonEloHelper::get_table_result_where_arr('kod_services', array( 'status' => '1'), array('display_order' => 'ASC'));

                    @endphp

                    @if(count($active_services_list) > 0)

                        @foreach($active_services_list as $service)

                            <option value="{{ $service['id'] }}" {{ ( !empty($row_details) && $row_details->reference_id == $service['id']) ? 'selected' : '' }}> {{ $service['title'] }} </option>

                        @endforeach

                    @endif

                </select>

            </div>

        </div>

    </div>

    <!-- Pages Dropdown -->
    <div class="row {{ !empty($row_details) && $row_details['reference_type'] == 'PAGE' ? '' : 'd-none' }}" id="pages_dropdown_div">

        <div class="col-md-12">

            <div class="form-group">

                <select class="form-control" id="page_id" name="page_id" required="required">
                    
                    <option value=""> Select a page </option>

                    @php

                    // Get active pages list
                    
                    $active_pages_list = CommonEloHelper::get_table_result_where_arr('kod_pages', array('status' => '1'));

                    @endphp

                    @if(count($active_pages_list) > 0)

                        @foreach($active_pages_list as $page)

                            <option value="{{ $page['id'] }}" {{ ( !empty($row_details) && $row_details->reference_id == $page['id']) ? 'selected' : '' }}> {{ $page['title'] }} </option>

                        @endforeach

                    @endif

                </select>

            </div>

        </div>

    </div>

    <!-- Static Pages Dropdown -->
    <div class="row {{ !empty($row_details) && $row_details['reference_type'] == 'STATIC_PAGE' ? '' : 'd-none' }}" id="static_pages_dropdown_div">

        <div class="col-md-12">

            <div class="form-group">

                <select class="form-control" id="static_page_id" name="static_page_id" required="required">
                    
                    <option value=""> Select a static page </option>

                    @php

                    // Get active static pages list
                    
                    $active_static_pages_list = CommonEloHelper::get_table_result_where_arr('kod_static_pages', array('status' => '1'), array('display_order' => 'ASC'));
                    
                    @endphp

                    @if(count($active_static_pages_list) > 0)

                        @foreach($active_static_pages_list as $static_page)

                            <option value="{{ $static_page['id'] }}" {{ ( !empty($row_details) && $row_details->reference_id == $static_page['id']) ? 'selected' : '' }}> {{ $static_page['title'] }} </option>

                        @endforeach

                    @endif

                </select>

            </div>

        </div>

    </div>

    <!-- URL -->
    <div class="row {{ !empty($row_details) && $row_details['reference_type'] == 'URL' ? '' : 'd-none' }}" id="url_div">

        <div class="col-md-12">

            <div class="form-group">

                <input type="text" class="form-control" id="reference_url" name="reference_url" placeholder="Enter URL" value="{{ !empty($row_details) && !empty($row_details['reference_url']) ? $row_details['reference_url'] : '' }}" />

            </div>

        </div>

        <div class="col-md-12">

            <div class="form-group">

                <label>

                    <input type="checkbox" class="mr-1" id="new_tab" name="new_tab" {{ !empty($row_details) && $row_details['new_tab'] == '1' ? 'checked="checked"' : '' }} value="1" />
                    Open in new tab?

                </label>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-12">
            <div class="form-group">
                <label> Item Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="{{ !empty($row_details->title) ? $row_details->title : '' }}" required="required" />
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-6">

            <div class="form-group">
                <label> Display Order </label>
                <select class="form-control" id="display_order" name="display_order">
                            
                    @for ($i = 1; $i <= 50; $i++)

                        <option value="{{ $i }}" {{ ( !empty($row_details) && $row_details->display_order == $i) ? 'selected' : '' }}> {{ $i }} </option>

                    @endfor

                </select>
            </div>

        </div>

        <div class="col-lg-6">

            <div class="form-group">

                <label> Status </label>
                <select class="form-control" id="new_status" name="status">

                    <option value="1" {{ ( !empty($row_details) && $row_details->status =='1') ? 'selected' : '' }}>
                    Active </option>
                    
                    <option value="0" {{ ( !empty($row_details) && $row_details->status == '0') ? 'selected' : '' }}>
                    Inactive </option>

                </select>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-12">
            <div class="form-group mb-0">
                <div>
                <div class="bootstrap_loader" id="bootstrap_loader" style="display:none;">Loading</div>
                
                    <input type="hidden" name="menu_id" value="{{ $menu_id }}" readonly="readonly" />

                    <input type="hidden" name="pharmacy_id" value="{{ session()->get('pharmacy_id') }}" readonly="readonly" />
                    
                    <input type="hidden" name="row_id" value="{{ !empty($row_details) ? $row_details['id'] : '' }}" readonly="readonly" />

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

</form>

<script type="text/javascript">
    
    $(document).ready(function(){

        $('input[name="reference_type"]').change(function(){

            $('#title').val('');

            var reference_type = $(this).val();

            if(reference_type == 'SERVICE'){

                $('#services_dropdown_div').removeClass('d-none');
                $('#pages_dropdown_div').addClass('d-none');
                $('#static_pages_dropdown_div').addClass('d-none');
                $('#url_div').addClass('d-none');

            } else if(reference_type == 'PAGE'){

                $('#services_dropdown_div').addClass('d-none');
                $('#pages_dropdown_div').removeClass('d-none');
                $('#static_pages_dropdown_div').addClass('d-none');
                $('#url_div').addClass('d-none');
            
            } else if(reference_type == 'STATIC_PAGE'){

                $('#services_dropdown_div').addClass('d-none');
                $('#pages_dropdown_div').addClass('d-none');
                $('#static_pages_dropdown_div').removeClass('d-none');
                $('#url_div').addClass('d-none');

            } else if(reference_type == 'URL'){

                $('#services_dropdown_div').addClass('d-none');
                $('#pages_dropdown_div').addClass('d-none');
                $('#static_pages_dropdown_div').addClass('d-none');
                $('#url_div').removeClass('d-none');

            } // if(reference_type == 'SERVICE')

        }); // change => reference_type

    }); // ready

</script>

<script>
$(document).ready(function() {

    $("#mc_frm_submit_btn").click(function(event) {

        /*var is_valid = validate_add_edit_menu_link_form('add-edit-menu-link-form');
        if (is_valid == false) {
            return false;
        }*/

        event.preventDefault();

        var data = new FormData(document.getElementById("add-edit-menu-link-form"));
        
        $.ajax({

            type: "POST",
            url: "/pharmacy_menus/add_edit_menu_link_process",
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            data: data,
            beforeSend: function(result) {

                // $("#bootstrap_loader").css("display","block");

                $('#crud_errors_div').addClass('d-none');
                $('#crud_errors_ul').html('');

            },
            success: function(response) {

                $("#general_bootstrap_ajax_popup").modal('hide');
                    
                location.reload();

                $('#crud_errors_div').addClass('d-none');
                $('#crud_errors_ul').html('');

                // console.log(response);

            },

            error: function(xhr, status, error) {

                
                // $("#bootstrap_loader").css("display","none");

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

<script type="text/javascript">
    
    $(document).ready(function() {

        $('#service_id').change(function(){

            var table_name = 'kod_services';
            var item_id = $(this).val();

            var item_details = get_table_row(table_name, item_id);

            if( item_details != null ){

                $('#title').val(item_details.title);

            } else {
                $('#title').val('');
            } // if( item_details != null )

        }); // change => #service_id

        $('#page_id').change(function(){

            var table_name = 'kod_pages';
            var item_id = $(this).val();

            var item_details = get_table_row(table_name, item_id);

            if( item_details != null ){

                $('#title').val(item_details.title);

            } else {
                $('#title').val('');
            } // if( item_details != null )

        }); // change => #page_id

        $('#static_page_id').change(function(){

            var table_name = 'kod_static_pages';
            var item_id = $(this).val();

            var item_details = get_table_row(table_name, item_id);

            if( item_details != null ){

                $('#title').val(item_details.title);

            } else {
                $('#title').val('');
            } // if( item_details != null )

        }); // change => #static_page_id

    }); // ready

</script>