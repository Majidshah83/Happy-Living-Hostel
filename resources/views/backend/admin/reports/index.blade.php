@extends('backend.admin.master')
@section('title', 'Fee Section')
@section('content')
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Reports Fee</h4>
            </div>
        </div>
        <div class="row">

        </div>
        <!--Row-->
            @include('backend.admin.components.messages')
        <!--Row-->
        <!--End Page header-->
        <div class="row row-deck">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    @include('backend.admin.components.table_loader')
                    <div class="mc-cdt" id="mc-cdt" mc-url="reports/all"></div>
                </div>
            </div>
        </div>
        <!--End row-->
    </div>

    <!-- end app-content-->

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

        $(document).on('click', '.cdt_search', function() {

            // Set default page 1
            $('#mc-cdt').find('#cdt_pagination_page_no').val('1');

            var parent_id = $('#cdt_search').attr('mc-parent-id');

            refresh_cdt(parent_id);


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
    function refresh_cdt(parent_id = '', el = '') {

        var page = $('#' + parent_id).find('#cdt_pagination_page_no').val();
        page = (page == undefined) ? 1 : page ;

        // Get route URL
        var mc_url = $('#' + parent_id).attr('mc-url');

        // Get filter values
        var cdt_per_page = $('#' + parent_id).find('#cdt_per_page').val();
        var cdt_search = $('#' + parent_id).find('#cdt_search').val();
        cdt_per_page = (cdt_per_page == undefined) ? '' : cdt_per_page;
        cdt_search = (cdt_search == undefined) ? '' : cdt_search;

        // New filters
        var status = $('#status').val();
        status = (status == undefined) ? '' : status;

        var month = $('#month').val();
        month = (month == undefined) ? '' : month;

        var year = $('#year').val();
        year = (year == undefined) ? '' : year;

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
                'page' : page,

                // New
                'status' : status,
                'month' : month,
                'year' : year,
            },

            beforeSend: function(result) {

                $(".table-spinner").removeClass('d-none');
                // $("#loading").css("display", "block");
                $('#' + parent_id).html('');

            },
            success: function(response) {
                $(".table-spinner").addClass('d-none');
                // $("#loading").css("display", "none");
                $('#' + parent_id).html(response.html_data);


            } // success

        }); // $.ajax

    } // function refresh_cdt()

</script>

@stop

