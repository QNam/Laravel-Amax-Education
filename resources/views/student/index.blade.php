@extends('template.layout')

@section('title',$title)


@section('content')

<div class="control">
	<a data-toggle="modal" href='#addStudentModal'>
		<button class="control-item btn btn-primary pull-right" 
			onclick="clearInput(); changeText('#addStudentModal .modal-title','Thêm học sinh')">
			<i class="icon icon-plus3"></i>Thêm Học Sinh
		</button>
	</a>

	<a >
		<button class="control-item btn btn-success pull-right"><i class="icon icon-file-excel"></i>Xuất Excel</button>
	</a>  
</div>
<div class="filter pull-right">
	<form action="" class="form-inline">
		<select name="filterGrade" id="" class="form-control">
			<option value="">-- Chọn khối --</option>
			<?php for ($i=1; $i <= 12; $i++) { ?>	
			<option value="{{$i}}">{{$i}}</option>
			<?php } ?>
		</select>
		<select name="filterCourse" id="" class="form-control">
			<option value="">-- Chọn khóa học --</option>
			@foreach($courses as $course)
			<option value="{{$course->cou_id}}">{{$course->cou_name}}</option>
			@endforeach
		</select>
		<button type="button" class="btn btn-primary" onclick="filterStudent()">Lọc</button>
	</form>
</div>


<div id="dataContent">
@include('student.data')	
</div>


@endsection



<div class="modal fade" id="addStudentModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">
					Thêm Học Sinh
				</h4>
			</div>
			<div class="modal-body">
				
				<form action="{{ route('StudentStore') }}" method="POST" class="form-group">
					@csrf
					<input type="hidden" name="stuId" value="">
					<div class="form-group">
						<label for="" class="control-label">Họ và Tên</label>	
						<input type="text" placeholder="Họ tên" class="form-control" name="stuName">		
					</div>

					<div class="row">
						<div class="col-lg-6">
							<label for="">Khối: </label>
							<select name="stuGrade" id="" class="form-control">
								<option value="0">-- Chọn khối --</option>
								<?php for ($i=1; $i <= 12; $i++) { ?>
								<option value="{{$i}}">{{$i}}</option>	
								<?php } ?>
							</select>	
						</div>
						<div class="col-lg-6">
							<label for="">Địa chỉ: </label>
							<input type="text" class="form-control" placeholder="Địa chỉ" name="stuAddress">
						</div>
						
					</div>	
						
					
					<p class="text-muted line-center-text"><span>Thông tin Phụ Huynh</span></p>
					<div class="form-group">
						<label for="" class="control-label">Họ và Tên</label>	
						<input type="text" placeholder="Họ tên" class="form-control" name="parentName">		
					</div>
					<div class="form-group">
						<label for="" class="control-label">Số điện thoại</label>	
						<input type="text" placeholder="Số điện thoại" class="form-control" name="parentPhone">		
					</div>

					<p class="text-muted line-center-text"><span>Đăng kí Học</span></p>

					@foreach($courses as $course)
						<label><input type="checkbox" name="regCourse[]" value="{{$course->cou_id}}"> {{$course->cou_name}}</label><br>
					@endforeach
					
					<div class="text-right">
						<button type="submit" class="btn btn-primary">Xác nhận</button>	
					</div>
					
				</form>

			</div>
		</div>
	</div>
</div>

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



	    function filterStudent()
	    {

	    	var grade  = $('select[name="filterGrade"]').val();
	    	var course = $('select[name="filterCourse"]').val();

	    	$.ajax({
	    		url: "{{ route('StudentGetFilter') }}",
	    		method: 'POST',
	    		data: {
	    			stuGrade: grade,
	    			stuCourse: course
	    		},
	    		success: function(data){
	    			console.log('success');

	    			console.log(data);
	    			$('#dataContent').html(data);
	    			

	    		},
	    		error:function() {
	    			console.log('error');	

	    		} 
	    	});
	    }
		

	    function getStudentInfo(id)
	    {
	    	console.log('a');
	    	$.ajax({
	    		url: "{{route('StudentGetOne')}}",
	    		method: 'POST',
	    		data: {
	    			stu_id: id
	    		},
	    		success: function(data){
	    			console.log('success');
	    			$('#addStudentModal').modal('show');

	    			var student = data['data'];

	    			$('input[name="stuId"]').val(student['stu_id']);
	    			$('input[name="stuName"]').val(student['stu_name']);
	    			$('input[name="parentName"]').val(student['parent_name']);
	    			$('input[name="parentPhone"]').val(student['parent_phone']);

	    	// 		new PNotify({
						//     title: '',
				  //           text: 'Cập nhật thông tin thành công !',
				  //           addclass: 'bg-success',
				  //           icon:''
						// })
	    		},
	    		error:function() {
	    			console.log('fail');
	    			
	    		}
	    	})
	    
	    }

	    function clearInput()
	    {
	    	$('input[name="stuId"]').val('');
			$('input[name="stuName"]').val('');
			$('input[name="parentName"]').val('');
			$('input[name="parentPhone"]').val('');
	    }



	</script>

@endpush