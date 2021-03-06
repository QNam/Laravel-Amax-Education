@php
    $brc_main ="Lớp học";
	$brc_active = "Danh sách lớp học";
@endphp
@extends('template.layout')

@section('title',$title)


@section('content')
@if ($errors->any())
<script>
	$(window).load(function(){
		$('#addCourseModal').modal('show');	
		 // $('.coutime-checkbox').prop('checked',false);
	  //   $('.cou-time').css('display','none');
	});
	
</script>
@endif
<div class="panel panel-flat">
<div class="panel-body">
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
</div>
</div>


<style>
	/* Base for label styling */
[type="checkbox"]:not(:checked),
[type="checkbox"]:checked {
  position: absolute;
  left: -9999px;
}
[type="checkbox"]:not(:checked) + label,
[type="checkbox"]:checked + label {
  position: relative;
  padding-left: 1.95em;
  cursor: pointer;
}

/* checkbox aspect */
[type="checkbox"]:not(:checked) + label:before,
[type="checkbox"]:checked + label:before {
  content: '';
  position: absolute;
  left: 0; top: 0;
  width: 1.25em; height: 1.25em;
  border: 1px solid #333;
  background: #fff;
  /*border-radius: 4px;*/
  box-shadow: inset 0 1px 3px rgba(0,0,0,.1);
}
/* checked mark aspect */
[type="checkbox"]:not(:checked) + label:after,
[type="checkbox"]:checked + label:after {
    content: '\2713\0020';
    position: absolute;
    top: .15em;
    left: 0.19em;
    font-size: 1.2em;
    line-height: 0.8;
    color: #1E88E5;
    transition: all .2s;
    font-family: 'Lucida Sans Unicode', 'Arial Unicode MS', Arial;
}
/* checked mark aspect changes */
[type="checkbox"]:not(:checked) + label:after {
  opacity: 0;
  transform: scale(0);
}
[type="checkbox"]:checked + label:after {
  opacity: 1;
  transform: scale(1);
}
</style>

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

					<label for="" class="text-bold">Thời gian học</label>

					<?php for($i = 0; $i < 7; $i++ ) {?>
					
					<div class="row form-group">
						<div class="col-xs-4">
							<label for="" class="checkbox-container">
								<input type="checkbox" name='couTime[{{$i}}][date]' class="coutime-checkbox" value="{{$i}}" id="inpCouTime{{$i}}" 
								{{  ((int)old("couTime.{$i}.date") === $i  ) ? 'checked' : "" }}> 
								<label for="inpCouTime{{$i}}">{{$i == 0 ? "Chủ Nhật" : "Thứ ".($i+1)}}</label>
							</label>	
						</div>

						{{-- === vì tránh trường hợp tự động ép kiểu từ null về 0 --}}
						<div  class="cou-time" style="display: none; {{  (int)old("couTime.{$i}.date") === $i ? 'display: block;' : "" }}
							@if( isset($errors->getMessages()["couTime.{$i}.begin"]) )
								{{'display: block'}}
							@endif 
						">
							<div class="col-lg-4">
								<input type="time" class="form-control"  name="couTime[{{$i}}][begin]" value="{{old('couTime')[$i]['begin']}}">
								{!! $errors->first("couTime.{$i}.begin", '<label class="error">:message</label>') !!}
							</div>

							<div class="col-lg-4">
								<input type="time" name="couTime[{{$i}}][end]" class="form-control" value="{{old('couTime')[$i]['end']}}">
								{!! $errors->first("couTime.{$i}.end", '<label class="error">:message</label>') !!}

							</div>
						</div>
					</div>

					<?php } ?>


					<div class="row form-group">
						<div class="col-lg-6">
							<label for="" class="text-bold">Giá:</label>
							<input type="number" name="couPrice" placeholder="" required="true" class="form-control" value="{{ old('couPrice') }}">	
							{!! $errors->first('couPrice', '<label class="error">:message</label>') !!}
						</div>


						<div class="col-lg-6">
							<label for="" class="text-bold">Khối:</label>

							<select name="couGrade" id="" class="form-control">
								<option value="">-- Chọn khối --</option>
								<?php for($i = 1; $i <= 12; $i++) { ?>		
								<option value="{{$i}}" {{ old('couGrade') == $i ? "Selected" : "" }}>{{$i}}</option>
								<?php } ?>
							</select>
							{!! $errors->first('couGrade', '<label class="error">:message</label>') !!}
						</div>
						
					</div>

					<div class="form-group">
						<label for="" class="text-bold">Mô tả</label>
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


