<div class="horizontal-main hor-menu clearfix">
	<div class="horizontal-mainwrapper container clearfix">
		<nav class="horizontalMenu clearfix">
			<ul class="horizontalMenu-list">
				<li aria-haspopup="true">
					<a href="{{url('/dashboard')}}" class="sub-icon">
						<i class="fa fa-tachometer"></i>Dashboard
					</a>
				</li>
                @if('Admin' == \Illuminate\Support\Facades\Auth::user()->role)
                   
                    <li aria-haspopup="true">
                        <a href="#" class="sub-icon">
                            <i class="fa fa-users"></i> Room Setup <i class="fa fa-angle-down horizontal-icon"></i>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{url('/floors')}}">Floors</a></li>
                            <li><a href="{{url('/rooms')}}">Rooms</a></li>
                        </ul>
                    </li>

                    <li aria-haspopup="true">
                        <a href="#" class="sub-icon">
                            <i class="fa fa-user"></i> Customer Section <i class="fa fa-angle-down horizontal-icon"></i>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{url('/check-in-student')}}">Check In Customer</a></li>
                            <li><a href="{{url('/check-out-student')}}">Check Out Customer</a></li>
                        </ul>
                    </li>

                    <li aria-haspopup="true">
                        <a href="{{url('/student-fee')}}" class="sub-icon">
                            <i class="fa fa-users"></i>Fee Section 
                        </a>
                    </li>
                    <li aria-haspopup="true">
                        <a href="{{url('/reports')}}" class="sub-icon">
                            <i class="fa fa-print"></i>Reports
                        </a>
                    </li>
                    <li aria-haspopup="true">
                        <a href="{{url('/expense')}}" class="sub-icon">
                            <i class="fa fa-print"></i>Expense
                        </a>
                    </li>
                    <li aria-haspopup="true">
                        <a href="{{url('/users')}}" class="sub-icon">
                            <i class="fa fa-users"></i>Users
                        </a>
                    </li>
                  <li aria-haspopup="true">
                        <a href="{{url('/page-sections')}}" class="sub-icon">
                            <i class="fa fa-users"></i>Content Section
                        </a>
                    </li>

                @endif
			</ul>
		</nav>
		<!--Nav end -->
	</div>
</div>
