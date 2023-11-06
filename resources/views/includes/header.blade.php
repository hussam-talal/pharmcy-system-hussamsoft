																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																		
		

		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			
			<ul class="navbar-nav ">
			  <li class="nav-item">
				<a class="nav-link text-white" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
			  <li class="nav-item d-none d-sm-inline-block ">
				<a href="{{ route('dashboard') }}" class="nav-link text-white">الرئيسية</a>
			  </li>
			  <li class="nav-item d-none d-sm-inline-block ">
				<a href="{{ route('logout') }}" class="nav-link text-white">تسجيل الخروج</a>
			  </li>
			</ul>
		
			<!-- SEARCH FORM -->
			<form class="form-inline ml-3" >
			  <div class="input-group input-group-sm">
				<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
				<div class="input-group-append">
				  <button class="btn btn-navbar" type="submit">
					<i class="fas fa-search"></i>
				  </button>
				</div>
			  </div>
			</form>
		
			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
			  <!-- Messages Dropdown Menu -->
			  
			  <!-- Notifications Dropdown Menu -->
			  <li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="#">
				  <i class="far fa-bell"></i>
				  <span class="badge badge-warning navbar-badge">
					{{Auth::user()->unreadNotifications->count()}}</span>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				  <span class="dropdown-header"> Notifications {{Auth::user()->unreadNotifications->count()}}</span>
				  @foreach (Auth::user()->unreadNotifications as $notification)
					  
				  <div class="dropdown-divider"></div>
				  <a href="#" class="dropdown-item "style="width:250px">
					<!-- Message Start -->
					<div class="media">
					  <div class="media-body">
						<h3 class="dropdown-item-title">
						{{$notification->data['item_card_name']}}
						  <span class="float-right text-sm text-muted"></span>
						</h3>
						<p class="text-sm">يتبقى على انتهاءه 30  </p>
						<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
					  </div>
					</div>
					<!-- Message End -->
				  </a>
				  @endforeach
				
				  <div class="dropdown-divider"></div>
				  <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
				</div>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
					class="fas fa-th-large"></i></a>
			  </li>

			  
			</li>
			</ul>
			<ul class="navbar-nav ">
			<li class="nav-item dropdown has-arrow">
				<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
					<span class="user-img"><img class="rounded-circle" src="{{asset('assets\images\انا.jpg')}}" width="31" alt="avatar"></span>
				</a>
				<div class="dropdown-menu">
					<div class="user-header">
						<div class="avatar avatar-sm">
							<img src="{{asset('assets\images\انا.jpg')}}" alt="User Image" class="avatar-img rounded-circle">
						</div>
						<div class="user-text">
							<h6>{{Auth::user()->name}}</h6>
						</div>
					</div>
					
					<a class="dropdown-item" href="{{ route ('users_accounts.index')}}">ملفي الشخصي</a>
					<a class="dropdown-item" href="{{ route ('adminPanelSetting.index')}}">الاعدادات</a>
					<a class="dropdown-item" href="{{ route('logout') }}">خروج</a>
				</div>
			</ul>
		  </nav>


	