<div class="modal fade" id="modalViewCourse">
	<div class="modal-dialog" style="width: 80vw">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="icon icon-list"></i>  Danh sách học sinh</h4>
			</div>
			<div class="modal-body">
				
				<table id="viewCourseData" class="table table-bordered">
					<thead>
						<th class="text-center text-bold">Stt</th>
						<th class="text-center text-bold">Họ tên</th>
						<th class="text-center text-bold">Khối</th>
						<th class="text-center text-bold">Địa chỉ</th>
						<th class="text-center text-bold">Phụ huynh</th>
						<th class="text-center text-bold">SDT</th>
						<th class="text-center text-bold">Nợ/dư</th>
					</thead>
					<tbody>
						
					</tbody>
				</table>
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
	$('.coutime-checkbox').on('change',function(event) {
		$(this).parent().parent().parent().find('.cou-time').toggle();
	})
	var viewCourseDataTable;

	function setViewCourseDT()
	{
		viewCourseDataTable = $('#viewCourseData').DataTable({
			language: {
		      emptyTable: "<h3>Không tìm thấy dữ liệu !</h3>"
		    }
		});

	    $('.td-wallet p').each(function(index, el) {
	    	var toCash = Number($(el).text()).formatnum();
	    	$(el).text(toCash);
	    	
	    });
	}

	$('#modalViewCourse').on('hidden.bs.modal', function () {
		$('#modalViewCourse table tbody').html(" ");
	   viewCourseDataTable.destroy();
	});

	$('#addCourseModal').on('hidden.bs.modal', function () {
	    $('.coutime-checkbox').prop('checked',false);
	    $('.cou-time').css('display','none');
	})

	
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
    			if (data['success'] == true) 
    			{
    				var course = data['data'];

    				if( course['cou_time'] != null && course['cou_time'].length > 0 ) 
    				{
    					course['cou_time'].forEach(function(value,index)
    					{ 

							$('input[ name="couTime[' + value['date'] + '][date]" ]').prop('checked', true);				    							
							$('input[ name="couTime[' + value['date'] + '][date]" ]').parent().parent().parent().find('.cou-time').css('display', 'block');	

							$('input[ name="couTime[' + value['date'] + '][begin]" ]').val(value['begin'])
							$('input[ name="couTime[' + value['date'] + '][end]" ]').val(value['end'])
    					});
    				}

	    			$('input[name="couId"]').val(course['cou_id']);
	    			$('input[name="couName"]').val(course['cou_name']);
	    			$('select[name="couSubject"]').val(course['cou_subject']);
	    			$('select[name="couTeacher"]').val(course['cou_teacher']);
	    			$('select[name="couClass"]').val(course['cou_class']);
	    			$('select[name="couGrade"]').val(course['cou_grade']);
	    			$('input[name="couPrice"]').val(course['cou_price']);
	    			$('textarea[name="couDesc"]').val(course['cou_desc']);	
    			} 
    		},
    		error:function() {
    			console.log('fail');
    		}
    	})
    }


    function getStudentOfCourse(id)
    {
    	$('#modalViewCourse').modal('show');
    	showLargeLoading('#modalViewCourse .modal-dialog');
    	
    	$.ajax({
    		url: "{{route('StudentGetFilter')}}",
    		method: 'POST',
    		data: {
    			stuCourse: id
    		},
    		success: function(data){
    			$('#viewCourseData tbody').html(data);
    			$('#viewCourseData tbody .stu-render-8').remove();
    			setViewCourseDT();

    			hideOverLoading('#modalViewCourse .modal-dialog');
    		},
    		error:function() {
    			hideOverLoading('#modalViewCourse .modal-dialog');
				showNotify("",'Lỗi lấy dữ liệu !','bg-danger');
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

	    			}  

	    			if (!data['success']){
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