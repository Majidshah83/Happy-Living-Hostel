@extends('backend.admin.master')
@section('title', 'Staffs')
@section('content')

<!-- Start app-content-->
<div class="app-content page-body">
    <div class="container">

        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Staff</h4>
            </div>
            <div class="page-rightheader ml-auto d-lg-flex d-none">
                <a href="javascript:;" class="btn btn-primary add-edit-staff" data-target="#modaldemo3" data-hash-id="" data-toggle="modal"><i class="fa fa-plus mr-2"></i>Add New Staff</a>

            </div>
        </div>
        <!--End Page header-->
        @include('backend.admin.components.messages')
        <!--Row-->


        <!--Row-->
        <?php $full_path = env('MEDIA_PATH_HTTP');?>
        <div class="row row-deck">

            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List Staff</h3>
                        <div class="card-options">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="staff-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr class="bold">
                                        <th class="border-bottom-0" width="5%">ID </th>
                                        <th class="border-bottom-0">Staff Details</th>
                                        <th class="border-bottom-0" width="12%">Role</th>
                                        <th class="border-bottom-0" width="13%">Status</th>
                                        <th class="text-center border-bottom-0" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(count($users) > 0)
                                @foreach($users as $key=>$user)
                                <tr>
                                    <td class="font-weight-bold">{{++$key}}</td>
                                    <td>
                                        <p><a href=""><strong>
                                            {{ucwords($user->first_name)}}  {{ucwords($user->last_name)}} @if(!empty($user->professional_title))({{$user->professional_title}})
                                                @endif</strong></a>
                                        </p>
                                        <p>@if(!empty($user->reg_no)) GPhC No - {{$user->reg_no}} @endif</p>
                                    </td>
                                    <td>{{$user->role}}</td>
                                    <td>

                                       @include('backend.admin.components.status', ['item_details' => !empty($user) ? $user : '' , 'resource' => 'users' ])

                                    </td>
                                    <td>
                                        <button type="button" title="edit" class="btn btn-success btn-sm add-edit-staff" data-hash-id="{{ $user->hash_id }}"><i class="fa fa-edit"></i></button>
                                        <button title="change password" class="btn btn-danger btn-sm" onclick="openModal({{$user}});"><i class="fa fa-lock"></i></button>
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
                        <div class="alert alert-danger" id="error">
                            <!-- Contain Dynamic Errors -->
                            <ul class="mb-0" id="crud_errors_ul1"></ul>
                        </div>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="save_changes" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>
</div><!-- end app-content-->
</div>


@endsection()
@section('scripts')
<script type="text/javascript">
        function openModal(data) {
             $("#error").hide();
            document.getElementById('action-modal-title').innerText = 'Change Password'
            $('#data').val(data.hash_id);
            $('#openModal').modal('show');
        }

    $(document).ready(function() {
        $("#error").hide();
        $('.add-edit-staff').click(function(){


            var hash_id = $(this).attr('data-hash-id');

            var request_url = (hash_id != '') ? 'staffs/'+hash_id+'/edit' : 'staffs/create' ;

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

                        popup_title = 'Add New Staff';

                    } else {

                        popup_title = 'Edit Staff';

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

        }); // click => .add-edit-staff

        $('#save_changes').click(function(e) {
            e.preventDefault();
            updatePassword()
        });

        $('#staff-datatable').DataTable();
    });

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
                    url: "{{ url('update-statff-password') }}",
                    type: "POST",
                    data: {hash_id: data, password: password, password_confirmation: password_confirmation},
                    success: function (response) {
                        location.reload()
                    },
                    error: function (xhr, status, error) {
                        $("#error").show();
                        $("#save_changes").removeAttr("disabled");
                        $('#save_changes').html('Save changes');
                        $.each(xhr.responseJSON.errors, function(key, item) {
                        // alert(item);
                        var new_html = '<li> '+ item +' </li>';
                        $('#crud_errors_ul1').append(new_html);
                        });
                    }
                });
            }
     };
</script>
@endsection()
