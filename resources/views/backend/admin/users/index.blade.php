@extends('backend.admin.master')
@section('title', 'Users')
@section('content')
<!-- Start app-content-->
<div class="app-content page-body">
    <div class="container">

        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Users</h4>
            </div>
            <div class="page-rightheader ml-auto d-lg-flex d-none">
                <a href="javascript:;" class="btn btn-primary add-edit-staff" data-target="#modaldemo3" data-hash-id="" data-toggle="modal"><i class="fa fa-plus mr-2"></i>Add New User</a>

            </div>
        </div>
        <!--End Page header-->
        @include('backend.admin.components.messages')
        <!--Row-->
        <div class="row row-deck">

            <div class="col-xl-12 col-lg-12 col-md-12 ">
                <div class="card">
                    <div class="card-header">

                        <div class="row w-100">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="staff-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                <thead>
                                <tr class="bold">
                                    <th class="border-bottom-0">Type</th>
                                    <th class="border-bottom-0">Full Name</th>
                                    <th class="border-bottom-0" width="13%">Email</th>
                                    <th class="border-bottom-0" width="13%">Status</th>
                                    <th class="text-center border-bottom-0" width="10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($users) > 0)
                                @foreach($users as $key=>$user)
                                <tr>
                                    <td>
                                        {{$user->role}}
                                    </td>
                                    <td>
                                        {{ucwords($user->first_name)}}
                                        {{ucwords($user->last_name)}}
                                    </td>
                                    <td>
                                            {{$user->email}}

                                    </td>
                                    <td>

                                        @include('backend.admin.components.status', ['item_details' => !empty($user) ? $user : '' , 'resource' => 'kod_users' ])

                                    </td>
                                    <td>

                                        <button type="button" title="edit" class="btn btn-success btn-sm add-edit-staff" data-hash-id="{{ $user->hash_id }}"><i class="fa fa-edit"></i></button>

                                        <button title="change password" class="btn btn-danger btn-sm change-password" data-hash-id="{{$user->hash_id}}"><i class="fa fa-lock"></i></button>

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


@endsection()
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $('.change-password').click(function(){

            var hash_id = $(this).attr('data-hash-id');

            var request_url = '{{url('/user-change-password')}}'+'/'+hash_id ;

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

                    var popup_title = '';

                    if(hash_id == ''){

                        popup_title = 'Change Password';

                    } else {

                        popup_title = 'Change Password';

                    } // if(hash_id == '')

                    $('#mc-popup-dialog').addClass('modal-md');

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

        });

        $('.add-edit-staff').click(function(){

            var hash_id = $(this).attr('data-hash-id');

            var request_url = (hash_id != '') ? 'users/'+hash_id+'/edit' : 'users/create' ;

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

                        popup_title = 'Add New User';

                    } else {

                        popup_title = 'Edit User';

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

        $('#staff-datatable').DataTable();
    });
</script>
@endsection()
