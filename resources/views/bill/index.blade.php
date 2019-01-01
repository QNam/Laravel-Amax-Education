@php
    $brc_main ="Hóa Đơn";
	$brc_active = "Danh sách hóa đơn";
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

<div class="panel panel-flat">
<div class="panel-body">
<div class="control pull-right">
	 <div style="display: inline; margin-right: 10px"><button class="btn btn-danger"></button> Hóa đơn nợ</div>
	 <div style="display: inline; margin-right: 10px"><button class="btn btn-success"></button> Hóa đơn không nợ</div>
	 <div style="display: inline; margin-right: 10px"><button class="btn btn-primary"></button> Hóa đơn thừa</div>
</div>
<div style="clear: both;"></div>

<div class="filter clearfix">
	<div action="" class="form-inline pull-right">
		<div class="form-group has-feedback">
			<input type="text" class="form-control" placeholder="Họ tên ..." name="filterSearch" onkeyup="filterBill()">
		</div>
		
		<select name="filterCourse" id="" class="form-control" onchange="filterBill()">
			<option value="">-- Chọn lớp học --</option>
			{{-- @foreach($courses as $course)
			<option value="{{$course->cou_id}}">{{$course->cou_name}}</option>
			@endforeach --}}
		</select>

		<select name="filterWallet" id="" class="form-control" onchange="filterBill()">
			<option value="">-- Tình trạng</option>
			<option value="-1">Nợ</option>
			<option value="0">Không nợ</option>
			<option value="1">Thừa</option>
		</select>
	</div>
</div>


<div id="dataContent">
@include('bill.data')	
</div>
</div>
</div>

@endsection



@push('css-file')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endpush

@push('js-file')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
@endpush


@push('js-code')
<script>
	

	function updateBill()
	{
		var isExcess = $('input[name=isExcess]:checked').val();
	    	var billDiscount = $('input[name=billDiscount]').val();

	    	if (isExcess == '') {isExcess = 0}
	    	if (billDiscount == '') {billDiscount = 0}

	    	var stuId = $('input[name=pStuId]').val();
	    	var billId = $('input[name=billId]').val();
	    	if (billId == '') {billId = 0}


	    	if ( $("#payForm").valid() ) 
	    	{
    			$.ajax({

		    		url: "{{ route('BillStore') }}",
		    		type: 'POST',
		    		data: {
		    			courses: getCourseToPay(),
		    			stuId: stuId,
		    			billId: billId,
		    			billMonth: $('select[name=billMonth]').val(),
		    			billDiscount: $('input[name=billDiscount]').val(),
		    			billPay: $('input[name=billPay]').val(),
		    			isExcess: isExcess
		    		},
		    		success: function(data) {
		    			
		    			if (data['validate'] == false) 
		    			{
		    				
		    				error = data['data'];
		    				
		    				if (typeof error['billMonth'] !== 'undefined')  $('.valid_err_billMonth').text(error['billMonth'][0]);
		    				if (typeof error['billDiscount'] !== 'undefined')  $('.valid_err_billDiscount').text(error['billDiscount'][0]);
		    				if (typeof error['billPay'] !== 'undefined')  $('.valid_err_billPay').text(error['billPay'][0]);

		    				return false;
		    				
		    			}

		    			console.log(data);

		    			if (data['success'] == true) 
		    			{
		    				showNotify("",data['msg'],'bg-success');							
		    			} else {
		    				showNotify("",data['msg'],'bg-danger');							
		    			}
		    			 
		    		},	
		    		error:function(data) {
		    			console.log(data);
		    			console.log('error');
		    		}
		    	});
	    	}
	}


	function filterBill()
	{
		
	}
</script>
@endpush