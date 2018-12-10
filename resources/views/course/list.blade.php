@extends('template.layout')

@section('title',$title)


@section('content')

<div class="control">
	<a data-toggle="modal" href='#'>
		<button class="control-item btn btn-info pull-right" 
			onclick="">
			<i class="icon icon-book"></i>Đăng kí học
		</button>
	</a>
	<a data-toggle="modal" href='#addCourseModal'>
		<button class="control-item btn btn-primary pull-right" 
			onclick="clearInput(); changeText('#addCourseModal .modal-title','Thêm khóa học')">
			<i class="icon icon-plus3"></i>Thêm Khóa Học
		</button>
	</a>
	<a >
		<button class="control-item btn btn-success pull-right"><i class="icon icon-file-excel"></i>Xuất Excel</button>
	</a>  

</div>
	<table id="listCourse" class="table table-bordered" style="width: 100%">
		<thead>
			<th>Stt</th>
			<th>Tên khóa học</th>
			<th>Giáo viên</th>
			<th>Lớp</th>
			<th>Môn</th>
			<th>Giá</th>
			<th></th>
			
		</thead>
		<tbody>
			<?php $i = 0; ?>	
			@foreach ($courses as $course)
				<tr>
					<td class="w-5">{{++$i}}</td>
					<td>{{ $course->cou_name }}</td>
					<td>{{ $course->tea_name }}</td>
					<td class="w-5">{{ $course->cou_class }}</td>
					<td class="w-5">{{ $course->sub_name }}</td>
					<td>{{ $course->cou_price }}</td>
					<td class="w-15">						
						<button type="button" class="btn btn-primary" onclick="">
							<i class="icon-eye"></i>
						</button>
					

						<button type="button" class="btn btn-warning" 
							onclick="getCourseInfo({{$course->cou_id}}); 
							changeText('#addCourseModal .modal-title','Cập nhật khóa học');clearInput()">
							<i class="icon-pencil3"></i>
						</button>

						<button type="button" class="btn btn-danger">
							<i class="icon-bin"></i>
						</button>
					</td>

					
				</tr>


			@endforeach
		</tbody>
	</table>


<div class="modal fade" id="addCourseModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">
					Thêm Khóa Học
				</h4>
			</div>
			<div class="modal-body">
				
				<form action="{{ route('CourseStore') }}" method="POST" class="form-group">
					@csrf
					<input type="hidden" name="couId" value="">
					<div class="form-group">
						<label for="" class="control-label">Tên Khóa Học</label>	
						<input type="text" placeholder="" class="form-control" name="couName">		
					</div>

					<div class="row form-group">
						<div class="col-lg-6">
							<label for="">Giáo viên</label>
							<select name="couTeacher" id="" class="form-control">
								<option value="0">-- Chọn Giáo Viên --</option>
								@foreach($teachers as $teacher)
								<option value="{{ $teacher->tea_id }}">{{ $teacher->tea_name }}</option>
								@endforeach
							</select>	
						</div>
						<div class="col-lg-6">
							<label for="">Môn: </label>
							<select name="couSubject" id="" class="form-control">
								<option value="0">-- Chọn môn --</option>
								@foreach($subjects as $subject)
								<option value="{{ $subject->sub_id }}">{{ $subject->sub_name }}</option>
								@endforeach
							</select>	
						</div>
						
					</div>
					<div class="row form-group">
						<div class="col-lg-6">
							<label for="">Giá:</label>
							<input type="text" name="couPrice" placeholder="" class="form-control">	
						</div>
						<div class="col-lg-6">
							<label for="">Lớp: </label>
							<select name="couClass" id="" class="form-control">
								<option value="0">-- Chọn lớp --</option>
								<?php for ($i=1; $i <= 12; $i++) { ?>
									<option value="{{ $i }}">{{ $i }}</option>
								<?php } ?>
							</select>	
						</div>
						
					</div>	

					<div class="form-group">
						<label for="">Mô tả	</label>
						<textarea name="couDesc" class="w-100" cols="10" rows="5"></textarea>
					</div>
						
					<div class="text-right">
						<button type="submit" class="btn btn-primary">Xác nhận</button>	
					</div>
					
				</form>

			</div>
		</div>
	</div>
</div>
@endsection





@push('css-file')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
@endpush

@push('js-file')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

@endpush

@push('js-code')
	
	<script>
		
		$(document).ready( function () {
		    $('#listCourse').DataTable();

			$('.stuName').editable({
				validate:function(value){
			        if($.trim(value) === '')
			        {
			          return 'Trường này không được bỏ trống !';
			        }
			      }
			});
		} );

	    $.fn.editable.defaults.mode = 'poppup';

	    $("body").tooltip({
	        selector: '[data-title]'
	    });
		

	    function getCourseInfo(id)
	    {
	    	$('#addCourseModal').modal('show');
	    	showLargeLoading('#addCourseModal .modal-content');
	    	console.log('a');
	    	$.ajax({
	    		url: "{{route('CourseGetOne')}}",
	    		method: 'POST',
	    		data: {
	    			cou_id: id
	    		},
	    		success: function(data){
	    			console.log('success');
	    			

	    			var course = data['data'];

	    			$('input[name="couId"]').val(course['cou_id']);
	    			$('input[name="couName"]').val(course['cou_name']);
	    			$('select[name="couSubject"]').val(course['cou_subject']);
	    			$('select[name="couTeacher"]').val(course['cou_teacher']);
	    			$('select[name="couClass"]').val(course['cou_class']);
	    			$('input[name="couPrice"]').val(course['cou_price']);
	    			$('textarea[name="couDesc"]').val(course['cou_desc']);

	    		},
	    		error:function() {
	    			console.log('fail');
	    		}
	    	})
	    	hideOverLoading('#addCourseModal .modal-content');
	    }

	    function clearInput()
	    {
	    	$('input[name="couId"]').val('');
	    	$('input[name="couName"]').val('');
			$('select[name="couSubject"]').val(0);
			$('select[name="couTeacher"]').val(0);
			$('select[name="couClass"]').val(0);
			$('input[name="couPrice"]').val('');
			$('textarea[name="couDesc"]').val('');
	    	hideOverLoading('#addCourseModal .modal-content');
	    }




	</script>

@endpush