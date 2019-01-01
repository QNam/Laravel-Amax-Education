<table id="listBill" class="table">

	<thead>
		<th class="w-10 text-bold">Mã HD</th>
		<th class="text-bold">Họ Tên</th>
		<th class="text-bold">Ngày lập</th>
		<th class="text-bold">Tháng</th>
		<th class="text-bold">Tổng tiền</th>
		<th class="text-bold">Thanh toán</th>
		<th></th>
	</thead>
	<tbody id="listBillData">
		@foreach($bills as $bill)

		<tr class="cursor-pointer" id="bill-{{$bill->bill_id}}"  >
			<td onclick="openDiv({{$bill->bill_id}})"  class="text-center 
				{!! ($bill->new_debt > 0) ? 'text-primary' : ""  !!} {!! ($bill->new_debt < 0) ? 'text-danger': ""  !!} {!! ($bill->new_debt == 0) ? 'text-success': ""  !!}
			">{{$bill->bill_id}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->stu_name}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->created_at}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->month}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->bill_total}}</td>
			<td onclick="openDiv({{$bill->bill_id}})" >{{$bill->bill_pay}}</td>
			<td>
				<ul class="icons-list pull-left">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-menu9"></i>
						</a>

						<ul class="dropdown-menu dropdown-menu-right" style="padding: 10px; width: 150px;">
							<button type="button" class="btn btn-primary" onclick="getDetailBillInfo({{$bill->bill_id}})">
								<i class="icon-eye"></i>
							</button>
						
							<button type="button" class="btn btn-warning" 
								onclick="">
								<i class="icon-pencil3"></i>
							</button>
							

							<form action="{{route('BillDelete')}}" method="POST" style="display: inline;">
								@csrf
								<input type="hidden" name="billId" value="{{$bill->bill_id}}">
								<button type="submit" class="btn btn-danger">
									<i class="icon-bin"></i>
								</button>
							</form>
						</ul>
					</li>
				</ul>
			</td>
		</tr>

		<tr class="" id="detail-bill-{{$bill->bill_id}}" style="display: none;">
			<td colspan="7" style="padding: 30px 5px; background-color: #eee">
				
				<div class="panel panel-white">
					<div class="panel-heading">
						<h4><i class="icon-list"></i>  Thông tin hóa đơn</h4>
					</div>
					
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<p><span class="text-bold">Họ tên: </span>{{$bill->stu_name}}</p>
								<p><span class="text-bold">Đóng học tháng: </span>{{$bill->month}}</p>
								<p><span class="text-bold">Ngày lập: </span>{{$bill->created_at}}</p>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<p><span class="text-bold">Thừa/thiếu trước đó: </span>{{$bill->old_debt}}</p>
								<p><span class="text-bold">Khuyến mãi: </span>{{ $bill->bill_discount }} %</p>
								<p><span class="text-bold">Tổng tiền: </span>{{$bill->bill_total}}</p>								
								<p><span class="text-bold">Thực thu: </span>	{{$bill->bill_pay}}</p>
								<p><span class="text-bold">Trả lại: </span>	
									{{ ($bill->isExcess == "" || $bill->isExcess == "0") ? "Không" : "Có" }}
								</p>
							</div>
						</div>
						<table class="table table-bordered">
							<thead>
								<th class="text-bold">Khóa học</th>
								<th class="text-bold">Giá tiền</th>
								<th class="text-bold">Tổng số buổi</th>
								<th class="text-bold">Khuyến mãi</th>
							</thead>	
						
						<tbody>
							@foreach($bill->details as $detail)
							<tr>
								<td>{{$detail->cou_name}}</td>
								<td>{{$detail->cou_price}}</td>
								<td class="w-5">{{$detail->total_lesson}}</td>
								<td>{{$detail->discount}}</td>
							</tr>
							@endforeach
						</tbody>
						</table>
					</div>
				</div>

			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<script>
	 function openDiv(id){
	    $("#detail-bill-"+id).toggle();
    }

</script>