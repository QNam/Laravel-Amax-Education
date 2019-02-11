<table id="listBill" class="table">

	<thead>
		<th class="w-10 text-bold">Mã HD</th>
		<th class="text-bold">Họ Tên</th>
		<th class="text-bold">Ngày lập</th>
		<th class="text-bold">Tháng</th>
		<th class="text-bold">Tổng tiền</th>
		<th class="text-bold">Khuyến mãi</th>
		<th class="text-bold">Thanh toán</th>
		<th></th>
	</thead>
	<tbody id="listBillData">
		@if( count($bills) != 0)
		@foreach($bills as $bill)
		
		@php
			$bill_total = number_format($bill->bill_total,0,',','.');
			$bill_pay = number_format($bill->bill_pay,0,',','.');
			$old_debt = number_format($bill->old_debt,0,',','.');
			$new_debt = number_format($bill->new_debt,0,',','.');
			$billExcess = number_format($bill->bill_pay - $bill->bill_total,0,',','.')
		@endphp

		<tr class="cursor-pointer" id="bill-{{$bill->bill_id}}" >
			<td onclick="openDiv({{$bill->bill_id}})"  class="text-center 
				{!! ($bill->new_debt > 0) ? 'text-primary' : ""  !!} {!! ($bill->new_debt < 0) ? 'text-danger': ""  !!} {!! ($bill->new_debt == 0) ? 'text-success': ""  !!}
			">{{$bill->bill_id}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->stu_name}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->created_at}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->month}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill_total}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->bill_discount}} %</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill_pay}}</td>
			<td>
				@if( $bill->allow_update == 1)						
					<button type="button" class="btn btn-warning" 
						onclick="getBillInfo({{ $bill->bill_id }})">
						<i class="icon-pencil3"></i>
					</button>
				@endif

				<form action="{{route('BillDelete')}}" method="POST" style="display: inline;">
					@csrf
					<input type="hidden" name="billId" value="{{$bill->bill_id}}">
					<button type="submit" class="btn btn-danger">
						<i class="icon-bin"></i>
					</button>
				</form>
						
			</td>
		</tr>

		<tr class="detail-bill-item" id="detail-bill-{{$bill->bill_id}}" style="display: none;">
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
								<p><span class="text-bold">Thừa/thiếu trước đó: </span>{{$old_debt}}</p>
								<p><span class="text-bold">Khuyến mãi: </span>{{ $bill->bill_discount }} %</p>
								<p><span class="text-bold">Tổng tiền: </span>{{$bill_total}}</p>								
								<p><span class="text-bold">Thực thu: </span>	{{$bill_pay}}</p>
								<p><span class="text-bold">Trả lại: </span>	
									{{ ($bill->isExcess == "0" && $bill->bill_pay > $bill->bill_total) ? $billExcess : "Không" }}
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
								<td class="vCouPrice">{{ number_format($detail->cou_price,0,',','.') }}</td>
								<td class="w-5 vTotalLesson">{{$detail->total_lesson}}</td>
								<td class="vCouDiscount">{{$detail->discount}}</td>
								<td class="vCouTotal">{{ number_format($detail->couTotal,0,',','.') }}</td>
							</tr>
							@endforeach
							<tr>
								<td colspan="4" class="text-bold">Tổng tiền: </td>
								<td class="text-bold cousTotal">{{number_format($bill->cousTotal,0,',','.')}}</td>
							</tr>
						</tbody>
						</table>
					</div>
				</div>

			</td>
		</tr>

		@endforeach
		@else
		<tbody id="listBillData">
			<tr>
				<td colspan="8" class="text-center">Không tìm thấy hóa đơn nào !</td>
			</tr>
		</tbody>
		@endif
	</tbody>
</table>
<div class="text-right" style="margin-top: 20px;">
{{ $bills->links() }}	
</div>

<script>
	function openDiv(id){
	    // $('.detail-bill-item').toggle();
	    $("#detail-bill-"+id).toggle();
	    vCreateTotalOfCourse(id);
    }
	

</script>