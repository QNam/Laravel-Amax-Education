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


<div class="modal fade" id="Modal_DetailBillInfo">
	<div class="modal-dialog" style="width: 80vw">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Chi tiết hóa đơn</h4>
			</div>
			<div class="modal-body">
			
			<div class="pull-right">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			<div class="clearfix"></div>

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
	$(document).ready( function () {

	});


	function getDetailBillInfo(id)
	{
		$.ajax({
				url: '{{route('DeleteStudent')}}',
				type: 'POST',
				data: {
					stuId: id
				},
				success: function(data) {
					console.log('success');
					
					
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