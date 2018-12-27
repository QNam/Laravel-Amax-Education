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

		<div class="col-lg-3">

			<!-- Members online -->
			<div class="panel bg-teal-400">
				<div class="panel-body">
					<div class="heading-elements">
						<span class="heading-text badge bg-teal-800">+53,6%</span>
					</div>

					<h3 class="no-margin">3,450</h3>
					Members online
					<div class="text-muted text-size-small">489 avg</div>
				</div>

			</div>
		</div>

		<div class="col-lg-3">

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

					<h3 class="no-margin">49.4%</h3>
					Current server load
					<div class="text-muted text-size-small">34.6% avg</div>
				</div>
			</div>
			<!-- /current server load -->

		</div>


		<div class="col-lg-3">

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

					<h3 class="no-margin">49.4%</h3>
					Current server load
					<div class="text-muted text-size-small">34.6% avg</div>
				</div>
			</div>
			<!-- /current server load -->

		</div>


		<div class="col-lg-3">

			<!-- Today's revenue -->
			<div class="panel bg-blue-400">
				<div class="panel-body">
					<div class="heading-elements">
						<ul class="icons-list">
	                		<li><a data-action="reload"></a></li>
	                	</ul>
	            	</div>

					<h3 class="no-margin">$18,390</h3>
					Today's revenue
					<div class="text-muted text-size-small">$37,578 avg</div>
				</div>
			</div>
			<!-- /today's revenue -->

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



