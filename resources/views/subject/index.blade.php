@php
    $brc_main ="Môn học";
	$brc_active = "Danh sách môn học";
@endphp
@extends('template.layout')

@section('title',$title)

@section('content')
@if ($errors->any())
<script>
	$(window).load(function(){
		$('#addSubjectModal').modal('show');	
	});
	
</script>
@endif
<div class="panel panel-flat">
<div class="panel-body">
<div class="control">
	<a data-toggle="modal" href='#addSubjectModal'>
		<button class="control-item btn btn-primary pull-right" 
			onclick="createModel('#addSubjectModal','add','Thêm Môn học')";>
			<i class="icon icon-plus3"></i>Thêm Môn học
		</button>
	</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<table id="listSubject" class="table table-bordered" style="width: 100%">
		<thead>
			<th>Stt</th>
			<th>Tên môn</th>
			<th class="w-5"></th>
			
		</thead>
		<tbody>
			<?php $i = 0; ?>	
			@foreach ($subjects as $subject)
				<tr id="sub-{{ $subject->sub_id }}">
					<td class="w-5 text-center">{{++$i}}</td>
					<td>{{ $subject->sub_name }}</td>
					<td style="display: flex">
						<button type="button" class="btn btn-warning" style="margin-right: 10px;" 
							onclick="getSubjetInfo({{$subject->sub_id}}); createModel('#addSubjectModal','update','Cập nhật Môn học');">
							<i class="icon-pencil3"></i>
						</button>
						
						<form action="{{route('SubjectDelete') }}" method="POST" id="formSubject-{{$subject->sub_id}}">
							@csrf
							<input type="hidden" value="{{$subject->sub_id}}" name="subId" required="true">
							<button type="button" class="btn btn-danger" onclick="deleteSubject({{$subject->sub_id}})">
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
</div>



<div class="modal fade" id="addSubjectModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Thêm Môn học</h4>
			</div>
			<div class="modal-body">
				<form action="{{route('SubjectStore')}}" method="POST">
					@csrf
					<input type="hidden" name="subId" required="true" value="">
					<div class="form-group">
						<label for="" class="text-bold">Tên môn</label>
						<input type="text" required="true" name="subName" class="form-control">
					</div>
				<div class="clearfix">
					<button type="submit" class="btn btn-primary pull-right">Cập nhật</button>
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
@endpush


@push('js-code')
    
<script>
	var subjectDataTable;
	$(document).ready( function () {		
		subjectDataTable =  $('#listSubject').DataTable();
	});
</script>

<script>
	function getSubjetInfo(id)
    {
    	$.ajax({
    		url: "{{route('SubjectGetOne')}}",
    		method: 'POST',
    		data: {
    			subId: id
    		},
    		success: function(data){
    			console.log('success');
    			
    			if (data['success']) 
    			{
    				$('#addSubjectModal').modal('show');
    				var subject = data['data'];

	    			$('input[name="subId"]').val(subject['sub_id']);
	    			$('input[name="subName"]').val(subject['sub_name']);

    			} else {
    				showNotify("",data['msg'],'bg-danger');
    			}
    			

    		},
    		error:function() {
    			console.log('fail');
    			showNotify("",'Lấy dữ liệu thất bại !','bg-danger');
    		}
    	})
    }


	function deleteSubject(id)
	{
		if (confirm("Môn học chỉ có thể xóa khi không có lớp nào học Môn học đó ! Bạn chắc chắc Xóa")) 
		{
			$('#formSubject-' + id).submit();
		}


	}
</script>

@endpush
