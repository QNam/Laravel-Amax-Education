<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<p><span class="text-bold">Họ tên: </span> {{$student->stu_name}}</p>
		<p><span class="text-bold">Khối: </span>{{$student->stu_grade}}</p>
		<p><span class="text-bold">Địa chỉ: </span>{{$student->stu_address}}</p>			
		<p><span class="text-bold">Ngày nhập học: </span>{{$student->created_at}}</p>			
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<p><span class="text-bold">Phụ huynh: </span>{{$student->parent_name}}</p>
		<p><span class="text-bold">SDT: </span>{{$student->parent_phone}}</p>
		<p><span class="text-bold">Nợ/dư: </span>{{$student->stu_wallet}} VND</p>			
	</div>	
</div>

<div class="row" style="margin-top: 10px;">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h4 class="text-bold">Danh sách các lớp học</h4>
		<table class="table table-bordered">
			<thead>
				<th>Tên lớp</th>
				<th>Giáo viên</th>
				<th>Môn</th>
				<th>Tình trạng</th>
			</thead>
			<tbody>
				@foreach($student['courses'] as $course)
				<tr>
					<td>{{$course->cou_name}}</td>
					<td>{{$course->tea_name}}</td>
					<td>{{$course->sub_name}}</td>
					<td class="{{$course->status != App\Model\Register::ACTIVE ? 'text-danger' : ""}}">
						{{$course->status == App\Model\Register::ACTIVE ? "ĐANG HỌC" : 'ĐÃ THÔI HỌC - '.$course->updated_at}}
					</td>
						
				</tr>
				@endforeach
			</tbody>
		</table>	
	</div>
</div>

<div class="row" style="margin-top: 10px;">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<h4 class="text-bold">Thông tin thanh toán</h4>	
<table id="listBill" class="table table-bordered">

	<thead>
		<th class="w-10 text-bold">Mã HD</th>
		<th class="text-bold">Họ Tên</th>
		<th class="text-bold">Ngày lập</th>
		<th class="text-bold">Tháng</th>
		<th class="text-bold">Tổng tiền</th>
		<th class="text-bold">Khuyến mãi</th>
		<th class="text-bold">Thanh toán</th>
		
	</thead>
	<tbody id="listBillData">
		@if(count($student['bills']) > 0)
		@foreach($student['bills'] as $bill)

		<tr class="cursor-pointer" id="bill-{{$bill->bill_id}}" data-popup="tooltip" title="Click để biết thông tin chi tiết" >
			<td onclick="openDiv({{$bill->bill_id}})"  class="text-center 
				{!! ($bill->new_debt > 0) ? 'text-primary' : ""  !!} {!! ($bill->new_debt < 0) ? 'text-danger': ""  !!} {!! ($bill->new_debt == 0) ? 'text-success': ""  !!}
			">{{$bill->bill_id}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->stu_name}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->created_at}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->month}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->bill_total}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->bill_discount}} %</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->bill_pay}}</td>
		</tr>

		<tr class="" id="detail-bill-{{$bill->bill_id}}" style="display: none;">
			<td colspan="8" style="padding: 30px 5px; background-color: #eee">
				
				<div class="panel panel-white">
					<div class="panel-heading">
						<h4><i class="icon-list"></i>  Thông tin hóa đơn</h4>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-toggle="tooltip" title="Close" onclick="openDiv({{$bill->bill_id}})"><i class="icon-cross"></i></a></li>
		                	</ul>
	                	</div>
					</div>
					
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<p><span class="text-bold">Họ tên: </span>{{$bill->stu_name}}</p>
								<p><span class="text-bold">Đóng học tháng: </span>{{$bill->month}}</p>
								<p><span class="text-bold">Ngày lập: </span>{{$bill->created_at}}</p>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
								<p><span class="text-bold">Thừa/thiếu trước đó: </span>{{$bill->old_debt}}</p>
								<p><span class="text-bold">Khuyến mãi: </span>{{ $bill->bill_discount }} %</p>
								<p><span class="text-bold">Tổng tiền: </span>{{$bill->bill_total}}</p>								
								<p><span class="text-bold">Thực thu: </span>	{{$bill->bill_pay}}</p>
								<p><span class="text-bold">Trả lại: </span>	
									{{ ($bill->isExcess == "0") ? $bill->bill_pay - $bill->bill_total : "Không" }}
								</p>
							</div>
						</div>
						<table class="table table-bordered vDataCourse">
							<thead>
								<th class="text-bold">Khóa học</th>
								<th class="text-bold">Giá tiền</th>
								<th class="text-bold">Tổng số buổi</th>
								<th class="text-bold">Khuyến mãi</th>
								<th class="text-bold">Tổng tiền</th>
							</thead>	
						
						<tbody>
							@foreach($bill->details as $detail)
							<tr class="vCou-{{$detail->cou_id}} detail-bill-item">
								<td>{{$detail->cou_name}}</td>
								<td class="vCouPrice">{{$detail->cou_price}}</td>
								<td class="w-5 vTotalLesson">{{$detail->total_lesson}}</td>
								<td class="vCouDiscount">{{$detail->discount}}</td>
								<td class="vCouTotal">{{$detail->couTotal}}</td>
							</tr>
							@endforeach
							<tr>
								<td colspan="4" class="text-bold">Tổng tiền: </td>
								<td class="text-bold cousTotal">{{$bill->cousTotal}}</td>
							</tr>
						</tbody>
						</table>
					</div>
				</div>

			</td>
		</tr>

		@endforeach
		@endif
	</tbody>
</table>
<script>
	function openDiv(id){
	    $("#detail-bill-"+id).toggle();
    }
	

</script>
</div>
</div>