@extends('backend.admin.master')
@section('title', 'Profile')
@section('content')

    <div class="app-content page-body">
        <div class="container">

            <!--Page header-->
            <div class="page-header">
                <div class="page-leftheader">
                    <h4 class="page-title">Profile</h4>
                </div>
                <div class="page-rightheader ml-auto d-lg-flex d-none">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#" class="d-flex">
                                <span class="breadcrumb-icon"> Home</span></a></li>
                        <li class="breadcrumb-item"><a href="#">Profile</a></li>
                    </ol>
                </div>
            </div>
            <!--End Page header-->

            <!-- Row -->
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="card box-widget widget-user">
                        <div class="widget-user-image mx-auto mt-5 text-center">
                            <?php $full_path = env('MEDIA_PATH_HTTP');?>
                            @if(Auth::user()->profile_image != null)
                                <span>
                                <img src="{{ $full_path.'profile/'.Auth::user()->profile_image }}" width="130px" alt="User" class="rounded-circle" />
                            </span>
                            @else
                                <img alt="User Avatar" class="rounded-circle" src="{{URL::asset("assets/images/users/16.jpg")}}">
                            @endif()
                        </div>
                        <div class="card-body text-center">
                            <div class="pro-user">
                                <h4 class="pro-user-username text-dark mb-1 font-weight-bold">
                                    @auth()
                                        {{ ucwords(Auth::user()->first_name) }} {{ ucwords(Auth::user()->last_name) }}
                                    @endauth
                                </h4>
                                <h6 class="pro-user-desc text-muted">{{Auth::user()->userType->title}}</h6>
                                @if(Auth::user()->status)
                                <a href="#" class="btn btn-success btn-sm mt-3">Active</a>
                                @else
                                    <a href="#" class="btn btn-danger btn-sm mt-3">In Active</a>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer p-0">
                            <div class="row">
                                <div class="col-sm-6 border-right text-center">
                                    <div class="description-block p-4">
                                        <h5 class="description-header mb-1 font-weight-bold">689k</h5>
                                        <span class="text-muted">Completed</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="description-block text-center p-4">
                                        <h5 class="description-header mb-1 font-weight-bold">3,765</h5>
                                        <span class="text-muted">Pending</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Personal Details</h4>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <tbody>
                                    <tr>
                                        <td class="py-2 px-0">
                                            <span class="font-weight-semibold w-50">Profession </span>
                                        </td>
                                        <td class="py-2 px-0">{{Auth::user()->userType->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-0">
                                            <input type="hidden" value="{{Auth::user()->userType->title}}" id="prof">
                                            <span class="font-weight-semibold w-50" id="allow_no">GMC Number </span>
                                        </td>
                                        <td class="py-2 px-0">{{Auth::user()->reg_no}}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-0">
                                            <span class="font-weight-semibold w-50">Organisation </span>
                                        </td>
                                        <td class="py-2 px-0">Doctor 123</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-0">
                                            <span class="font-weight-semibold w-50">Address </span>
                                        </td>
                                        <td class="py-2 px-0">{{Auth::user()->address_1}}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-0">
                                            <span class="font-weight-semibold w-50">Email </span>
                                        </td>
                                        <td class="py-2 px-0">{{Auth::user()->email}}</td>
                                    </tr>
                                    @if(Auth::user()->contact_no)
                                    <tr>
                                        <td class="py-2 px-0">
                                            <span class="font-weight-semibold w-50">Phone </span>
                                        </td>
                                        <td class="py-2 px-0">{{Auth::user()->contact_no}}</td>
                                    </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-12">
                    <div class="main-content-body main-content-body-profile card mg-b-20">
                        <!-- main-profile-body -->
                        <div class="main-profile-body">
                            <div class="tab-content">
                                <div class="tab-pane show active" id="about">
                                    <div class="card-body">

                                        <h5 class="font-weight-bold">Biography</h5>
                                        <div class="main-profile-bio mb-0">
                                            <p>{!! Auth::user()->biography !!}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end app-content-->


@endsection()
@section('scripts')
<script>
    $(function () {
        var no = $('#prof').val();
        if (no === 'Doctor') {
            $('#allow_no').text('GMC')
        } else if (no === 'Nurse Prescriber') {
            $('#allow_no').text('NMC')
        } else if (no === 'Pharmacist Prescriber') {
            $('#allow_no').text('GPhC')
        } else {
            $('#allow_no').text('Reg No')
        }
    });
</script>
@endsection()
