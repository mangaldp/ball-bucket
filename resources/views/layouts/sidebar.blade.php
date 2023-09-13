            <!-- Main Sidebar Container -->
			<aside class="main-sidebar sidebar-dark-primary elevation-4">
				<!-- Brand Logo -->
				<a href="#" class="brand-link">
					<img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
					<span class="brand-text font-weight-light">{{ config('app.name', 'Ball Bucket') }}</span>
				</a>
				<!-- Sidebar -->
				<div class="sidebar">
					<!-- Sidebar user (optional) -->
					<nav class="mt-2">
						<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
							<!-- Add icons to the links using the .nav-icon class
								with font-awesome or any other icon font library -->
							<li class="nav-item">
								<a href="{{route('bucket.list')}}" class="nav-link">
									<i class="nav-icon fas fa-file-alt"></i>
									<p>Bucket</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{route('ball.list')}}" class="nav-link">
									<i class="nav-icon fas fa-file-alt"></i>
									<p>Ball</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{route('result.list')}}" class="nav-link">
									<i class="nav-icon fas fa-tag"></i>
									<p>Result</p>
								</a>
							</li>							
						</ul>
					</nav>
					<!-- /.sidebar-menu -->
				</div>
				<!-- /.sidebar -->
         	</aside>