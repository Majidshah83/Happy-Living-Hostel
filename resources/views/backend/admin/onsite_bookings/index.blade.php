@extends('backend.admin.master')
@section('title', 'Onsite Bookings')
@section('content')
	<div class="app-content page-body">
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Onsite Bookings</h4>
            </div>
        </div>
        <!--End Page header-->
        <!--Row-->
        <!--Row-->
        @include('backend.admin.components.messages')
        <!--Row-->
        <!--Row-->
        <div class="row row-deck">

            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List all the Onsite Bookings</h3>
                        <div class="card-options">

                        </div>
                    </div>
                    <div class="card-body">
                        
                        <!-- Data Table Div -->
                        <div class="mc-cdt" id="mc-cdt" mc-url="onsite-bookings/get_cdt"></div>

                    </div>
                </div>
            </div>

        </div>
        <!--End row-->
    </div>
</div><!-- end app-content-->
</div>

@stop

@section('scripts')

    <script type="text/javascript">
        
        $(document).ready(function() {

            $(document).on('change', '.cdt_per_page', function() {

                // Set default page 1
                $('#mc-cdt').find('#cdt_pagination_page_no').val('1');

                var parent_id = $(this).attr('mc-parent-id');

                refresh_cdt(parent_id);

            }); // $(document).on('change', '.cdt_per_page', function()

            $(document).on('keyup', '.cdt_search', function() {

                var search_str = $(this).val();

                if( search_str.length >= 3 ){

                    // Set default page 1
                    $('#mc-cdt').find('#cdt_pagination_page_no').val('1');

                    var parent_id = $(this).attr('mc-parent-id');
                    
                    refresh_cdt(parent_id);

                } // if( search_str.length >= 3 )

            }); // $(document).on('keyup', '.cdt_search', function()

            $(document).on('click', '.pagination a', function(e) {
                
                e.preventDefault();

                var parent_id = $(this).parent().parent().parent().parent().attr('mc-parent-id');
                
                var page = $(this).text();

                if(page == '‹'){

                    var old_page = $('#' + parent_id).find('#cdt_pagination_page_no').val();
                    page = parseInt(old_page) - parseInt(1);

                } // if(page == '‹')

                if(page == '›'){

                    var old_page = $('#' + parent_id).find('#cdt_pagination_page_no').val();
                    page = parseInt(old_page) + parseInt(1);

                } // if(page == '›')

                $('#' + parent_id).find('#cdt_pagination_page_no').val(page);

                refresh_cdt(parent_id);

            });

            refresh_cdt('mc-cdt');

        }); // $(document).ready(function()

        // Get datatable dynamic contents as per the selections
        function refresh_cdt(parent_id = '') {

            var page = $('#' + parent_id).find('#cdt_pagination_page_no').val();
            page = (page == undefined) ? 1 : page ;

            // Get route URL
            var mc_url = $('#' + parent_id).attr('mc-url');

            // Get filter values
            var cdt_per_page = $('#' + parent_id).find('#cdt_per_page').val();
            var cdt_search = $('#' + parent_id).find('#cdt_search').val();

            cdt_per_page = (cdt_per_page == undefined) ? '' : cdt_per_page;
            cdt_search = (cdt_search == undefined) ? '' : cdt_search;

            $.ajax({

                type: "POST",
                url: mc_url,
                // processData: false,
                // contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {

                    'cdt_per_page': cdt_per_page,
                    'cdt_search': cdt_search,
                    'page' : page
                },

                beforeSend: function(result) {

                    $("#loading").css("display", "block");
                    $('#' + parent_id).html('');

                },
                success: function(response) {

                    $("#loading").css("display", "none");
                    $('#' + parent_id).html(response);

                } // success

            }); // $.ajax

        } // function refresh_cdt()

    </script>

    <script type="text/javascript">

        $(document).ready(function(){

            $('#onsite-datetable').DataTable();

            $('.add-edit-page-section').click(function(){

                var hash_id = $(this).attr('data-hash-id');

                var request_url = (hash_id != '') ? 'page-sections/'+hash_id+'/edit' : 'page-sections/create' ;

                $.ajax({

                    type: "GET",


                    url: request_url,

                    // processData: false,
                    // contentType: false,

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    /*data: {

                        'hash_id' : hash_id,

                    },*/

                    beforeSend: function(result) {

                        // $("#loading").css("display","block");

                        $('#crud_errors_div').addClass('d-none');
                        $('#crud_errors_ul').html('');

                    },
                    success: function(response) {

                        // $("#loading").css("display","none");

                        // swal(response);

                        var popup_title = '';

                        if(hash_id == ''){

                            popup_title = 'Add New Page Section';

                        } else {

                            popup_title = 'Edit Page Section';

                        } // if(hash_id == '')

                        $('#mc-popup-dialog').addClass('modal-lg');

                        // Set Heading
                        $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                        // Set Body
                        $('#crud_contents').html(response);

                        // Set Footer
                        // $('#general_bootstrap_ajax_popup_footer').prepend('');

                        $('#general_bootstrap_ajax_popup').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                    }, // success
                    error: function(xhr, status, error) {

                        mcShowErrorsGet(xhr, status, error);

                    }

                }); // $.ajax

            }); // click => .add-edit-page-section

        });

    </script>
@stop
