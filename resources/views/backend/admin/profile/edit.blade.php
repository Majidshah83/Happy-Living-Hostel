@extends('backend.admin.master')

@section('title', 'Update Profile')
@section('content')


    <!-- Start app-content-->
    <div class="app-content page-body">
        <div class="container">

            <!--Page header-->
            <div class="page-header">
                <div class="page-leftheader">
                    <h4 class="page-title">Edit Profile</h4>
                </div>
                <div class="page-rightheader ml-auto d-lg-flex d-none">

                </div>
            </div>
            <!--End Page header-->

            <!--Row-->


            <!--Row-->
            <!-- Row -->
            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-3" >
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Menu</h3>
                            <div class="card-options">

                            </div>
                        </div>
                        @include('backend.admin.components.profile_left_nav')
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    @include('backend.admin.components.messages')
                    <div class="card">
                    <div class="card-header">
                        <div class="card-title">Edit Profile</div>
                    </div>
                    <form method="POST" id="info" action ="{{url('update-profile-info')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">First Name <span class="text-red">*</span></label>
                                                <input type="text" name="first_name" value="{{Auth::user()->first_name}}" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Last Name <span class="text-red">*</span></label>
                                                <input type="text" name="last_name" class="form-control" value="{{Auth::user()->last_name}}" >
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Email <span class="text-red">*</span></label>
                                                <input type="text" name="email" class="form-control" value="{{Auth::user()->email}}" >
                                            </div>
                                        </div>
                                        <?php $full_path = env('MEDIA_PATH_HTTP');?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-label">Upload profile image</div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="profile_image">
                                                    <label class="custom-file-label">Choose file</label>
                                                    <input type="hidden" class="form-control" id="image" name="old_image" value="{{Auth::user()->profile_image}}" >
                                                </div>
                                            </div>
                                            <div class="imagepreview mt-3 mb-3" id="imagepreview_profile">
                                                @if(Auth::user()->profile_image != null)
                                                    <img id="edit_profile_image" width="130px" src="{{asset('storage/profile/'.Auth::user()->profile_image)}}"/>
                                                    <label class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" name="profile_check"> <span class="custom-control-label">Check to remove this image</span> </label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                <button class="btn btn-lg btn-primary" type="submit">Updated</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Row-->
            <!--End row-->

        </div>
    </div><!-- end app-content-->
    </div>


@endsection()
@section('scripts')

    <script>
        $(function () {
            $('#user_type_id').change(function () {
                var no = $('#user_type_id').val();
                if (parseInt(no) === 1) {
                    $('#allow_no').text('GMC')
                } else if (parseInt(no) === 3) {
                    $('#allow_no').text('NMC')
                } else if (parseInt(no) === 6) {
                    $('#allow_no').text('Reg No')
                } else {
                    $('#allow_no').text('GPhC')
                }
            });
            var no = $('#user_type_id').val();
            if (parseInt(no) === 1) {
                $('#allow_no').text('GMC')
            } else if (parseInt(no) === 3) {
                $('#allow_no').text('NMC')
            } else if (parseInt(no) === 6) {
                $('#allow_no').text('Reg No')
            } else {
                $('#allow_no').text('GPhC')
            }
        });
        $('info').submit(function(){
            $(this).children('input[type=submit]').prop('disabled', true);
        });
    </script>

@endsection()
