<table id="listCourse" class="table table-bordered" style="width: 100%">
		<thead>
			<th>Stt</th>
			<th>Tên lớp học</th>
			<th>Giáo viên</th>
			<th>Môn</th>
			<th>Giá</th>
			<th>Số HS</th>
			<th></th>
			
		</thead>
		<tbody>
			<?php $i = 0; ?>	
			@foreach ($courses as $course)
				<tr id="cou-{{ $course->cou_id }}">
					<td class="w-5 text-center">{{++$i}}</td>
					<td>{{ $course->cou_name }}</td>
					<td>{{ $course->tea_name }}</td>
					<td class="w-5">{{ $course->sub_name }}</td>
					<td>{{ $course->cou_price }}</td>
					<td class="text-center w-5">{{ $course->num_student }}</td>
					<td class="w-15">						
						<button type="button" class="btn btn-primary" onclick="">
							<i class="icon-eye"></i>
						</button>
					

						<button type="button" class="btn btn-warning" 
							onclick="getCourseInfo({{$course->cou_id}}); createModel('#addCourseModal','update','Cập nhật khóa học');">
							<i class="icon-pencil3"></i>
						</button>

						<button type="button" class="btn btn-danger" onclick="deleteCourse({{ $course->cou_id }})">
							<i class="icon-bin"></i>
						</button>
					</td>

					
				</tr>


			@endforeach
		</tbody>
	</table>

	<script>
		var courseDataTable;
		$(document).ready( function () {
		   courseDataTable =  $('#listCourse').DataTable();
		});

	</script>