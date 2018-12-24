<table id="listStudent" class="table table-bordered">

	<thead>
		<th class="text-center">Stt</th>
		<th class="text-center">Họ Tên</th>
		<th class="text-center">Khối</th>
		<th class="text-center">Địa chỉ</th>
		<th class="text-center">Phụ huynh</th>
		<th class="text-center">SDT Phụ Huynh</th>
		<th class="text-center">Nợ/dư</th>
		<th></th>
	</thead>
	<tbody>
		<?php $i = 0; ?>

		@foreach ($students as $key => $student)
				
			<tr id="stu-{{ $student->stu_id }}">
				<td class="text-center w-5"><?=++$i ?></td>
				<td>
					<a href="" class="stuName" 
						data-type="text" 
						data-pk="{{$student->stu_id}}" 
						data-url="{{ route('StudentEditName') }}" 
						data-title="Click vào để sửa">
						{{ $student->stu_name }}</a>	
				</td>
				<td class="text-center w-5">{{ $student->stu_grade }}</td>	
				<td>{{ $student->stu_address }}</td>	
				<td>{{ $student->parent_name }}</td>	
				<td>{{ $student->parent_phone }}</td>
				<td class="text-center td-wallet"> 
					{!! $student->stu_wallet == 0 ? "<p title='Nộp đủ' style='width:70%; font-weight:bold' class='label label-wallet border-left-success label-striped' > $student->stu_wallet </p>" : "" !!}
					{!! $student->stu_wallet > 0 ? "<p title='Thừa' style='width:70%; font-weight:bold' class='label label-wallet border-left-primary label-striped' > $student->stu_wallet </p>" : "" !!}
					{!! $student->stu_wallet < 0 ? "<p title='Nợ' style='width:70%; font-weight:bold' class='label label-wallet border-left-danger label-striped' >". ($student->stu_wallet * -1) ."</p>" : "" !!}
				</td>
				<td class="w-5 text-center">
					<ul class="icons-list pull-left">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-menu9"></i>
							</a>

							<ul class="dropdown-menu dropdown-menu-right" style="padding: 10px; width: 220px;">
								<button type="button" class="btn btn-primary">
									<i class="icon-eye"></i>
								</button>
							

								<button type="button" class="btn btn-warning" 
									onclick="getStudentInfo({{$student->stu_id}}); createModel('#addStudentModal','update','Cập nhật học sinh');">
									<i class="icon-pencil3"></i>
								</button>

								<button type="button" class="btn btn-danger" onclick="deteleStudent( {{$student->stu_id}} )">
									<i class="icon-bin"></i>
								</button>
								<button type="button" class="btn btn-success" onclick="getPayCourseInfo( {{$student->stu_id}} )">
										<i class="icon-cash"></i>
									</button>
							</ul>
						</li>
					</ul>	
				</td>

				
			</tr>


		@endforeach
	</tbody>
</table>

<script>
	var studentDataTable;
	$(document).ready( function () {
	    studentDataTable = $('#listStudent').DataTable({
	    	searching: false,
	    	lengthChange: false,
	    	language: {
		      emptyTable: "<h3>Không tìm thấy dữ liệu !</h3>"
		    }
	    });

	    $('.td-wallet p').each(function(index, el) {
	    	var toCash = Number($(el).text()).formatnum();
	    	$(el).text(toCash);
	    	
	    });
	});

	
</script>