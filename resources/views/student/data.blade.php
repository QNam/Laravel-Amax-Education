<table id="listStudent" class="table table-bordered">
	<thead>
		<th>Stt</th>
		<th>Họ Tên</th>
		<th>Khối</th>
		<th>Địa chỉ</th>
		<th>Phụ huynh</th>
		<th>SDT Phụ Huynh</th>
		<th>Status</th>
		<th></th>
	</thead>
	<tbody>
		<?php $i = 0; ?>
		@foreach ($students as $student)
			
			<tr>
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
				<td class="text-center w-10">
					<span class="label label-success">Active</span>
				</td>	
				<td class="w-15">
					
						<button type="button" class="btn btn-primary">
							<i class="icon-eye"></i>
						</button>
					

						<button type="button" class="btn btn-warning" 
							onclick="getStudentInfo({{$student->stu_id}});
							changeText('#addStudentModal .modal-title','Cập nhật học sinh')">
							<i class="icon-pencil3"></i>
						</button>

					<a href="#">
						<button type="button" class="btn btn-danger">
							<i class="icon-bin"></i>
						</button>
					</a>
				</td>

				
			</tr>


		@endforeach
	</tbody>
</table>

<script>
	$(document).ready( function () {
	    $('#listStudent').DataTable();
	});
</script>