@extends('template.layout')

@section('title',$title)


@section('content')
@if ($errors->any())
<script>
	$(window).load(function(){
		$('#addTeacherModal').modal('show');	
	});
	
</script>
@endif
<div class="panel panel-flat">
<div class="panel-body">
<div class="control">
	<a data-toggle="modal" href='#addTeacherModal'>
		<button class="control-item btn btn-primary pull-right" 
			onclick="createModel('#addTeacherModal','add','Thêm Giáo Viên')">
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
		<th>Chủ nhiệm lớp</th>
		<th>SDT</th>
		<th>Địa chỉ</th>
		<th>Nơi công tác</th>
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
			<td>{{ $teacher->tea_address }}</td>
			<td>{{ $teacher->tea_office }}</td>
			<td class="w-15">							
				<button type="button" class="btn btn-warning" 
					onclick="getTeacherInfo({{$teacher->tea_id}}); 
					createModel('#addTeacherModal','update','Cập nhật Giáo Viên')">
					<i class="icon-pencil3"></i>
				</button>
				<form action="{{route('TeacherDelete')}}" method="POST" class=.formDeleteTeacher" style="display: inline;">
					@csrf
					<input type="hidden" name="teaId" value="{{ $teacher->tea_id }}">
					<button type="submit" class="btn btn-danger" onclick="deleteTeacher()">
						<i class="icon-bin"></i>
					</button>					
				</form>

			</td>
		</tr>
		@endforeach
	</tbody>
</table>

</div>
</div>


<div class="modal fade" id="addTeacherModal" data-state="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary-600">
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
						<label for="" class="control-label text-bold">Tên giáo viên: </label>	
						<input type="text" placeholder="" required="true" class="form-control" name="teaName" value="{{ old('teaName') }}">	
						{!! $errors->first('teaName', '<label class="error">:message</label>') !!}		
					</div>

					<div class="form-group">
							<label for="" class="control-label text-bold">SDT: </label>	
							<input type="number" required="" placeholder="" class="form-control" name="teaPhone" value="{{ old('teaPhone') }}">
							{!! $errors->first('teaPhone', '<label class="error">:message</label>') !!}				
					</div>
					
					<div class="form-group">
						<label for="" class="control-label text-bold">Địa chỉ </label>	
						<input type="text" placeholder="" class="form-control" name="teaAddress" value="{{ old('teaAddress') }}">	
						{!! $errors->first('teaAddress', '<label class="error">:message</label>') !!}		
					</div>
					<div class="form-group">
						<label for="" class="control-label text-bold">Nơi công tác: </label>	
						<input type="text" placeholder="" class="form-control" name="teaOffice" value="{{ old('teaOffice') }}">	
						{!! $errors->first('teaOffice', '<label class="error">:message</label>') !!}		
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
	    $('#listTeacher').DataTable();
	});	    

	function deleteTeacher()
	{
		
		if ( confirm("Giáo viên sẽ không thể xóa khi vẫn chủ nhiệm 1 lớp ! Bạn chắc chắn xóa ?") ) 
		{
			$(this).parent().submit();
		}
	}

    function getTeacherInfo(id)
    {
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
    			$('input[name="teaAddress"]').val(teacher['tea_address']);
    			$('input[name="teaOffice"]').val(teacher['tea_office']);

    		},
    		error:function() {
    			console.log('fail');
    		}
    	})
    	hideOverLoading('#addTeacherModal .modal-content');
    }




</script>

@endpush