<!-- Jquery js-->
<script src="{{asset('assets/js/vendors/jquery-3.5.1.min.js')}}"></script>


<!-- Bootstrap4 js-->
<script src="{{ asset('assets/plugins/bootstrap/popper.min.js')}}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

<!--Othercharts js-->
<script src="{{ asset('assets/plugins/othercharts/jquery.sparkline.min.js')}}"></script>

<!-- Circle-progress js-->
<script src="{{ asset('assets/js/vendors/circle-progress.min.js')}}"></script>

<!-- Jquery-rating js-->
<script src="{{ asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>

<!--Horizontal js-->
<script src="{{ asset('assets/plugins/horizontal-menu/horizontal.js')}}"></script>

<!-- ECharts js -->
<script src="{{ asset('assets/plugins/echarts/echarts.js')}}"></script>

<!-- Peitychart js-->
<script src="{{ asset('assets/plugins/peitychart/jquery.peity.min.js')}}"></script>
<script src="{{ asset('assets/plugins/peitychart/peitychart.init.js')}}"></script>

<!-- Apexchart js-->
<script src="{{ asset('assets/js/apexcharts.js')}}"></script>

<!--Moment js-->
<script src="{{ asset('assets/plugins/moment/moment.js')}}"></script>

<!-- Daterangepicker js-->
<script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{ asset('assets/js/daterange.js')}}"></script>

<!---jvectormap js-->
<script src="{{ asset('assets/plugins/jvectormap/jquery.vmap.js')}}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery.vmap.world.js')}}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery.vmap.sampledata.js')}}"></script>

<!-- P-scroll js-->
<script src="{{ asset('assets/plugins/p-scrollbar/p-scrollbar.js')}}"></script>

<!-- Index js-->
<script src="{{ asset('assets/js/index1.js')}}"></script>

<!-- Data tables js-->
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/js/datatables.js')}}"></script>

<!--Counters -->
<script src="{{ asset('assets/plugins/counters/counterup.min.js')}}"></script>
<script src="{{ asset('assets/plugins/counters/waypoints.min.js')}}"></script>

<!--Chart js -->
<script src="{{ asset('assets/plugins/chart/chart.bundle.js')}}"></script>
<script src="{{ asset('assets/plugins/chart/utils.js')}}"></script>

<!---Tabs js-->
<script src="{{ asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
<script src="{{ asset('assets/js/tabs.js')}}"></script>

<!--File-Uploads Js-->
<script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>

<!-- File uploads js -->
<script src="{{ asset('assets/plugins/fileupload/js/dropify.js')}}"></script>
<script src="{{ asset('assets/js/filupload.js')}}"></script>

<!-- Treeview js -->
<script src="{{ asset('assets/plugins/treeview/treeview.js')}}"></script>

<!-- Accordion js-->
<script src="{{ asset('assets/plugins/accordion/accordion.min.js')}}"></script>
<script src="{{ asset('assets/plugins/notify/js/jquery.growl.js')}}"></script>
<script src="{{ asset('assets/plugins/notify/js/sample.js')}}"></script>
<script src="{{ asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{ asset('assets/js/accordion.js')}}"></script>
<!-- Custom js-->
<script src="{{ asset('assets/js/custom.js')}}"></script>


<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js" integrity="sha512-MqEDqB7me8klOYxXXQlB4LaNf9V9S0+sG1i8LtPOYmHqICuEZ9ZLbyV3qIfADg2UJcLyCm4fawNiFvnYbcBJ1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset('assets/js/mc_scripts/common_crud.js')}}"></script>

<script type="text/javascript">

	$(document).ready(function(){

		$('.change-display-order').change(function(){

			var item_id = $(this).attr('mc-item-id');
            var crud_name = $(this).attr('mc-crud-name');
            var display_order = $(this).val();

            swal({

                title: "Are you sure?",
                text: "Are you sure you want to change display order for this record?",
                type: "warning",
                
                showCancelButton: true,
                cancelButtonText: "No",
                cancelButtonClass: "btn-danger",

                confirmButtonClass: "btn btn-success",
                confirmButtonText: "Yes",
                closeOnConfirm: false

            },
            function(inputValue) {

                if (inputValue===false) {
                    
                    location.reload();

                } else {

                    $.ajax({

                        type: "POST",
                        url: "{{ route('common_change_order') }}",
                        data: {
                            'item_id': item_id,
                            'display_order': display_order,
                            'crud_name' : crud_name
                        },

                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        beforeSend: function(result) {
                            
                            // $("#overlay").removeClass("hidden");
                            // $("#loading").css("display","block");
                       
                        },

                        success: function(response) {

                            location.reload();

                        },
                        error: function(request, status, error) {
                            
                        }


                    }); // $.ajax

                } // if (inputValue===false)

            });

		}); // change => .change-display-order

        $(document).on('change', '.change-status', function(){

            var item_id = $(this).attr('mc-item-id');
            var crud_name = $(this).attr('mc-crud-name');
            var status = $(this).val();

            swal({

                title: "Are you sure?",
                text: "Are you sure you want to change status for this record?",
                
                type: "warning",
                
                showCancelButton: true,
                cancelButtonText: "No",
                cancelButtonClass: "btn-danger",

                confirmButtonClass: "btn btn-success",
                confirmButtonText: "Yes",
                closeOnConfirm: false

            },
            function(inputValue) {

                if (inputValue===false) {
                    
                    location.reload();

                } else {
                    
                    $.ajax({

                        type: "POST",
                        
                        url: "{{ route('common_status') }}",

                        data: {
                            'item_id': item_id,
                            'status': status,
                            'crud_name' : crud_name
                        },

                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        beforeSend: function(result) {
                            
                            // $("#overlay").removeClass("hidden");
                            // $("#loading").css("display","block");
                       
                        },

                        success: function(response) {

                            location.reload();

                        },
                        error: function(request, status, error) {
                           
                        }


                    }); // $.ajax

                }

            });

        }); // change => .change-status

	}); // ready

</script>
