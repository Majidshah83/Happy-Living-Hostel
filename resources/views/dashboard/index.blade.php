@extends('backend.admin.master')
@section('title', 'Dashboard Section')
@section('style')
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />

    <style type="text/css">
        
        .datepicker {
            
            border: 1px solid #ddd;
            
            padding: 8px;

            z-index: 1100 !important; 

        }

    </style>

@stop
@section('content')

    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Dashboard</h4>
            </div>
            <div class="page-rightheader ml-auto d-lg-flex d-none">

                <form action="{{ route('print_all_bookings') }}" method="POST" id="filters_frm">

                    @csrf
                
                    <div class="form-group float-left mr-2">

                        <input type="text" class="form-control mc-datepicker" id="date_filter" name="date_filter" value="{{ date('d/m/Y') }}" readonly="readonly" />

                    </div>

                    <div class="form-group float-left mr-2">

                        <select class="form-control" id="status_filter" name="status_filter">
                            
                            <option {{ ($status == 'PENDING') ? 'selected' : '' }} value="PENDING"> Pending </option>
                            <option {{ ($status == 'COMPLETED') ? 'selected' : '' }} value="COMPLETED"> Completed </option>
                            <option {{ ($status == 'CANCELLED') ? 'selected' : '' }} value="CANCELLED"> Cancelled </option>

                        </select>

                    </div>

                    <div class="form-group float-right">

                        <button type="button" class="btn btn-warning" id="print_all_bookings_btn"> Print </button>

                    </div>

                </form>

            </div>
        </div>
        <!--End Page header-->
        <div class="row row-deck">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Orders</h3>
                        <div class="card-options">
                            <a href="" title="print list" class="btn btn-light"><i class="fa fa-print" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <div class="table-responsive">

                            <table id="mc-datatable" class="table table-bordered nowrap dataTable no-footer dtr-inline mc-datatable" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="datatable_info">
                                
                                <thead>
                                    <tr role="row">
                                        <th width="5%"> ID </th>
                                        <th> Patient Details </th>
                                        <th> Appointment Details </th>
                                        <th width="13%"> Booking Date </th>
                                        <th width="10%"> Status </th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @if(!empty($service_bookings))
                                        
                                        @foreach($service_bookings as $booking)

                                            <tr>
                                                
                                                <th scope="row"> {{ $booking['id'] }} </th>
                                                
                                                <td>

                                                    @php

                                                    $patient_details = CommonEloHelper::get_table_row('kod_patients', $booking['patient_id']);

                                                    @endphp

                                                    <strong>

                                                        {{ ucfirst($patient_details['first_name']) }}

                                                        {{ $patient_details['last_name'] }}

                                                    </strong>

                                                    <br />

                                                    {{ $patient_details['address'] }}, {{ $patient_details['town_city'] }}, {{ $patient_details['postcode'] }}

                                                    <br />

                                                    T:
                                                    <a href="tel:{{ $patient_details['mobile_number'] }}">
                                                        {{ $patient_details['mobile_number'] }}
                                                    </a>

                                                    <br />

                                                    E:
                                                    <a href="mailto:{{ $patient_details['email'] }}">
                                                        {{ $patient_details['email'] }}
                                                    </a>

                                                </td>

                                                <td>

                                                    @php

                                                    $service_details = CommonEloHelper::get_table_row('kod_services', $booking['service_id']);

                                                    @endphp

                                                    <strong>

                                                        {{ $service_details['title'] }}

                                                    </strong>

                                                    <br />

                                                    {{ date('d/m/Y', strtotime($booking['slot_date'])) }}

                                                    {{ date('g:i A', strtotime($booking['slot_start_time'])) }}

                                                    <br />

                                                    Price:
                                                    <strong> &pound;{{ $service_details['price'] }} </strong>

                                                </td>

                                                <td>
                                                    
                                                    {{ date('d/m/Y', strtotime($booking['created_at'])) }}

                                                </td>

                                                <td>

                                                    @if($booking['booking_status'] == 'PENDING')

                                                        Pending

                                                    @elseif($booking['booking_status'] == 'CANCELLED')

                                                        Cancelled

                                                    @elseif($booking['booking_status'] == 'COMPLETED')

                                                        Completed

                                                    @endif

                                                    <br />

                                                    <a href="javascript:;" class="btn btn-sm btn-success btn-block booking-process" data-booking-id="{{ $booking['id'] }}"> Process </a>

                                                    @if(!empty($booking['reason_for_visit']))

                                                        <a href="javascript:;" class="btn btn-sm btn-warning btn-block view-note" data-booking-id="{{ $booking['id'] }}"> Note </a>

                                                    @endif

                                                    <a href="javascript:;" class="btn btn-sm btn-danger btn-block delete-booking" data-booking-id="{{ $booking['id'] }}"> Delete </a>


                                                    
                                                </td>

                                            </tr>

                                        @endforeach

                                    @endif

                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--End row-->
    </div>

