@extends('backend.admin.master')
@section('title', 'Patients')
@section('content')
    <!-- Start app-content-->
    <div class="app-content page-body">
        <div class="container">

            <!--Page header-->
            <div class="page-header">
                <div class="page-leftheader">
                    <h4 class="page-title">Patients</h4>
                </div>
                <div class="page-rightheader ml-auto d-lg-flex d-none">
                    <a href="javascript:;" class="btn btn-primary add-edit-patient" data-hash-id="" data-target="#patientModal" data-toggle="modal"> <i class="fa fa-plus mr-1"></i>Add New Patient</a>
                </div>
            </div>
            <!--End Page header-->
            @include('backend.admin.components.messages')
            <p id="validation-errors"></p>
            <!--Row-->


            <!--Row-->
            <div class="row row-deck">

                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Patients</h3>
                            <div class="card-options">
                                <!-- <a href="" title="print list" class="btn btn-light"><i class="fa fa-print" aria-hidden="true"></i></a> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="patient-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                    <thead>
                                    <tr class="bold">
                                        <th class="border-bottom-0" width="5%">ID </th>
                                        <th class="border-bottom-0">Patient Details</th>
                                        <th class="border-bottom-0" width="12%">Passport No.</th>
                                        <th class="border-bottom-0" width="12%">Country</th>
                                        <th class="border-bottom-0" width="10%">Reg Date</th>
                                        <th class="text-center border-bottom-0" width="10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($patients) > 0)
                                            @foreach($patients as $key => $patient)
                                                <tr>
                                                    <td class="font-weight-bold text-center">
                                                        <p>{{++$key}}</p>
                                                        @if($patient->is_verified)
                                                            <a href="#" onclick="openModalVerified({{$patient}})"><span  class="badge badge-success "><i class="fa fa-check mr-1"></i>verified</span></a>
                                                        @else
                                                            <a href="#" onclick="openModalVerified({{$patient}})" ><span class="badge badge-danger "><i class="fa fa-times mr-1"></i>verified</span></a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a  data-container="body" data-html="true"
                                                            data-content="
    														<ul>
    															@if($patient->gender)<li><strong>Gender: </strong> {{ucwords($patient->gender)}}</li>@endif()
    															@if($patient->dob)<li><strong>D.O.B: </strong> {{$patient->dob}}</li>@endif()
    															@if($patient->mobile_no)<li><strong>Phone: </strong> {{$patient->mobile_no}}</li>@endif()
                                                                @if($patient->email)<li><strong>Email: </strong> {{$patient->email}}</li>@endif()
    														</ul>
    														" data-placement="top" data-popover-color="head-primary"  title="" data-original-title="{{ucwords($patient->first_name)}}  {{ucwords($patient->last_name)}}"><strong>{{ucwords($patient->first_name)}}  {{ucwords($patient->last_name)}}</strong></a>

                                                        <p>{!! addressWithComma($patient) !!}</p>
                                                    </td>
                                                    <td>{{ !empty($patient->passport_number) ? $patient->passport_number : '' }}</td>
                                                    <td>{{ !empty($patient->country->title) ? $patient->country->title : '' }}</td>
                                                    <td>{{$patient->created_at->format('d/m/y h:m A')}}</td>

                                                    <td>
                                                        <button title="edit" class="btn btn-success btn-sm add-edit-patient"  data-hash-id="{{ $patient->hash_id }}"><i class="fa fa-edit"></i></button>
                                                        <button title="change password" class="btn btn-danger btn-sm" onclick="openModal({{$patient}});"><i class="fa fa-lock"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No records found</td>
                                            </tr>
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
    </div><!-- end app-content-->
    </div>

    <!-- Page Modal -->
    <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="normalmodal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="action-modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="POST" id="action_form">
                    <div class="modal-body">

                        @csrf
                        <div class="row" id="password_row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">New Password <span class="text-red">*</span></label>
                                    <input type="password" id="password" class="form-control" name="password">
                                    <span class="text-danger error-text password_err"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Confirm New Password <span class="text-red">*</span></label>
                                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
                                    <span class="text-danger error-text password_confirmation_err"></span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="data">
                        <input type="hidden" id="verify">
                        <div class="col-md-6" id="is_verified_row">
                            <div class="form-group">
                                <div class="mt-5">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="is_verified_in" id="is_verified_in" value="0"> <span class="custom-control-label">Is Verified?</span> </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="reason_row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="mt-5">
                                        <label class="form-label">Reason</label>
                                        <textarea rows="4" class="form-control" id="reason_in" placeholder="Reason"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="save_changes" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection()

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#is_verified_in').click(function () {
                if ($(this).is(':checked')) {
                    $(this).attr('value', 1);
                } else {
                    $(this).attr('value', 0);
                }
                console.log($('#is_verified_in').val())
                $('#reason_row').toggle();
            });
            $('.add-edit-patient').click(function () {


                var hash_id = $(this).attr('data-hash-id');

                var request_url = (hash_id != '') ? 'patients/' + hash_id + '/edit' : 'patients/create';

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

                    beforeSend: function (result) {

                        // $("#loading").css("display","block");

                        $('#crud_errors_div').addClass('d-none');
                        $('#crud_errors_ul').html('');

                    },
                    success: function (response) {

                        // $("#loading").css("display","none");

                        // swal(response);

                        var popup_title = '';

                        if (hash_id == '') {

                            popup_title = 'Add New Patient';

                        } else {

                            popup_title = 'Edit Patient';

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

            }); // click => .add-edit-banner
            $('#save_changes').click(function(e) {
                e.preventDefault();
                var check_verify = $('#verify').val();
                if (parseInt(check_verify) === 0) {
                    updatePassword()
                } else {
                    updateVerification()
                }
            });
            $('#patient-datatable').DataTable();

        });

        function openModal(data) {
            $('#password_row').show();
            $('#reason_row').hide();
            $('#is_verified_row').hide();
            document.getElementById('action-modal-title').innerText = 'Change Password'
            $('#data').val(data.hash_id);
            $('#verify').val(0);
            $('#openModal').modal('show');
        }
        function updatePassword(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var data = $('#data').val();
            var password = $('#password').val();
            var password_confirmation = $('#password_confirmation').val();
            if (data.length > 0) {
                $("#save_changes").attr("disabled", true);
                $('#save_changes').html('Loading..');
                $.ajax({
                    url: "{{ url('update-patient-password') }}",
                    type: "POST",
                    data: {hash_id: data, password: password, password_confirmation: password_confirmation},
                    success: function (response) {
                        location.reload()
                        // if (!response.error) {
                        //     $(`#validation-errors`).html(`<div class="alert alert-success">${response.msg}</div>`);
                        //     ajaxAlertHide()
                        // } else {
                        //     $(`#validation-errors`).html(`<div class="alert alert-success">${response.msg}</div>`);
                        //     ajaxAlertHide()
                        // }
                    },
                    error: function (err) {
                        $("#save_changes").removeAttr("disabled");
                        $('#save_changes').html('Save changes');
                        printErrorMsg(err.responseJSON);
                    }
                });
            }
        };
        function updateVerification(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var data = $('#data').val();
            var is_verified_in = $('#is_verified_in').val();
            var reason_in = $('#reason_in').val();
            if (data.length > 0) {
                $("#save_changes").attr("disabled", true);
                $('#save_changes').html('Loading..');
                $.ajax({
                    url: "{{ url('update-patient-verification') }}",
                    type: "POST",
                    data: {hash_id: data, is_verified_in: is_verified_in, reason_in: reason_in},
                    success: function (response) {
                        location.reload()
                        // if (!response.error) {
                        //     $(`#validation-errors`).html(`<div class="alert alert-success">${response.msg}</div>`);
                        //     ajaxAlertHide()
                        // } else {
                        //     $(`#validation-errors`).html(`<div class="alert alert-success">${response.msg}</div>`);
                        //     ajaxAlertHide()
                        // }
                    },
                    error: function (err) {
                        $("#save_changes").removeAttr("disabled");
                        $('#save_changes').html('Save changes');
                        printErrorMsg(err.responseJSON);
                    }
                });
            }
        };
        function ajaxAlertHide() {
            $("#save_changes").removeAttr("disabled");
            $('#save_changes').html('Save changes');
            $('#openModal').modal('hide');
            setTimeout(function (){
                $(`#validation-errors`).text('')
            }, 2000)
        }
        function openModalVerified(data) {
            $('#reason_row').hide();
            $('#data').val(data.hash_id);
            $('#verify').val(1);
            $('#password_row').hide();
            $('#is_verified_row').show();
            $("#is_verified_in").val(data.is_verified);
            if (parseInt(data.is_verified) === 1) {
                $("#is_verified_in").prop("checked", true );
                $("#is_verified_in").val(1);
                $("#reason_row").show();
                $("#reason_in").show(data.reason);
            } else {
                $("#is_verified_in").val(0);
                $("#is_verified_in").prop("checked", false);
            }
            document.getElementById('action-modal-title').innerText = 'Verification Reason'
            $('#reason_in').text(data.reason)

            $('#openModal').modal('show');
        }
        function printErrorMsg (msg) {
            $.each( msg.errors, function( key, value ) {
                console.log(key);
                $('.'+key+'_err').text(value);
            });
        }
    </script>

@endsection()
