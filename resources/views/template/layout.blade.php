
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('images/favicon.png') }}" />
	<title>@yield('title')</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('kit/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
	{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> --}}
	<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">

	
	<!-- /global stylesheets -->
	

	<!-- Core JS files -->
	{{-- <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script> --}}
	<script type="text/javascript" src="{{ URL::asset('kit/js/plugins/loaders/pace.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('kit/js/core/libraries/jquery.min.js') }}"></script>
	
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> --}}
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	<!-- /core JS files -->
	

	<!-- base CSS & JS file -->
	<link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/common.js') }}"></script>
	<style>
		
	</style>
	<!-- /base CSS file -->
	<script>
		$( window ).load(function() { 
			
			var state = getCookie('state_slidebar'); 

			if( state != "" && state == 'hide')
			{
				
				// $('body').addClass('sidebar-xs');
				
			} 
			if ( state != "" && state == 'show' ) 
			{
				
				$('body').removeClass('sidebar-xs');
				
			}  

			if(state == ""){
				
				setCookie('state_slidebar','hide',365);	
			}
		});

		function setStateSlidebar()
		{
			var state = getCookie('state_slidebar'); 
			if( state != "" && state == 'hide')
			{	
				setCookie('state_slidebar','show',365);
			} 
			if ( state != "" && state == 'show' ) 
			{
				
				setCookie('state_slidebar','hide',365);
			}  

			if(state == ""){
				setCookie('state_slidebar','hide',365);
				
			}
		}
			  
	</script>
	<link href="{{ URL::asset('css/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css">
	

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{ URL::asset('kit/js/core/app.js') }}"></script>

	<!-- /theme JS files -->
	@stack('css-file')

	<link href="{{ URL::asset('kit/css/core.min.css') }}" rel="stylesheet" type="text/css">	
	<link href="{{ URL::asset('kit/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('kit/css/colors.min.css') }}" rel="stylesheet" type="text/css">

</head>

