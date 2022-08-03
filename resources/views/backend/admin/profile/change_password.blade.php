@extends('backend.admin.master')

@section('title', 'Change Password')
@section('content')

    <!-- Start app-content-->
    <div class="app-content page-body">
        <div class="container">

            <!--Page header-->
            <div class="page-header">
                <div class="page-leftheader">
                    <h4 class="page-title">Change Password</h4>
                </div>
                <div class="page-rightheader ml-auto d-lg-flex d-none">

                </div>
            </div>
            <!--End Page header-->

            <!--Row-->

            <div class="row">
                <div class="col-md-3 col-lg-3 col-xl-3" >
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Menu</h3>
                            <div class="card-options">

                            </div>
                        </div>
                        @include('backend.admin.components.profile_left_nav')
                    </div>
                </div>
                <div class="col-md-9 col-lg-9 col-xl-9">
                    <!--Row-->
                    @include('backend.admin.components.messages')
                    <div class="row row-deck">
                        <div class="col-xl-12 col-lg-12 col-md-12 mx-auto">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Change your password</h3>
                                    <div class="card-options">

                                    </div>
                                </div>
                                <div class="card-body">

                                    <form method="POST" action ="{{url('update-password')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="" class="form-label">
                                                        New Password
                                                    </label>
                                                    <input type="password" class="form-control" id="" name="password" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="" class="form-label">Confirm New Password</label>
                                                    <input type="password" class="form-control" id="" name="password_confirmation" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary mt-4 mb-0">Submit</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--End row-->

                 {{--    <!--Row-->
                    <div class="row row-deck">

                        <div class="col-xl-12 col-lg-12 col-md-12 mx-auto">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Change Email Address</h3>
                                    <div class="card-options">

                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action ="{{url('update-email')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="" class="form-label">
                                                        Email Address
                                                    </label>
                                                    <input type="email" value="{{ Auth::user()->email }}" class="form-control" name="email" required/>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary mt-4 mb-0">Submit</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--End row--> --}}
                </div>
            </div>

        </div>
    </div><!-- end app-content-->
    </div>


@endsection()
@section('scripts')

@endsection()
