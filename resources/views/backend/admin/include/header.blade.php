<div class="app-header header bg-primary top-header">
		<div class="container">
			<div class="d-flex">
				<a class="header-brand text-left" href="#">

					<img src="{{URL::asset("assets/images/brand/logo-white.png")}}" class="header-brand-img desktop-lgo" alt="doctor 123">
					{{--					<img src="{{URL::asset("assets/images/brand/logo1.png")}}" class="header-brand-img dark-logo" alt="doctor 123">--}}
										<!--<img src="assets/images/brand/favicon-white.png" class="header-brand-img mobile-logo" alt="Dashtic logo">-->
					{{--					<img src="{{URL::asset("assets/images/brand/favicon1.png")}}" class="header-brand-img darkmobile-logo" alt="doctor 123">--}}
				</a>
				<a id="horizontal-navtoggle" class="animated-arrow hor-toggle text-white"><span class="text-white"></span></a>
				<!-- sidebar-toggle-->

				<div class="d-flex order-lg-2 ml-auto">

					<div class="dropdown profile-dropdown">
						<a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">

                            @if(Auth::user()->profile_image != null)
	                            <span>

	                                <img src="{{asset('storage/profile/'.Auth::user()->profile_image)}}" alt="img" class="avatar avatar-md brround" />
	                            </span>
                            @else
								<span>
									<img src="{{URL::asset("assets/images/users/noimage.jpg")}}" alt="img" class="avatar avatar-md brround">
								</span>
                            @endif()
						</a>
						<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated">
							<div class="text-center">
								<a href="#" class="dropdown-item text-center user pb-0 font-weight-bold">
                                    @auth()
                                    {{ ucwords(Auth::user()->first_name) }} {{ ucwords(Auth::user()->last_name) }}
                                    @endauth
                                </a>
								{{-- <span class="text-center user-semi-title">{{Auth::user()->userType->title}}</span> --}}
								<div class="dropdown-divider"></div>
							</div>
				       		<a class="dropdown-item d-flex" href="{{url('edit-profile')}}">

								<div class="mt-1"><i class="fa fa-user mr-2"></i>Profile</div>
							</a>
							<a class="dropdown-item d-flex" href="{{url('/change-password')}}">

								<div class="mt-1"><i class="fa fa-user mr-2"></i>Change Password</div>
							</a>

							<a class="dropdown-item d-flex" href="{{url('/logout')}}">
								<div class="mt-1"><i class="fa fa-cogs mr-2"></i>Sign Out</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
