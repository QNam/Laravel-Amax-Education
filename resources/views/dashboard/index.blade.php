@php
    $brc_main ="Home";
	$brc_active = "Dashboard";
@endphp

@extends('template.layout')

@section('title',$title)

@section('content')
@if ($errors->any())
<script>
	$(window).load(function(){
		
	});
	
</script>
@endif
<script>

	console.log(rewriteUrl(window.location.search))
	

    
</script>
{{-- <div class="panel panel-flat">
	<div class="panel-heading">
		<h6 class="panel-title">Thống kê<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
	</div>

	<div class="panel-body">
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

							<h3 class="text-bold" style="font-size: 36px;">{{$tk['student']}}</h3>
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

							<h3 class="text-bold" style="font-size: 36px;">{{$tk['teacher']}}</h3>
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

							<h3 class="text-bold" style="font-size: 36px;">{{$tk['course']}}</h3>
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

							<h3 class="text-bold" style="font-size: 36px;">100.000</h3>
							Doanh thu tháng
						</div>
					</div>
					<!-- /current server load -->

				</div>								
		</div>
	</div>
</div> --}}

<style>
	#calendar{
		margin-top: 60px;
	}
	#calendar .fc-toolbar .fc-left,
	#calendar .fc-toolbar .fc-right{
		width: unset;
	}
	
</style>

<div class="panel panel-flat">
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div id="calendar" style=""></div>
			</div>
		</div>
	</div>
</div>

@endsection

@push('css-file')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link href="{{URL::asset('css/fullcalendar.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('css/fullcalendar.print.min.css')}}" rel="stylesheet" media="print">
@endpush

@push('js-file')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{URL::asset('js/moment.min.js')}}"></script>
	<script src="{{URL::asset('js/fullcalendar.min.js')}}"></script>
	<script src="{{URL::asset('js/lang.js')}}"></script>
@endpush

@push('css-code')

 
@endpush

@push('js-code')
    
<script>
	$(document).ready(function() {
    
    $('#calendar').fullCalendar({
    	defaultView: 'month',
    	
      	header: {
        left: 'prev,next',
        lang: 'vi',
        right: 'month,agendaWeek,agendaDay,listWeek'
      },
      viewRender: function(view) {
        var title = "<h2 style='font-size: 24px; text-transform: uppercase'>Lịch học " + view.title + "</h2>";
        $("#calendar .fc-center").html(title);
        
      },
      eventDragStop: function () {
      	console.log('aaaa');
      },
      navLinks: true, // can click day/week names to navigate views
      editable: false,
      eventLimit: false, // allow "more" link when too many events
      events: getEventData()
      
    });
  }); /*/ready()*/



	function getEventData()
	{
		var courses = {!! $courses !!} 

		var data = [];


		courses.forEach(function(value,index){
			if ( value['cou_time'] != null ) 
			{
				value['cou_time'].forEach(function(val,id){

					for(var i = 0; i<7; i++){
						var item = {};
					
						item['title'] = value['cou_name'] /*+" "+ val['begin'] + ' - ' + val['end']*/;
						item['start'] = moment(val['begin'],'HH:mm').day(val['date'] - i*7).format();
						item['end'] = moment(val['end'],'HH:mm').day(val['date'] - i*7).format();
						item['color'] = val['color'];

						data.push(item);	
					}

					for(var i = 1; i<7; i++){
						var item = {};
						
						item['title'] = value['cou_name'] /*+" "+ val['begin'] + ' - ' + val['end']*/;
						item['start'] = moment(val['begin'],'HH:mm').day(Number(val['date']) + i*7 ).format();
						item['end'] = moment(val['end'],'HH:mm').day(Number(val['date']) + i*7  ).format();
						item['color'] = val['color'];

						data.push(item);	
					}
				})
			}
		});
		return data;
	}
</script>


@endpush



