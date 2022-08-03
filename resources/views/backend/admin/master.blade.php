<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Dashtic - Bootstrap Webapp Responsive Dashboard Simple Admin Panel Premium HTML5 Template" name="description">
		<meta content="Tech developer™ Tech developers Ltd" name="Zee">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="keywords">
		<!-- Title -->
		<title>@yield('title')</title>
		@include('backend.admin.include.style')
		@yield('style')
        <style>
              #loader {
                  display: none;
                  position: fixed;
                  top: 0;
                  left: 0;
                  right: 0;
                  bottom: 0;
                  width: 100%;
                  background: rgba(0,0,0,0.75) url({{URL::asset('assets/loading2.gif')}}) no-repeat center center;
                  z-index: 80000;
              }
        </style>
	</head>

	<body class="light-mode">
		<!---Global-loader-->
        <div id="loader"></div>
        {{--        <div id="global-loader" >--}}
        {{--			<img src="{{URL::asset('assets/images/svgs/loader.svg')}}" alt="loader">--}}
        {{--		</div>--}}
		<div class="page">
			<div class="page-main">
				<!--app header-->
	    		@include('backend.admin.include.header')
				<!--/app header-->
				<!-- Horizontal-menu -->
				@include('backend.admin.include.navbar')
				<!-- Horizontal-menu end -->
				<!-- Start app-content-->
				<div class="app-content page-body">
				@yield('content')
				</div>
				<!-- end app-content-->
			</div>
			<!-- The General_bootstrap_ajax_popup -->
            <div class="modal" id="general_bootstrap_ajax_popup">
                <div class="modal-dialog" id="mc-popup-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h6 class="modal-title" id="general_bootstrap_ajax_popup_heading"></h6>
                            <button type="button" class="close general_bootstrap_ajax_popup_close_btn"
                                data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body" id="general_bootstrap_ajax_popup_body">

                            <div class="row d-none" id="crud_errors_div">

                                <div class="col-md-12">

                                    <div class="alert alert-danger">

                                        <!-- Contain Dynamic Errors -->
                                        <ul class="mb-0" id="crud_errors_ul"></ul>

                                        <!-- Contain Input File Errors -->
                                        <ul class="mb-0" id="file_error_ul"></ul>

                                    </div>

                                </div>

                            </div>

                            <!-- Contain Dynamic Contents -->
                            <div id="crud_contents"></div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- Delete POPUP -->
            <!-- The General_bootstrap_delete_popup -->
            <div class="modal" id="General_bootstrap_delete_popup">
                <div class="modal-dialog" id="mc-delete-popup-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h6 class="modal-title" id="General_bootstrap_delete_popup_heading"></h6>
                            <button type="button" class="close General_bootstrap_delete_popup_close_btn"
                                data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body" id="General_bootstrap_delete_popup_body">

                            <div class="row d-none" id="delete_crud_errors_div">

                                <div class="col-md-12">

                                    <div class="alert alert-danger">

                                        <!-- Contain Dynamic Errors -->
                                        <ul class="mb-0" id="delete_crud_errors_ul"></ul>

                                    </div>

                                </div>

                            </div>

                            <!-- Contain Dynamic Contents -->
                            <div id="General_bootstrap_delete_popup_contents"></div>

                        </div>

                        <div class="modal-footer">

                            <input type="hidden" id="General_bootstrap_delete_popup_hash_id" readonly="readonly" />

                            <button type="button" class="btn btn-success delete-item"> Yes </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

                        </div>

                    </div>
                </div>
            </div>

            <!-- Start Footer -->
			@include('backend.admin.include.footer')
			<!-- End Footer-->
			@include('backend.admin.include.alert_model')
		</div>
		<!-- Back to top -->
		<a href="#top" id="back-to-top">
			<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z"/></svg>
		</a>
		@include('backend.admin.include.script')
        @yield('scripts')

        <script>

            function globalError(msg = '', type = 'error'){
                notif({
                    type: type,
                    msg: msg,
                    position: "center",
                    width: 500,
                    height: 60,
                    autohide: true
                });
            }

            function mcShowErrorsGet(xhr, status, error){

                if (xhr.status === 500) {
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        globalError(item);
                    });
                }

            } // function mcShowErrors(xhr, status, error)

            function mcShowErrorsPost(xhr, status, error){

                if (xhr.status === 500) {

                    $.each(xhr.responseJSON.errors, function(key, item) {
                        globalError(item);
                    });

                }else{

                    $('#crud_errors_div').removeClass('d-none');

                    $.each(xhr.responseJSON.errors, function(key, item) {

                        // alert(item);
                        var new_html = '<li> '+ item +' </li>';
                        $('#crud_errors_ul').append(new_html);

                    });
                }

            } // function mcShowErrors(xhr, status, error)

            $("#alert-success").fadeTo(6000, 500).slideUp(900, function(){
                $("#alert-success").slideUp(500);
            });
            $("#alert-success-email").fadeTo(6000, 500).slideUp(900, function(){
                $("#alert-success-email").slideUp(500);
            });
            $("#alert-danger").fadeTo(6000, 500).slideUp(900, function(){
                $("#alert-danger").slideUp(500);
            });
            $("#alert-warn").fadeTo(6000, 500).slideUp(900, function(){
                $("#alert-warn").slideUp(500);
            });
            $("#alert-warn-email").fadeTo(6000, 500).slideUp(900, function(){
                $("#alert-warn-email").slideUp(500);
            });


        </script>

	</body>
</html>