@stop
@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

    <script type="text/javascript">
        
        $(document).ready(function(){

            $('#mc-datatable').DataTable();

            $('.mc-datepicker').datepicker({
                
                format: 'dd/mm/yyyy',
                // startDate: new Date(),
                autoclose: true

            }).on('changeDate', function(e) {
                
                // $('#filters_frm')[0].submit();

            });

            $('#print_all_bookings_btn').click(function(){

                $('#filters_frm')[0].submit();

            }); // click => #print_all_bookings_btn

            $('.view-note').click(function(){

                var booking_id = $(this).attr('data-booking-id');

                $.ajax({

                    type: "POST",
                    
                    url: "{{ route('view_note') }}",
                    
                    // processData: false,
                    // contentType: false,
                    
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    data: {

                        'booking_id' : booking_id,

                    },

                    beforeSend: function(result) {
                        
                        $("#loading").css("display","block");

                        $('#crud_errors_div').addClass('d-none');
                        $('#crud_errors_ul').html('');

                    },
                    success: function(response) {
                        
                        $("#loading").css("display","none");

                        // swal(response);

                        var popup_title = 'Booking Note';

                        $('#mc-popup-dialog').addClass('modal-md');

                        // Set Heading
                        $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                        // Set Body
                        $('#crud_contents').html(response);

                        // Set Footer
                        $('#general_bootstrap_ajax_popup_footer').prepend('');

                        $('#general_bootstrap_ajax_popup').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                    } // success

                }); // $.ajax

            }); // $('#full_calendar_div').on('click', '.add-new-inhouse-booking', function()

            $('#status_filter').change(function(){

                var status = $(this).val();

                location.href = "/status/"+status;

            }); // change => #status_filter

            $('.booking-process').click(function(){

                var booking_id = $(this).attr('data-booking-id');

                $.ajax({

                    type: "POST",
                    
                    url: "{{ route('booking_process') }}",
                    
                    // processData: false,
                    // contentType: false,
                    
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    data: {

                        'booking_id' : booking_id,

                    },

                    beforeSend: function(result) {
                        
                        $("#loading").css("display","block");

                        $('#crud_errors_div').addClass('d-none');
                        $('#crud_errors_ul').html('');

                    },
                    success: function(response) {
                        
                        $("#loading").css("display","none");

                        // swal(response);

                        var popup_title = 'Booking Process';

                        $('#mc-popup-dialog').addClass('modal-lg');

                        // Set Heading
                        $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                        // Set Body
                        $('#crud_contents').html(response);

                        // Set Footer
                        $('#general_bootstrap_ajax_popup_footer').prepend('');

                        $('#general_bootstrap_ajax_popup').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                    } // success

                }); // $.ajax

            }); // $('#full_calendar_div').on('click', '.add-new-inhouse-booking', function()

            $(document).on('click', '.delete-booking', function() {

                var _this = this;

                var booking_id = $(_this).attr('data-booking-id');

                swal(

                    {

                        title: "Are you sure?",
                        text: "Are you sure you want to delete this booking?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false

                    },

                    function() {

                        $.ajax({

                            type: "POST",

                            url: "{{ route('delete_booking_process') }}",
                            // processData: false,
                            // contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            data: {

                                'booking_id' : booking_id

                            },
                            
                            beforeSend: function(result) {
                                
                                $("#loading").css("display","block");
                                
                            },
                            success: function(response) {

                                $("#loading").css("display","none");

                                location.reload();

                            },

                            error: function(xhr, status, error) {

                                $.each(xhr.responseJSON.errors, function(key, item) {
                                    // mc_notify('danger', item);
                                });
                            }

                        }); // $.ajax

                    } // function()

                ); // swal

            }); // 

        }); // ready

    </script>

@stop