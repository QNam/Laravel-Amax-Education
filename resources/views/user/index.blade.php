@php
    $brc_main ="Quản trị viên";
	$brc_active = "Danh sách Quản trị viên";
@endphp
@extends('template.layout')

@section('title',$title)

@section('content')

@if ($errors->any())
<script>
	$(window).load(function(){
		$('#addUserModal').modal('show');	
	});
	
</script>
@endif

<div class="panel panel-flat">
<div class="panel-body">
<div class="control">
	<a data-toggle="modal" href='#addUserModal'>
		<button class="control-item btn btn-primary pull-right">
			<i class="icon icon-plus3"></i>Thêm Quản trị viên
		</button>
	</a>
</div>


<div>
	<table id="listUser" class="table table-bordered">
		<thead>
			<th class="w-5 text-center text-bold">Stt</th>
			<th class="text-center text-bold">Họ tên</th>
			<th class="text-center text-bold">Email</th>
			<th class="text-center text-bold">Quyền hạn</th>
			<th></th>
		</thead>
		<tbody>
			<?php $i = 0;?>
			@foreach($users as $user)
			<tr>
				<td class="text-center">{{++$i}}</td>
				<td>{{$user->name}}</td>
				<td>{{$user->email}}</td>
				<td>{{$user->role == 1 ? "Quản trị viên" : "Người kiểm duyệt"}}</td>
				<td>
					<button type="button" class="btn btn-warning" 
						onclick="getUserInfo({{$user->id}});">
						<i class="icon-pencil3"></i>
					</button>
					<form action="{{route('UserDelete')}}" method="POST" style="display: inline;">
						@csrf
						<input type="hidden" name="id" value="{{ $user->id }}">
						<button type="submit" class="btn btn-danger">
							<i class="icon-bin"></i>
						</button>					
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>


<div class="modal fade" id="addUserModal" data-state="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary-600">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">
					<i class="icon-person"></i> Thêm Quản trị viên
				</h4>
			</div>
			<div class="modal-body">
				
				<form action="{{route('UserStore')}}" method="POST" class="form-group">
					@csrf
					<div class="form-group">
						<label for="" class="control-label text-bold">Họ tên: </label>	
						<input type="text" placeholder="" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}">	
						{!! $errors->first('name', '<label class="error">:message</label>') !!}		
					</div>

					<div class="form-group ">
							<label for="" class="control-label text-bold">Email: </label>	
							<input type="email" required="" placeholder="" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">
							{!! $errors->first('email', '<label class="error">:message</label>') !!}				
					</div>
					
					<div class="form-group">
						<label for="" class="control-label text-bold">Password: </label>	
						<input type="password" placeholder="" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}">	
						{!! $errors->first('password', '<label class="error">:message</label>') !!}		
					</div>	

					<div class="form-group">
						<input type="radio" name="role" value="1" id="adminInp">
						<label for="adminInp" class="control-label text-bold" >Quản trị viên</label>
						<br>
						<input type="radio" name="role" value="2" id="modInp">
						<label for="modInp" class="control-label text-bold">Người kiểm duyệt</label>
						<br>
						{!! $errors->first('role', '<label class="error">:message</label>') !!}	
					</div>		
					
						
					<div class="text-right">
						<button type="submit" class="btn btn-primary">Xác nhận</button>	
					</div>
					
				</form>
		
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="updateUserModal" data-state="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary-600">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">
					<i class="icon-person"></i> Cập nhật Quản trị viên
				</h4>
			</div>
			<div class="modal-body">
				
				<form action="{{route('UserStore')}}" method="POST" class="form-group">
					@csrf
					<input type="hidden" name="id" value="">
					<div class="form-group nameInp">
						<label for="" class="control-label text-bold">Họ tên: </label>	
						<input type="text" placeholder="" class="form-control" name="name" value="">	
						<label for="" class="error"></label>
					</div>

					<div class="form-group emailInp">
						<label for="" class="control-label text-bold">Email: </label>	
						<input type="email" required="" placeholder="" class="form-control" name="email" value="">
						<label for="" class="error"></label>
					</div>
						

					<div class="form-group roleInp">
						<div>
							<input type="radio" name="role" value="1" id="uAdminInp">
							<label for="uAdminInp" class="control-label text-bold" >Quản trị viên</label>	
						</div>
						
						<div>
							<input type="radio" name="role" value="2" id="uModInp">
							<label for="uModInp" class="control-label text-bold">Người kiểm duyệt</label>	
						</div>
						
						<label for="" class="error"></label>
					</div>		
					
						
					<div class="text-right">
						<button type="button" class="btn btn-primary" onclick="ajaxValidate()">Xác nhận</button>	
					</div>
					
				</form>
		
			</div>
		</div>
	</div>
