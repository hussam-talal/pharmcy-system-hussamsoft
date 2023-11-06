<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<div class="sidebar">
		@yield('logo')
	   <!-- Sidebar Menu -->
	   <nav class="mt-2">
		  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			
			 <li class="nav-item has-treeview {{ request()->is('treasuries*')|| request()->is('adminpanelsetting*')||request()->is('users_accounts*')||request()->is('roles*') ?'menu-open':'' }}  ">
				<a href="#" class="nav-link ">
				   <i class="nav-icon fas fa-lock"></i>
				   <p>
					   الإدارة
					  <i class="right fas fa-angle-left"></i>
				   </p>
				</a>
				<ul class="nav nav-treeview">
					@can('الضبط العام')
				   <li class="nav-item">
					  <a href="{{ route('adminPanelSetting.index') }}" class="nav-link {{ (request()->is('adminpanelsetting*') )?'active':'' }}">
						 <p>الضبط العام</p>
					  </a>
				   </li>
				   @endcan
				   <li class="nav-item">
					  <a href="{{ route('treasuries.index') }}" class="nav-link {{ (request()->is('treasuries*') )?'active':'' }}">
						 <p>بيانات الخزن</p>
					  </a>
				   </li>
				   @can('عرض مستخدم')
				   <li class="nav-item ">
					<a href="" class="nav-link ">
					   <p>
						   المستخدمين 
						   <i class="right fas fa-angle-left"></i>       
					   </p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
						   <a href="{{ route('users_accounts.index') }}" class="nav-link {{ request()->is('users_accounts*')|| request()->is('users*') ?'active':'' }}">
							  <p>
								مستخدمين         
							  </p>
						   </a>
						</li>
						<li class="nav-item">
							<a href="{{ route('roles.index') }}" class="nav-link {{request()->is('roles*')?'active':'' }}">
							   <p>
								 الصلاحيات         
							   </p>
							</a>
						 </li>
					 </ul>
			 </li>
			 @endcan
			</ul>

			 </li>
			 <li class="nav-item has-treeview {{ request()->is('accounts*')|| request()->is('customer*')||request()->is('supplier*')||request()->is('collect_transaction*')||request()->is('exchange_transaction*') ?'menu-open':'' }} ">
				<a href="#" class="nav-link ">
				   <i class="nav-icon fas fa-money-check"></i>
				   <p>
					  الحسابات
					  <i class="right fas fa-angle-left"></i>
				   </p>
				</a>
				<ul class="nav nav-treeview">
			
				   <li class="nav-item">
					  <a href="{{route('accounts.index')}}" class="nav-link {{ request()->is('accounts*') ?'active':'' }}">
						 <p>
							 بيانات الحسابات المالية         
						 </p>
					  </a>
				   <li class="nav-item">
					  <a href="{{route('customer.index')}}" class="nav-link {{request()->is('customer*') ?'active':'' }}">
						 <p>
							حسابات العملاء         
						 </p>
					  </a>
				   </li>
				   <li class="nav-item">
					  <a href="{{route('supplier.index')}}" class="nav-link {{request()->is('supplier*') ?'active':'' }} ">
						 <p>
							حسابات الموردين         
						 </p>
					  </a>
				   </li>
				   <li class="nav-item">
					  <a href="{{ route('collect_transaction.index') }}" class="nav-link {{request()->is('collect_transaction*') ?'active':'' }} ">
						 <p>
							 تحصيل النقدية         
						 </p>
					  </a>
				   </li>
				   <li class="nav-item">
					  <a href="{{ route('exchange_transaction.index') }}" class="nav-link {{request()->is('exchange_transaction*') ?'active':'' }} ">
						 <p>
							 صرف النقدية         
						 </p>
					  </a>
				   </li>
				</ul>
			 </li>
			 <li class="nav-item has-treeview {{ request()->is('items*')|| request()->is('alternatives*') ?'menu-open':'' }} ">
				<a href="#" class="nav-link ">
				   <i class="nav-icon fas fa-tablets"></i>
				   <p>
					الأصناف
					  <i class="right fas fa-angle-left"></i>
				   </p>
				</a>
				<ul class="nav nav-treeview">
				   <li class="nav-item">
					  <a href="{{route('items.index')}}" class="nav-link {{request()->is('items*') ?'active':'' }}">
						 <p>
							الأصناف         
						 </p>
					  </a>
				   </li>
				   <li class="nav-item">
					  <a href="{{route('alternatives.index')}}" class="nav-link {{request()->is('alternatives*') ?'active':'' }} ">
						 <p>
							الاصناف البديلة
						 </p>
					  </a>
				   </li>
				</ul>
			 </li>
			 <li class="nav-item has-treeview {{ request()->is('purchases*')|| request()->is('purchasesreturn*') ?'menu-open':'' }} ">
				<a href="#" class="nav-link ">
				   <i class="nav-icon fas fa-star"></i>
				   <p>
					  المشتريات
					  <i class="right fas fa-angle-left"></i>
				   </p>
				</a>
				<ul class="nav nav-treeview">
				   <li class="nav-item">
					  <a href="{{route('purchases.index')}}" class="nav-link {{request()->is('purchases*') ?'active':'' }}">
						 <p>
							فواتير المشتريات         
						 </p>
					  </a>
				   </li>
				   <li class="nav-item">
					  <a href="{{route('purchasesreturn.index')}}" class="nav-link {{request()->is('purchasesreturn*') ?'active':'' }} ">
						 <p>
							فواتير مرتجع المشتريات          
						 </p>
					  </a>
				   </li>
				</ul>
			 </li>
			 <li class="nav-item has-treeview {{ request()->is('stores*')|| request()->is('stores_inventory*') ?'menu-open':'' }} ">
				<a href="#" class="nav-link ">
				   <i class="nav-icon fas fa-store"></i>
				   <p>
					   المخازن
					  <i class="right fas fa-angle-left"></i>
				   </p>
				</a>
				<ul class="nav nav-treeview">
					
				 <li class="nav-item">
					<a href="{{ route('stores.index') }}" class="nav-link{{request()->is('stores*') ?'active':'' }} ">
					   <p>
						  بيانات المخازن         
					   </p>
					</a>
				 </li>
				 <li class="nav-item">
					<a href="{{ route('stores_inventory.index') }}" class="nav-link {{request()->is('stores_inventory*') ?'active':'' }}">
					   <p>
						  جردالمخازن         
					   </p>
					</a>
				 </li>
				</ul>
			 </li>
			 @can('عرض مبيعات')
			 <li class="nav-item has-treeview {{ request()->is('SalesInvoices*') ?'menu-open':'' }}">
				<a href="#" class="nav-link ">
				   <i class="nav-icon fas fa-chart-line"></i>
				   <p>
					  المبيعات
					  <i class="right fas fa-angle-left"></i>
				   </p>
				</a>
				<ul class="nav nav-treeview">
				   <li class="nav-item">
					  <a href="{{route('SalesInvoices.index')}}" class="nav-link {{request()->is('SalesInvoices*') ?'active':'' }}">
						 <p>
							فواتير المبيعات         
						 </p>
					  </a>
				   </li>
				   
				</ul>
			 </li>
			 @endcan
			 <li class="nav-item has-treeview  ">
				<a href="#" class="nav-link ">
				   <i class="nav-icon fas fa-book"></i>
				   <p>
					  التقارير
					  <i class="right fas fa-angle-left"></i>
				   </p>
				</a>
				<ul class="nav nav-treeview">
					 @can('عرض تقرير') 
				   <li class="nav-item">
					  <a href="{{route('repsuppliers.index')}}" class="nav-link ">
						 <p>
							كشف حساب مورد        
						 </p>
					  </a>
				   </li>
  
				   <li class="nav-item">
					<a href="{{route('repcustomers.index')}}" class="nav-link ">
					   <p>
						  كشف حساب عميل        
					   </p>
					</a>
				 </li>
				 @endcan
				</ul>
			 </li>
			 <li class="nav-item">
				<a href="{{route('support.index')}}" class="nav-link "><i class="nav-icon fas fa-home"></i>
					  الدعم الفني
				</a>
				
			 </li>
		  </ul>
	   </nav>
	   <!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
  </aside>