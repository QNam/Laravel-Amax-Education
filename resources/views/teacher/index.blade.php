@extends('template.layout')

@section('title',$title)


@section('content')

<div class="control">
	<a data-toggle="modal" href='#addTeacherModal'>
		<button class="control-item btn btn-primary pull-right" 
			onclick="clearInput(); changeText('#addTeacherModal .modal-title','Thêm giáo viên')">
			<i class="icon icon-plus3"></i>Thêm giáo viên
		</button>
	</a>

	<a >
		<button class="control-item btn btn-success pull-right"><i class="icon icon-file-excel"></i>Xuất Excel</button>
	</a>  
</div>

<table id="listTeacher" class="table table-bordered" style="width: 100%">
	<thead>
		<th>Stt</th>
		<th>Họ Tên</th>
		<th>Khóa học</th>
		<th>SDT</th>
		<th>Status</th>
		<th></th>
	</thead>
	<tbody>
		<?php $i = 0?>
		@foreach($teachers as $teacher)
		<tr>
			<td class="w-5">{{ ++$i }}</td>
			<td>{{ $teacher->tea_name }}</td>
			<td>
				@foreach($teacher->courses as $course)
					<p><a href="javascript::void(0)" onclick="getCourseInfo({{$course->cou_id}})">{{$course->cou_name}}</a></p>
				@endforeach

			</td>
			<td>{{ $teacher->tea_phone }}</td>
			<td></td>
			<td class="w-15">						
				<button type="button" class="btn btn-primary" onclick="">
					<i class="icon-eye"></i>
				</button>
			

				<button type="button" class="btn btn-warning" 
					onclick="getTeacherInfo({{$teacher->tea_id}}); 
					changeText('#addTeacherModal .modal-title','Cập nhật Giáo Viên')">
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



<div class="modal fade" id="addTeacherModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">
					Thêm Giáo Viên
				</h4>
			</div>
			<div class="modal-body">
				
				<form action="{{route('TeacherStore')}}" method="POST" class="form-group">
					@csrf
					<input type="hidden" name="teaId" value="">
					<div class="form-group">
						<label for="" class="control-label">Tên giáo viên: </label>	
						<input type="text" placeholder="" class="form-control" name="teaName">		
					</div>
					<div class="form-group">
						<label for="" class="control-label">SDT: </label>	
						<input type="text" placeholder="" class="form-control" name="teaPhone">		
					</div>
					
					<div class="courseList">
						
						
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
	    $('#listTeacher').DataTable();
	});	    
	
   

    function clearInput()
    {
    	$('.courseList p').remove();
    	$('.courseList').append('<p class="text-muted line-center-text"><span>Danh sách khóa học</span></p>');
    }
    
    // $('#addTeacherModal').modal('show');



    function getTeacherInfo(id)
    {
    	clearInput();

    	$('#addTeacherModal').modal('show');
    	showLargeLoading('#addTeacherModal .modal-content');
    	console.log('a');
    	$.ajax({
    		url: "{{route('TeacherGetOne')}}",
    		method: 'POST',
    		data: {
    			tea_id: id
    		},
    		success: function(data){
    			console.log('success');
    			

    			var teacher = data['data'];
    			console.log(teacher);

    			$('input[name="teaId"]').val(teacher['tea_id']);
    			$('input[name="teaName"]').val(teacher['tea_name']);
    			$('input[name="teaPhone"]').val(teacher['tea_phone']);

    			 
    			
    			teacher['courses'].forEach( function(elem, index) {
    				$('.courseList').append('<p> + '+elem['cou_name']+'</p>');	
    			});

    		},
    		error:function() {
    			console.log('fail');
    		}
    	})
    	hideOverLoading('#addTeacherModal .modal-content');
    }




</script>

@endpush