</div>

<script>
	$('#addUserModal').on('hidden.bs.modal', function () {
	    $('#updateUserModal input[type=text]').val("");
	    $('#updateUserModal input[type=email]').val("");
	    $('#addUserModal input[type=radio]').prop("checked",false);
	    $('#addUserModal label.error').text(" ");
	    $('#addUserModal input').removeClass('is-invalid');
	})

	$('#updateUserModal').on('hidden.bs.modal', function () {
	    $('#updateUserModal input[type=text]').val("");
	    $('#updateUserModal input[type=email]').val("");
	    $('#updateUserModal label.error').text(" ");
	    $('#updateUserModal input').removeClass('is-invalid');
	})

	function getUserInfo(id)
	{
		$("#updateUserModal").modal('show');

		showLargeLoading('#updateUserModal .modal-dialog');

		$.ajax({
			url: "{{route('UserGetOne')}}",
			type: 'POST',
			data: {id: id},
			success: function(data){
				console.log();
				if (data['success']) 
				{
					$('#updateUserModal input[name=name]').val(data['data']['name']);
					$('#updateUserModal input[name=id]').val(data['data']['id']);
					$('#updateUserModal input[name=email]').val(data['data']['email']);
					$('#updateUserModal input[name=role][value='+data['data']['role']+']').prop('checked', true);
					hideOverLoading('#updateUserModal .modal-dialog');
				} else {
					hideOverLoading('#updateUserModal .modal-dialog');
					showNotify("",'Không lấy được thông tin quản trị viên !','bg-danger');
				}
			},
			error: function(){
				hideOverLoading('#updateUserModal .modal-dialog');
				showNotify("",'Lỗi lấy dữ liệu !','bg-danger');			
			}
		})
	}

	function ajaxValidate()
	{
		var id = $('#updateUserModal input[name=id]').val();
		var name = $('#updateUserModal input[name=name]').val();
		var email = $('#updateUserModal input[name=email]').val();
		var role = $('#updateUserModal input[name=role]:checked').val();

		$.ajax({
			url: "{{route('UserStore')}}",
			type: 'POST',
			data: {id: id,name:name,email:email,role:role},
			success: function(data){
				console.log(data);

				if(data['validate'] == false) 
				{
					if(typeof data['data']['name'] != "undefined"){ 
						$('.nameInp .error').text(data['data']['name']); 
						$('.nameInp input').addClass('is-invalid');
					}
					if(typeof data['data']['email'] != "undefined"){ 
						$('.emailInp .error').text(data['data']['email']); 
						$('.emailInp input').addClass('is-invalid');
					}
					if(typeof data['data']['role'] != "undefined"){ $('.roleInp .error').text(data['data']['role']); }
				}

				if (data['success'] == true) 
				{
					location.reload();
				}
				//ko dùng else tránh trường hợp data['success'] dính undefined
				if (data['success'] == false) {
					showNotify("",data['msg'],'bg-danger');	
				}
			},
			error: function(){
				showNotify("",'Lỗi lấy dữ liệu !','bg-danger');			
			}
		})
	}

</script>
</div>
</div>

@endsection