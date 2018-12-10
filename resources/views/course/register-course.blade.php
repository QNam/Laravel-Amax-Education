@extends('template.layout')

@section('title',$title)


@section('content')
<div class="col-xs-7 col-sm-7 col-md-8 col-lg-8">
	
</div>

<div class="col-xs-5 col-sm-5 col-md-4 col-lg-4">
	<div class="panel panel-white">
		<div class="panel-heading">
			<h3 class="panel-title text-blue"><i class="icon icon-info22"></i>Thông tin đăng kí<a class="heading-elements-toggle"><i class="icon-more"></i></a></h3>
			<div class="heading-elements">
				<ul class="icons-list">
            		<li><a data-action="collapse"></a></li>
            		<li><a data-action="reload"></a></li>
            		<li><a data-action="close"></a></li>
            	</ul>
        	</div>
		</div>

		<div class="panel-body">
			<form action="" class="form-group">
				<div class="form-group">
					<label for="">Mã hóa đơn</label>
					<input type="text" class="form-control" disabled="true">
				</div>
				<div class="form-group">
					<label for="">Ngày Đăng kí</label>
					<input type="text" class="form-control" disabled="true">
				</div>
				<div class="form-group">
					<label for="">Ghi chú</label>
					<textarea name="" class="w-100" cols="30" rows="5"></textarea>
				</div>
			</form>
		</div>
	</div>

	<div class="panel panel-white">
		<div class="panel-heading">
			<h3 class="panel-title text-blue"><i class="icon icon-info22"></i>Thông tin thanh toán<a class="heading-elements-toggle"><i class="icon-more"></i></a></h3>
			<div class="heading-elements">
				<ul class="icons-list">
            		<li><a data-action="collapse"></a></li>
            		<li><a data-action="reload"></a></li>
            		<li><a data-action="close"></a></li>
            	</ul>
        	</div>
		</div>

		<div class="panel-body">
			<form action="" class="form-group">
				<div class="row form-group">
					<div class="col-lg-5">
						<label for="" >Tổng số buổi học: </label>	
					</div>
					<div class="col-lg-7">
						<input type="text" class="form-control col-lg-9">	
					</div>
				</div>

				<div class="row form-group">
					<div class="col-lg-5">
						<label for="" >Tổng tiền phải đóng: </label>	
					</div>
					<div class="col-lg-7">
						<input type="text" class="form-control col-lg-9">	
					</div>
				</div>

				<div class="row form-group">
					<div class="col-lg-5">
						<label for="" >Đã đóng: </label>	
					</div>
					<div class="col-lg-7">
						<input type="text" class="form-control col-lg-9">	
					</div>
				</div>

			</form>
		</div>
	</div>

</div>
@endsection