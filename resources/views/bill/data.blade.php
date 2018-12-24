<table id="listBill" class="table table-bordered">

	<thead>
		<th class="w-10 text-center text-bold">Mã HD</th>
		<th class="text-center text-bold">Họ Tên</th>
		<th class="text-center text-bold">Ngày lập</th>
		<th class="text-center text-bold">Tháng</th>
		<th class="text-center text-bold">Tổng tiền</th>
		<th class="text-center text-bold">Thanh toán</th>
		<th></th>
	</thead>
	<tbody id="listBillData">
		@foreach($bills as $bill)
		<tr>
			<td class="text-center">{{$bill->bill_id}}</td>
			<td>{{$bill->stu_name}}</td>
			<td>{{$bill->created_at}}</td>
			<td class="text-center">{{$bill->month}}</td>
			<td>{{$bill->bill_total}}</td>
			<td>{{$bill->bill_pay}}</td>
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

							<button type="button" class="btn btn-danger">
								<i class="icon-bin"></i>
							</button>
						</ul>
					</li>
				</ul>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
