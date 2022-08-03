<form class="custom-validation" id="manu-add-edit-form">

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
                <label>Menu Name <span class="text-danger">*</span> </label>
                <input name="title" id="title" type="text" class="form-control"
                    value="{{ !empty($row_details->title) ? $row_details->title : '' }}" required />
            </div>
        </div>


        <div class="col-lg-12">
            <div class="form-group">
                <label> Description </label>
                <textarea type="text" class="form-control" id="description" name="description" >{{ !empty($row_details->description) ? $row_details->description : '' }}</textarea>
            </div>
        </div>

        <div class="col-lg-12">

            <div class="form-group">
                
                <label> Menu Position <span class="text-danger">*</span> </label>
                <select class="form-control" id="position_id" name="position_id" required="required">

                    <option value=""> Select </option>

                    @php

                    // Get active positions list
                    $active_position_list = CommonEloHelper::get_table_result_where_arr('kod_menu_positions', array('status' => '1'), array('display_order' => 'ASC'));

                    @endphp

                    @if(count($active_position_list) > 0)

                        @foreach($active_position_list as $position)

                            <option value="{{ $position['id'] }}" {{ ( !empty($row_details) && $row_details->position_id == $position['id']) ? 'selected' : '' }}> {{ $position['title'] }} </option>

                        @endforeach

                    @endif
                    
                </select>

            </div>

        </div>

        <div class="col-lg-12">
            <div class="form-group">
                
                <label> Status </label>
                <select class="form-control" id="new_status" name="status">

                    <option value="1" {{ ( !empty($row_details) && $row_details->status == '1') ? 'selected' : '' }}>
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
                    
                    <input type="hidden" name="row_id" value="{{ !empty($row_details) ? $row_details['id'] : '' }}" />

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

<script>
$(document).ready(function() {

    $("#mc_frm_submit_btn").click(function(event) {    

        /*var is_valid = validate_add_edit_menu_form('manu-add-edit-form');
        if (is_valid == false) {
            return false;
        }*/

        event.preventDefault();

        var data = new FormData(document.getElementById("manu-add-edit-form"));
        
        $.ajax({

            type: "POST",
            url: "/pharmacy_menus/add_edit_menu_process",
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

                // $("#bootstrap_loader").css("display","none");
                
                $('#crud_errors_div').addClass('d-none');
                $('#crud_errors_ul').html('');

                $("#general_bootstrap_ajax_popup").modal('hide');
                    
                location.reload();

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

    // // var desc = editorData.setData({!! !empty($row_details) ? $row_details->description : '' !!});
    // var desc = editorData.setData('asdfasdfdas');


    $('#advanced_settings').change(function() {

        if ($(this).prop('checked') == true) {

            $('#advanced_settings_div').removeClass('d-none');

        } else {

            $('#advanced_settings_div').addClass('d-none');

        } // if( $(this).prop('checked') == true )

    }); // change => seo





});
</script>