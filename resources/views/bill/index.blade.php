@extends('template.layout')

@section('title',$title)

@section('content')

@if ($errors->any())
<script>
	$(window).load(function(){
		
	});
	
</script>
@endif

<div class="control">
	 
</div>

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


<div class="modal fade" id="payModal">
	<div class="modal-dialog" style="width: 90vw">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Chi tiết hóa đơn</h4>
			</div>
			<div class="modal-body">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
						<p class="text-bold">Người nộp: </p>
						<p class="text-bold">Đóng học tháng: </p>
						<p class="text-bold">Ngày lập: </p>
						<p class="text-bold">Lần cập nhật mới nhất: </p>
					</div>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
						<p class="bStudent"></p>
						<p class="bMonth"></p>
						<p class="bCreated"></p>
						<p class="bUpdated"></p>
					</div>

				</div>

				<div class="row" style="margin-top: 20px;">
					<form action="{{route('BillStore')}}" method="POST" id="payForm">
						@include('student.bill-form')	
						<div class="clearfix">
							<button type="submit" class="btn btn-primary pull-right" onclick="updateBill()">Cập nhật</button>
						</div>
					</form>
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

	function getDetailBillInfo(id)
	{
		$.ajax({
				url: '{{route('BillGetOne')}}',
				type: 'POST',
				data: {
					billId: id
				},
				success: function(data) {

					if (data['success'] == false) 
					{
						showNotify("",data['msg'],'bg-danger');
						
						return false;
					}
					$('#payModal').modal('show');

					var bill = data['data'][0]; 
					var detail = data['data'][0]['details'];

					$('input[name=pStuId]').val(bill['stu_id']);
					$('input[name=billId]').val(bill['bill_id']);
					$('.bStudent').text(bill['stu_name']);
					$('.bMonth').text(bill['month']);
					$('.bCreated').text(bill['created_at']);
					$('.bUpdated').text(bill['updated_at']);
					
					var html = "";

					$('.stuWallet').text( Number(bill['stu_wallet']).formatnum() );
					$('select[name=billMonth] option:eq('+ bill['month']  +')').prop('selected', true);
					$('input[name=billDiscount]').val(bill['bill_discount']);
					$('input[name=billTotal]').val(Number(bill['bill_total']).formatnum() );
					$('input[name=billPay]').val(bill['bill_pay']);

					detail.forEach( function(elem,index){

    					html = '<tr id="pCou-'+elem['cou_id']+'" class="pCouItem">'
    									+'<input type="hidden" class="payCouId" value="'+elem['cou_id']+'">'
    									+'<td class="payCouName">'+elem['cou_name']+'</td>'
										+'<td class="pCouPrice">'+Number(elem['cou_price']).formatnum()+'</td>'
										+'<td>'
										+'<input type="number" class="form-control pTotalLesson" required="true" name="pTotalLesson[]" onkeyup="createTotalOfCourse('+elem['cou_id']+'); createTotalBill();" value="'+elem['total_lesson']+'">'
										+'</td>'
										+'<td>'
										+'<input type="number" class="form-control pCouDiscount" min="0" max="100" value="'+elem['discount']+'" name="pCouDiscount[]" onkeyup="createTotalOfCourse('+elem['cou_id']+'); createTotalBill(); "  placeholder="%">'
										+'</td>'
										+'<td><input type="text" class="form-control pCouTotal" placeholder="VND" disabled="true">'
											
										+'</td>'
										+'<td class="text-center">'
											
										+'</td>'
									+'</tr>'
						$('#payCourseInfo').append(html);
						createTotalOfCourse(elem['cou_id']);
    				});

    				createTotalBill();
    				createBillNotify();
				},
				error: function() {
					console.log('error');
					// showNotify("",'Xóa Học Sinh thất bại !','bg-danger');
				}
			});
	}


	function filterBill()
	{
		
	}
</script>
@endpush