<body style="background-color: #f5f5f5" class="sidebar-xs">

	<!-- Main navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-header">
			<a class="navbar-brand" href="{{route('index')}}"><img src="{{ URL::asset('images/logo_light.png')}}" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs" onclick="setStateSlidebar()"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
			

			<p class="navbar-text"><span class="label bg-success">Online</span></p>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="{{ URL::asset('images/placeholder.jpg')}}" alt="">
						<span>{{Auth::user()->name}}</span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="{{route('SelfIndex')}}"><i class="icon-cog5"></i> Account settings</a></li>
						<li><form action="{{route('logout')}}" method="post" id="logoutForm">@csrf</form>
							<a href="#" onclick="$('#logoutForm').submit();"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main" style="padding-top: 54px;">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<a href="#" class="media-left"><img src="{{ URL::asset('images/placeholder.jpg')}}" class="img-circle img-sm" alt=""></a>
								<div class="media-body">
									<span class="media-heading text-semibold">{{Auth::user()->name}}</span>
									<div class="text-size-mini text-muted">
										<i class="icon-pin text-size-small"></i>{{Auth::user()->role == 1 ? ' Quản trị viên' : ' Người kiểm duyệt'}} 
									</div>
								</div>

								<div class="media-right media-middle">
									<ul class="icons-list">
										<li>
											<a href="{{route('SelfIndex')}}"><i class="icon-cog3"></i></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<!-- Main -->
								<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
								<li><a href="{{route('index')}}"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
								<li>
									<a href="#" class="has-ul"><i class=" icon-user"></i> <span>Học sinh</span></a>
									<ul class="has-ul">
										<li><a href="{{url('student')}}">Danh sách học sinh</a></li>
										@if(Auth::user()->role == 1)
										<li><a href="{{route('LogIndex')}}">Lưu trữ Học Sinh</a></li>
										@endif
									</ul>
								</li>
								<li>
									<a href="#" class="has-ul"><i class="icon-stack2"></i> <span>Giáo viên</span></a>
									<ul class="has-ul">
										<li><a href="{{url('teacher')}}">Danh sách giáo viên</a></li>
									</ul>
								</li>
								<li>
									<a href="#"><i class=" icon-users"></i> <span>Lớp học</span></a>
									<ul>
										<li><a href="{{url('course')}}">Danh sách lớp học</a></li>
									</ul>
								</li>
								<li>
									<a href="#"><i class="icon-book"></i> <span>Môn học</span></a>
									<ul>
										<li><a href="{{route('SubjectIndex')}}">Danh sách Môn học</a></li>
									</ul>
								</li>
								<li>
									<a href="#"><i class=" icon-file-text3"></i> <span>Hóa đơn</span></a>
									<ul>
										<li><a href="{{route('BillIndex')}}">Danh sách hóa đơn</a></li>
									</ul>
								</li>
								@if(Auth::user()->role == 1)
								<li>
									<a href="#"><i class="icon-person"></i> <span>Quản trị viên</span></a>
									<ul>
										<li><a href="{{route('UserIndex')}}">Danh sách QTV</a></li>
									</ul>
								</li>
								@endif

							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper"  style="padding-top: 54px;">
				
				<!-- Content area -->
				@include('template.page-header')
				<div class="content" id="content">

					@if (Session::has('success'))
					<script>
						$( window ).load(function() {
						  new PNotify({
							    title: '',
					            text: "{{Session::get('success') }}",
					            addclass: 'bg-success',
					            delay: 1000,
					            icon:''
							})
						});
						
						
					</script>
					@endif

					@if (Session::has('warning'))
					<script>
						$( window ).load(function() {

						  new PNotify({
							    title: '',
					            text: "{{Session::get('warning') }}",
					            addclass: 'bg-warning',
					            delay: 1000,
					            icon:''
							})
						});
						
						
					</script>
					@endif

					@if (Session::has('error'))
					<script>
						$( window ).load(function() {
						  new PNotify({
							    title: '',
					            text: "{{Session::get('error') }}",
					            addclass: 'bg-danger',
					            delay: 1000,
					            icon:''
							})
						});
						
						
					</script>
					@endif

					@if (Session::has('info'))
					<script>
						$( window ).load(function() {
						  new PNotify({
							    title: '',
					            text: "{{Session::get('info') }}",
					            addclass: 'bg-info stack-bar-bottom',
					         	width: "50%",
					            delay: 5000,
					            icon:''
							})
						});
						
						
					</script>
					@endif

					@if (Session::has('swu_mess'))
					<script>
						$( window ).load(function() {
						  new PNotify({
							    title: '',
					            text: "{{Session::get('swu_mess') }}",
					            addclass: 'bg-info stack-bar-bottom',
					         	width: "50%",
					            delay: Number({{App\Model\HistoryUpdate::DELAY_TO_UPDATE * 1000}}),
					            icon:''
							})
						});
						
						
					</script>

					@endif

					@yield('content')
					

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<input type="hidden" id="studentWillUpdate" value="{{session('student_will_update')}}">
	<!-- /page container -->
	@stack('js-file')
	
	<script type="text/javascript" src="{{ URL::asset('js/pnotify.custom.min.js') }}"></script>
	
	<script>
		$(document).ready(function(){
		  	$('[data-toggle="tooltip"]').tooltip(); 
		  	sendUpdateRequest();
		  	setTimeout(function(){
		  		if ( $('#studentWillUpdate').val() == 1 ) 			
					showLargeLoading('body');
			},{{App\Model\HistoryUpdate::DELAY_TO_UPDATE * 1000}})
		});




			function sendUpdateRequest()
			{
				  if ( $('#studentWillUpdate').val() == 1 ) 
				  {	  
				  	  // showLargeLoading('body');
					  $.ajax({
					  	url: '{{ route('doUpdate') }}',
					  	type: 'POST',
					  	data: {student_will_update: 1},
					  	success: function(data){
					  		if (data['success'] == true) {
					  			showNotify("",data['msg'],'bg-success');	
					  		}
					  		
					  		hideOverLoading('body');

					  		if (data['success'] == false) {
					  			showNotify("",data['msg'],'bg-danger');	
					  		}
					  	},
					  	error: function(){
					  		hideOverLoading('body');
					  		showNotify("",'Lỗi Gửi dữ liệu, Cập nhật chưa được thực hiện !','bg-danger');				  		
					  	}
					  })
				  }
			}

		// (function(){
		// 	setTimeout(,{{App\Model\HistoryUpdate::DELAY_TO_UPDATE * 1000}});
			
		// })()
		
		
		$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });

	    
	</script>
	@stack('js-code')
	
</body>
</html>


	