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
			<input type="text" class="form-control" placeholder="Họ tên ..." name="filterSearch" onkeypress="handleSearch(event)">
		</div>
		
		<select name="filterCourse" id="" class="form-control" onchange="filterBill()">
			<option value="">-- Chọn lớp học --</option>
			@foreach($courses as $course)
			<option value="{{$course->cou_id}}">{{$course->cou_name}}</option>
			@endforeach
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


<div class="modal fade" id="payModal" data-state="">
	<div class="modal-dialog" style="width: 90vw">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class=" icon-file-text"></i> Thanh toán</h4>
			</div>
			<div class="modal-body">
				<form action="{{route('BillStore')}}" method="POST" id="payForm">
					@include('student.bill-form')	
					<div class="clearfix">
						<button type="submit" class="btn btn-primary pull-right" onclick="updateBill()">Xác nhận</button>
					</div>
				</form>
				
			</div>			
		</div>
	</div>
</div>


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
	function handleSearch(e){
        if(e.which == 13 ){
            filterBill();
            console.log('a');
        }

        return false;
    }

    function getBillInfo(billId)
    {
    	$("#payModal").modal("show");	
    	showLargeLoading('#payModal .modal-dialog');

    	$("input[name=billId]").val(billId);

    	$.ajax({
    		url: '{{route('BillGetOne')}}',
    		type: 'POST',
    		dataType: 'json',
    		data: {billId: billId},
    		success: function(data){
    			console.log(data);

    			if (data['success']) 
    			{

    				data = data['data']['data'][0];
    				var details = data['details'];

    				var html = "";

    				details.forEach( function(elem,index){

    					html = '<tr id="pCou-'+elem['cou_id']+'" class="pCouItem">'
    									+'<input type="hidden" class="payCouId" value="'+elem['cou_id']+'">'
    									
    									+'<td class="payCouName">'+elem['cou_name']+'</td>'
										
										+'<td class="pCouPrice">'+Number(elem['cou_price']).formatnum()+' VNĐ </td>'
										
										+'<td><input type="number" class="form-control pTotalLesson" required="true" name="pTotalLesson[]" onkeyup="createTotalOfCourse('+elem['cou_id']+'); createTotalBill();" value="'+elem['total_lesson']+'"></td>'

										+'<td><input type="number" class="form-control pCouDiscount" min="0" max="100" value="0" name="pCouDiscount[]" onkeyup="createTotalOfCourse('+elem['cou_id']+'); createTotalBill();" value="'+elem['discount']+'" placeholder="%"></td>'
										
										+'<td><input type="text" class="form-control pCouTotal" placeholder="VND" disabled="true"></td>'
										
										+'<td class="text-center btn-delete">'
											+'<a href="#" onclick="removePayCourse('+elem['cou_id']+'); return false;"><i class="icon-bin"></i></a>'
										+'</td>'
									+'</tr>'
						$('#payCourseInfo').append(html)
						createTotalOfCourse(elem['cou_id']);
    				});
    				createTotalBill();

    				$("input[name=pStuId]").val(data['stu_id']);
    				$('select[name=billMonth]').val(data['month']);
    				$('input[name=billDiscount]').val(data['bill_discount']);
    				$('input[name=billPay]').val(data['bill_pay']);


    				hideOverLoading('#payModal .modal-dialog');
    			}
    		},

    		error: function(){
    			console.log('error');
    		}
    	})
    	
    }

	function updateBill()
	{

		var isExcess = $('input[name=isExcess]:checked').val();
	    	var billDiscount = $('input[name=billDiscount]').val();
	    	var stuId = $('input[name=pStuId]').val();
	    	var billId = $('input[name=billId]').val();

	    	if (isExcess == '') {isExcess = 0}
	    	if (billDiscount == '') {billDiscount = 0}
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

		    			if (data['success'] == true) 
		    			{
		    				$("#payModal").modal("hide");	
		    				showNotify("",data['msg'],'bg-success');							
		    			} else {
		    				showNotify("",data['msg'],'bg-danger');							
		    			}
		    			 
		    		},	
		    		error:function(data) {
		    			console.log('error');
		    		}
		    	});
	    	}
	}


	 function filterBill()
	    {
	    	showLargeLoading('#dataContent');

	    	var course = $('select[name="filterCourse"]').val();
	    	var search = $('input[name="filterSearch"]').val();
	    	var wallet = $('select[name="filterWallet"]').val();

	    	$.ajax({
	    		url: "{{ route('BillGetFilter') }}",
	    		method: 'POST',
	    		data: {
	    			filterSearch: search,
	    			filterCourse: course,
	    			filterWallet: wallet
	    		},
	    		success: function(data){
	    			$('#dataContent').html(data);
	    			hideOverLoading('#dataContent');
	    		},
	    		error:function() {
	    			console.log('error');	
	    			showNotify("",'Lỗi gửi yếu cầu !','bg-danger');
	    			hideOverLoading('#dataContent');
	    		} 
	    	});
	    }
</script>
@endpush