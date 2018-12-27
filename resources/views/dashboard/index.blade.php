@extends('template.layout')

@section('title',$title)

@section('content')
@if ($errors->any())
<script>
	$(window).load(function(){
		
	});
	
</script>
@endif
<div class="row">

		<div class="col-xs-3">

			<!-- Members online -->
			<div class="panel bg-teal-400">
				<div class="panel-body">
					<div class="heading-elements">
						<ul class="icons-list">
	                		<li class="dropdown">
	                			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i> <span class="caret"></span></a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="#"><i class="icon-sync"></i> Update data</a></li>
									<li><a href="#"><i class="icon-list-unordered"></i> Detailed log</a></li>
									<li><a href="#"><i class="icon-pie5"></i> Statistics</a></li>
									<li><a href="#"><i class="icon-cross3"></i> Clear list</a></li>
								</ul>
	                		</li>
	                	</ul>
					</div>

					<h3 class="text-bold" style="font-size: 48px;">{{$tk['student']}}</h3>
					HỌC SINH
				</div>

			</div>
		</div>

		<div class="col-xs-3">

			<!-- Current server load -->
			<div class="panel bg-pink-400">
				<div class="panel-body">
					<div class="heading-elements">
						<ul class="icons-list">
	                		<li class="dropdown">
	                			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i> <span class="caret"></span></a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="#"><i class="icon-sync"></i> Update data</a></li>
									<li><a href="#"><i class="icon-list-unordered"></i> Detailed log</a></li>
									<li><a href="#"><i class="icon-pie5"></i> Statistics</a></li>
									<li><a href="#"><i class="icon-cross3"></i> Clear list</a></li>
								</ul>
	                		</li>
	                	</ul>
					</div>

					<h3 class="text-bold" style="font-size: 48px;">{{$tk['teacher']}}</h3>
					GIÁO VIÊN
				</div>
			</div>
			<!-- /current server load -->

		</div>


		<div class="col-xs-3">

			<!-- Current server load -->
			<div class="panel bg-primary-400">
				<div class="panel-body">
					<div class="heading-elements">
						<ul class="icons-list">
	                		<li class="dropdown">
	                			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i> <span class="caret"></span></a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="#"><i class="icon-sync"></i> Update data</a></li>
									<li><a href="#"><i class="icon-list-unordered"></i> Detailed log</a></li>
									<li><a href="#"><i class="icon-pie5"></i> Statistics</a></li>
									<li><a href="#"><i class="icon-cross3"></i> Clear list</a></li>
								</ul>
	                		</li>
	                	</ul>
					</div>

					<h3 class="text-bold" style="font-size: 48px;">{{$tk['course']}}</h3>
					LỚP HỌC
				</div>
			</div>
			<!-- /current server load -->

		</div>


		<div class="col-xs-3">

			<!-- Current server load -->
			<div class="panel bg-pink-400">
				<div class="panel-body">
					<div class="heading-elements">
						<ul class="icons-list">
	                		<li class="dropdown">
	                			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i> <span class="caret"></span></a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="#"><i class="icon-sync"></i> Update data</a></li>
									<li><a href="#"><i class="icon-list-unordered"></i> Detailed log</a></li>
									<li><a href="#"><i class="icon-pie5"></i> Statistics</a></li>
									<li><a href="#"><i class="icon-cross3"></i> Clear list</a></li>
								</ul>
	                		</li>
	                	</ul>
					</div>

					<h3 class="text-bold" style="font-size: 48px;">100.000</h3>
					Doanh thu tháng
				</div>
			</div>
			<!-- /current server load -->

		</div>
									
</div>



@endsection

@push('css-file')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endpush

@push('js-file')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
@endpush


@push('js-code')
    
<script>
	$(document).ready( function () {

	});
</script>



<script>
 function {
		$.ajax({
			url: "",
			method: 'POST',
			data: {
				
			},
			success: function(data){
				console.log('success');
				

				if (data['success']) 
				{
					//showNotify("",data['msg'],'bg-success');

				} else {
				//showNotify("",data['msg'],'bg-danger');	    				
				}
				

			},
			error:function() {
				console.log('error');
				//showNotify("",'Gửi dữ liệu thất bại','bg-danger');	
			}
		})
	} 
</script>

@endpush



