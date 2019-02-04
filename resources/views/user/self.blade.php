@php
    $brc_main ="Thông tin cá nhân";
	$brc_active = "Cập nhật thông tin";
@endphp
@section('title',$title)
@extends('template.layout')

@section('content')

<div class="panel panel-flat">
<div class="panel-body">

<form action="{{route('SelfStore')}}" method="POST" style="width: 40%">
	@csrf
	<div class="form-group row">
		<div class="col-sm-3">
			<label for="" class="control-label text-bold" style="margin-top: 0.5em">Họ tên:</label>
		</div>
		<div class="col-sm-9">
			<input type="text" placeholder="Họ tên" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name',$self->name) }}" required="true">	
			{!! $errors->first('name', '<label class="error">:message</label>') !!}		
		</div>
	</div>
	
	<div class="form-group row">
		<div class="col-sm-3">
			<label for="" class="control-label text-bold" style="margin-top: 0.5em">Email:</label>
		</div>
		<div class="col-sm-9">
			<input type="email" placeholder="Email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email',$self->email) }}" required="true">	
			{!! $errors->first('email', '<label class="error">:message</label>') !!}		
		</div>
	</div>

	<div class="form-group row">
		<div class="col-sm-3">
			<label for="" class="control-label text-bold" style="margin-top: 0.5em">Mật khẩu cũ:</label>
		</div>
		<div class="col-sm-9">
			<input type="password" placeholder="Mật khẩu cũ" class="form-control {{ $errors->has('opw') ? ' is-invalid' : '' }}" name="opw" value="{{ old('opw') }}">	
			{!! $errors->first('opw', '<label class="error">:message</label>') !!}		
		</div>
	</div>

	<div class="form-group row">
		<div class="col-sm-3">
			<label for="" class="control-label text-bold">Mật khẩu mới:</label>
		</div>
		<div class="col-sm-9">
			<input type="password" placeholder="Mật khẩu mới" class="form-control {{ $errors->has('npw') ? ' is-invalid' : '' }}" name="npw" value="{{ old('npw') }}">	
			{!! $errors->first('npw', '<label class="error">:message</label>') !!}		
		</div>
	</div>

	<div class="form-group row">
		<div class="col-sm-3">
			<label for="" class="control-label text-bold">Nhập lại Mật khẩu mới:</label>
		</div>
		<div class="col-sm-9">
			<input type="password" placeholder="Nhập lại Mật khẩu mới" class="form-control {{ $errors->has('npwr') ? ' is-invalid' : '' }}" name="npwr" value="{{ old('npwr') }}">	
			{!! $errors->first('npwr', '<label class="error">:message</label>') !!}		
		</div>
	</div>
	
	<div class="text-right">
		<button type="submit" class="btn btn-primary">Cập nhật</button>
	</div>
</form>
</div>
</div>

@endsection