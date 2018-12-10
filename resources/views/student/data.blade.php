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

	<table id="listStudent" class="table table-bordered" style="width: 100%">
		<thead>
			<th>Stt</th>
			<th>Họ Tên</th>
			<th>Lớp</th>
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
					<td class="text-center w-5">{{ $student->stu_class }}</td>	
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
							<label for="">Lớp: </label>
							<select name="stuClass" id="" class="form-control">
								<option value="0">-- Chọn lớp --</option>
								<option value="1">1</option>
							</select>	
						</div>
						{{-- <div class="col-lg-6">
							<label for="">Lớp: </label>
							<select name="" id="" class="form-control">
								<option value="0">-- Chọn lớp --</option>
								<option value="1">1</option>
							</select>	
						</div> --}}
						
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
		    $('#listStudent').DataTable();

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
		

	    function getStudentInfo(id)
	    {
	    	showLargeLoading('#addStudentModal .modal-content');
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
	    	hideOverLoading('#addStudentModal .modal-content');
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