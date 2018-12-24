@extends('template.layout')

@section('title',$title)


@section('content')
@if ($errors->any())
<script>
	$(window).load(function(){
		$('#addCourseModal').modal('show');	
	});
	
</script>
@endif

<div class="control">
	<a data-toggle="modal" href='#addCourseModal'>
		<button class="control-item btn btn-primary pull-right" 
			onclick="createModel('#addCourseModal','add','Thêm khóa học')";>
			<i class="icon icon-plus3"></i>Thêm Khóa Học
		</button>
	</a>
	<a >
		<button class="control-item btn btn-success pull-right"><i class="icon icon-file-excel"></i>Xuất Excel</button>
	</a>  

</div>

<div id="dataContent">
@include('course.data')	
</div>	


<div class="modal fade" id="addCourseModal" data-state="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary-600">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">
					Thêm Khóa Học
				</h4>
			</div>
			<div class="modal-body">
				
				<form action="{{ route('CourseStore') }}" id="formAddCourse" method="POST" class="form-group">
					@csrf
					<input type="hidden" name="couId" value="">
					<div class="form-group">
						<label for="" class="text-bold">Tên Khóa Học</label>	
						<input type="text" placeholder="" class="form-control" name="couName" required="true" value="{{ old('couName') }}">
						{!! $errors->first('couName', '<label class="error">:message</label>') !!}		
					</div>

					<div class="row form-group">
						<div class="col-lg-6">
							<label for="" class="text-bold">Giáo viên</label>
							<select name="couTeacher" required="true" class="form-control">
								<option value="">-- Chọn Giáo Viên --</option>
								@foreach($teachers as $teacher)
								<option value="{{ $teacher->tea_id }}" {{ (old('couTeacher') == $teacher->tea_id) ? "selected" : "" }}>{{ $teacher->tea_name }}</option>
								@endforeach
							</select>
							{!! $errors->first('couTeacher', '<label class="error">:message</label>') !!}	
						</div>


						<div class="col-lg-6">
							<label for="" class="text-bold">Môn: </label>
							<select name="couSubject" required="true" class="form-control">
								<option value="">-- Chọn môn --</option>
								@foreach($subjects as $subject)
								<option value="{{ $subject->sub_id }}" {{ (old('couSubject') == $subject->sub_id) ? "selected" : "" }}>{{ $subject->sub_name }}</option>
								@endforeach
							</select>
							{!! $errors->first('couSubject', '<label class="error">:message</label>') !!}	
						</div>
						
					</div>
					<div class="form-group">
							<label for="" class="text-bold">Giá:</label>
							<input type="number" name="couPrice" placeholder="" required="true" class="form-control" value="{{ old('couPrice') }}">	
							{!! $errors->first('couPrice', '<label class="error">:message</label>') !!}
					</div>	

					<div class="form-group">
						<label for="" class="text-bold">Mô tả	</label>
						<textarea name="couDesc" class="w-100" cols="10" rows="5">{{ old('couDesc') }}</textarea>
						{!! $errors->first('couDesc', '<label class="error">:message</label>') !!}
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
@endpush

@push('js-file')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
@endpush

@push('js-code')
<script>
	$(document).ready( function () {

		

	});
</script>
<script>

    function getCourseInfo(id)
    {
    	$('#addCourseModal').modal('show');
    	
    	$.ajax({
    		url: "{{route('CourseGetOne')}}",
    		method: 'POST',
    		data: {
    			cou_id: id
    		},
    		success: function(data){
    			console.log('success');
    			

    			if (data['success']) 
    			{
    				var course = data['data'];

	    			$('input[name="couId"]').val(course['cou_id']);
	    			$('input[name="couName"]').val(course['cou_name']);
	    			$('select[name="couSubject"]').val(course['cou_subject']);
	    			$('select[name="couTeacher"]').val(course['cou_teacher']);
	    			$('select[name="couClass"]').val(course['cou_class']);
	    			$('input[name="couPrice"]').val(course['cou_price']);
	    			$('textarea[name="couDesc"]').val(course['cou_desc']);	
    			}
    			

    		},
    		error:function() {
    			console.log('fail');
    		}
    	})
    }


    function deleteCourse(id)
    {
    	if ( confirm('Khóa học chỉ có thể XÓA khi không còn học sinh nào. Bạn chắc chắn XÓA ?') ) 
    	{
	    	$.ajax({
	    		url: "{{route('CourseDelete')}}",
	    		method: 'POST',
	    		data: {
	    			couId: id
	    		},
	    		success: function(data){
	    			console.log('success');
	    			

	    			if (data['success']) 
	    			{
	    				showNotify("",data['msg'],'bg-success');

						$('#cou-'+id).fadeTo(500,0, function(){
							courseDataTable.rows('#cou-'+id).remove().draw();
						});

	    			} else {
						showNotify("",data['msg'],'bg-danger');	    				
	    			}
	    			

	    		},
	    		error:function() {
	    			console.log('fail');
	    			showNotify("",'Xóa khóa học thất bại','bg-danger');	
	    		}
	    	})
    	}
    }

</script>

@endpush