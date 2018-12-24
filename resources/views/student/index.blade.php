@extends('template.layout')

@section('title',$title)


@section('content')

@if ($errors->any())
<script>
	$(window).load(function(){
		$('#addStudentModal').modal('show');	
	});
	
</script>
@endif

<div class="control">
	<a data-toggle="modal" href='#addStudentModal'>
		<button class="control-item btn btn-primary pull-right" 
			onclick="createModel('#addStudentModal','add','Thêm học sinh'); ">
			<i class="icon icon-plus3"></i>Thêm Học Sinh
		</button>
	</a>

	<a >
		<button class="control-item btn btn-success pull-right"><i class="icon icon-file-excel"></i>Xuất Excel</button>
	</a>  
</div>

<div class="filter clearfix">
	<div action="" class="form-inline pull-right">
		<div class="form-group has-feedback">
			<input type="text" class="form-control" placeholder="Tìm kiếm ..." name="filterSearch" onkeyup="filterStudent()">
		</div>

		<select name="filterGrade" id="" class="form-control" onchange="filterStudent()">
			<option value="">-- Chọn khối --</option>
			<?php for ($i=1; $i <= 12; $i++) { ?>	
			<option value="{{$i}}">{{$i}}</option>
			<?php } ?>
		</select>
		
		<select name="filterCourse" id="" class="form-control" onchange="filterStudent()">
			<option value="">-- Chọn lớp học --</option>
			@foreach($courses as $course)
			<option value="{{$course->cou_id}}">{{$course->cou_name}}</option>
			@endforeach
		</select>

		<select name="filterWallet" id="" class="form-control" onchange="filterStudent()">
			<option value="">-- Tình trạng</option>
			<option value="-1">Nợ</option>
			<option value="0">Không nợ</option>
			<option value="1">Thừa</option>
		</select>
	</div>
</div>


<div id="dataContent">
@include('student.data')	
</div>


<!--------------------------------------------------------------------------------------------------------------------------------------------------- -->
{{-- STUDENT MODAL --}}
<!---------------------------------------------------------------------------------------------------------------------------------------------------- -->
<div class="modal fade" id="addStudentModal" data-state="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">
					Thêm Học Sinh
				</h4>
			</div>
			<div class="modal-body">

				<form action="{{ route('StudentStore') }}" method="POST" class="form-group" id="addStudentForm">
					@csrf
					<input type="hidden" name="stuId" value="">
					<div class="form-group" >
						<label for="" class="control-label">Họ và Tên</label>	
						<input type="text" placeholder="Họ tên" class="form-control" name="stuName" value="{{ old('stuName') }}">	
						{!! $errors->first('stuName', '<label class="error">:message</label>') !!}	
					</div>

					<div class="row">
						<div class="col-lg-6">
							<label for="">Khối: </label>
							<select name="stuGrade" class="form-control">
								<option value="">-- Chọn khối --</option>
								<?php for ($i=1; $i <= 12; $i++) { ?>
								<option value="{{$i}}" {{ (old('stuGrade') == $i) ? "selected" : "" }} >{{$i}}</option>	
								<?php } ?>
							</select>	
							{!! $errors->first('stuGrade', '<label class="error">:message</label>') !!}
						</div>
						<div class="col-lg-6">
							<label for="">Địa chỉ: </label>
							<input type="text" class="form-control" placeholder="Địa chỉ" name="stuAddress" value="{{ old('stuAddress') }}">
							{!! $errors->first('stuAddress', '<label class="error">:message</label>') !!}
						</div>
						
					</div>	
						
					
					<p class="text-muted line-center-text"><span>Thông tin Phụ Huynh</span></p>
					<div class="form-group">
						<label for="" class="control-label">Họ và Tên</label>	
						<input type="text" placeholder="Họ tên" class="form-control" name="parentName" value="{{ old('parentName') }}" >		
						{!! $errors->first('parentName', '<label class="error">:message</label>') !!}
					</div>
					<div class="form-group">
						<label for="" class="control-label">Số điện thoại</label>	
						<input type="number" placeholder="Số điện thoại" class="form-control" name="parentPhone" value="{{ old('parentPhone') }}">	
						{!! $errors->first('parentPhone', '<label class="error">:message</label>') !!}	
					</div>

					<p class="text-muted line-center-text"><span>Đăng kí Học</span></p>
					
					<div class="row">
					@foreach($courses as $course)
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label><input type="checkbox" name="regCourse[]" value="{{$course->cou_id}}"> {{$course->cou_name}}</label><br>	
						</div>
					@endforeach
					</div>
					{!! $errors->first('regCourse[]', '<label class="error">:message</label>') !!}
					<label for="regCourse[]" class="error"></label>
					
					<div class="text-right">
						<button type="submit" class="btn btn-primary">Xác nhận</button>	
					</div>
					
				</form>

			</div>
		</div>
	</div>
</div>


<!--------------------------------------------------------------------------------------------------------------------------------------------------- -->
{{-- PAY MODAL --}}
<!---------------------------------------------------------------------------------------------------------------------------------------------------- -->


<div class="modal fade" id="payModal" data-state="">
	<div class="modal-dialog" style="width: 90vw">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class=" icon-file-text"></i> Thanh toán</h4>
			</div>
			<div class="modal-body">
				<form action="{{route('BillStore')}}" method="POST" id="payForm">
					@csrf
					<input type="hidden" name="pStuId"  value="">
					<div class="row">
					<div class="col-xs-7 col-sm-7 col-md-9 col-lg-9">
						
						<div class="panel panel-white">
							<div class="panel-heading">
								<h3 class="panel-title text-blue"><i class="icon icon-info22"></i>Thông tin khóa học<a class="heading-elements-toggle"><i class="icon-more"></i></a></h3>
								<div class="heading-elements">
									<ul class="icons-list">
					            		<li><a data-action="collapse"></a></li>
					            		<li><a data-action="reload"></a></li>
					            	</ul>
					        	</div>
							</div>

							<div class="panel-body">

								<table class="table table-hover">
									<thead>
										<th>Tên Lớp</th>
										<th class="w-15">Học phí / buổi</th>
										<th class="w-15">Số buổi học</th>
										<th class="w-15">Khuyến mãi</th>
										<th class="w-15">Tổng tiền</th>
										<th></th>
									</thead>
									<tbody id="payCourseInfo">
										<label for="pTotalLesson[]" class="validation-error-label error"></label>
										<label for="pCouDiscount[]" class="validation-error-label error"></label>	
										
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="col-xs-5 col-sm-5 col-md-3 col-lg-3">

						<div class="panel panel-white">
							<div class="panel-heading">
								<h3 class="panel-title text-blue"><i class="icon icon-info22"></i>Thông tin thanh toán<a class="heading-elements-toggle"><i class="icon-more"></i></a></h3>
								<div class="heading-elements">
									<ul class="icons-list">
					            		<li><a data-action="collapse"></a></li>
					            		<li><a data-action="reload"></a></li>
					            	</ul>
					        	</div>
							</div>

							<div class="panel-body">	
									<div class="form-group row">
										<div class="col-lg-5">
											<label for="" >Đóng học tháng: </label>	
										</div>
										<div class="col-lg-7">
											<select name="billMonth" class="form-control" required="true">
												<option value="">-- Chọn tháng --</option>
												<?php for ($i=1; $i <= 12; $i++) { ?>
												<option value="{{$i}}" >{{$i}}</option>	
												<?php } ?>
											</select>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="validation-error-label valid_err_billMonth"></p>
											<label for="billMonth" class="validation-error-label error"></label>
										</div>
									</div>

									<div class="row form-group">
										<div class="col-lg-5">
											<label for="" >Khuyến mãi: </label>	
										</div>
										<div class="col-lg-7">
											<input type="number" name="billDiscount" min="0" max="100" value="0" class="form-control col-lg-9 pBillDiscount" onkeyup="createTotalBill()" placeholder="%">	
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="validation-error-label valid_err_billDiscount"></p>
											<label for="billDiscount" class="validation-error-label error"></label>
										</div>
									</div>
									
									<div class="row form-group">
										<div class="col-lg-5">
											<label for="" >Tiền thừa/thiếu: </label>	
										</div>
										<div class="col-lg-7">
											<p class="stuWallet"></p>
										</div>
									</div>

									<div class="row form-group">
										<div class="col-lg-5">
											<label for="" >Tổng tiền phải đóng: </label>	
										</div>
										<div class="col-lg-7">
											<input type="text" name="billTotal" class="form-control col-lg-9 totalBill" placeholder="VND" disabled="true">	
										</div>

									</div>
									

									<div class="row form-group">
										<div class="col-lg-5">
											<label for="" >Đã đóng: </label>	
										</div>
										<div class="col-lg-7">
											<input type="text" name="billPay" required="true" value="0" onkeyup="createBillNotify()" class="form-control col-lg-9" placeholder="VND">	
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p class="validation-error-label valid_err_billPay"></p>
											<label for="billPay" class="validation-error-label error"></label>
										</div>
									</div>

									<div class="row form-group">
										<div class="col-lg-5">
											<label for="" >Trả lại: </label>	
										</div>
										<div class="col-lg-7">
											<input type="text" name="billExcess" disabled="true" class="form-control col-lg-9" placeholder="VND">	
										</div>
									</div>
									
									
									<div class="billNotify">
										<div id="walletNotify" class="form-group" style="display: none;">
											<label for=""><input type="checkbox" name="isExcess" value="1"> Đưa tiền thừa vào tài khoản tích lũy ?</label>
										</div>
										<div id="alertNotify"></div>
									</div>
									
							</div>
						</div>
						<div class="clearfix">
							<button type="submit" class="btn btn-primary pull-right" onclick="createBill()">Xác nhận</button>
						</div>
					</div> {{-- /.col5 --}}	
				</div> {{-- /.row --}}
				
				</form>
			</div>			
		</div>
	</div>
</div>
@endsection


{{-- 
<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">
<script type="text/javascript" src="{{ URL::asset('js/datatables.min.js') }}"></script> --}}

@push('css-file')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
@endpush

@push('js-file')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
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

	$("#addStudentForm").validate({
        rules: {
	        stuName : "required",
	        stuGrade : "required",
	        stuAddress : "required",
	        parentName : "required",
	        'regCourse[]' : "required",
	        parentPhone : "required"
        },
        messages: {
        	stuName : "Vui lòng nhập tên !",
        	stuGrade : "Vui lòng chọn một khối !",
	        stuAddress : "Vui lòng nhập địa chỉ !",
	        parentName : "Vui lòng nhập tên phụ huynh !",
	        parentPhone : "Vui lòng nhập số điện thoại phụ huynh !",
	        'regCourse[]': "Vui lòng chọn một khóa học !"
        }

        
    });  

    $("#payForm").validate({
        rules: {
        	"pTotalLesson[]": {
				required: true,
				number: true
			},
			"pCouDiscount[]":{
				number: true,
				min: 0,	
				max:100
			},
			"billMonth":{
				required: true,
				number: true
			},
			"billPay":{
				required: true,
				number: true
			}

	       
        },
        messages: {
        	"pTotalLesson[]": {
				required: 'Tổng số buổi học là bắt buộc !',
				number: 'Tổng số buổi học phải là số !'
			},
			"pCouDiscount[]":{
				number: "Giảm giá phải là số !",
				min: "Giảm giá thấp nhất là 0% !",	
				max: "Giảm giá cao nhất là 100% !"
			},
			"billMonth":{
				required: "Tháng đóng học là bắt buộc !",
				number: "Tháng đóng học phải là số !"
			},
			"billPay":{
				required: 'Tiền đóng học là bắt buộc !',
				number: 'Tiền đóng học phải là số !'
			}

        }

        
    });  

	$.fn.editable.defaults.mode = 'poppup';

	$("body").tooltip({
	    selector: '[data-title]'
	});

	 $("#payForm").submit(function(e){
        e.preventDefault(e);
    });



});

$('#payModal').on('hidden.bs.modal', function () {
    $('#payModal input').val("");
    $('#payModal select').val("");
    $('#payModal textarea').text("");

    $('#payModal #alertNotify').html('');

    $('#payModal #walletNotify').css('display', 'none');
    $('#payModal #walletNotify input[name=isExcess]').prop('checked', false);
    
    $('#payModal #payCourseInfo tr').remove();
    $('#payModal .validation-error-label').text("");
})

$('#payModal').on('show.bs.modal', function () {
    var d = new Date();
    month = d.getMonth();

	$('input[name=billDiscount]').val("0"),
	$('input[name=billPay]').val("0"),
    $('select[name=billMonth] option:eq('+ Number(month + 1)  +')').prop('selected', true);

})

//-----------------------------------------------------------------------------------------------------------------------------------------	   
//Các hàm liên quan đến Tạo HTML
//-----------------------------------------------------------------------------------------------------------------------------------------		     


	    function getCourseToPay()
	    {
	    	var data = [];
	    	$('.pCouItem').each(function(index, elem) {
	    		var item = {};
	    		item['couId']	=	$(this).find('input.payCouId').val();
	    		item['totalLesson'] = $(this).find('input.pTotalLesson').val();		
	    		item['couDiscount'] = $(this).find('input.pCouDiscount').val();		

	    		data.push(item);
	    	});

	    	return data;
	    }

	    function createBillNotify(){
	    	var billPay = Number( $('input[name=billPay]').val() );
	    	var billTotal = Number( _fomatStringToInt($('input[name=billTotal]').val()) );
	    	var billExcess = billPay - billTotal;

	    	if (billExcess <= 0) {
	    		$('input[name=billExcess]').val(""); 
	    	}

	    	if ( billExcess > 0 ) { 
	    		$('input[name=billExcess]').val(billExcess.formatnum()); 
	    	}

	    	if (billPay > billTotal){
	    		$('#walletNotify').css('display', 'block');
	    		$('#alertNotify').html('');
	    	}

	    	if (billPay == billTotal){
	    		$('#walletNotify').css('display', 'none');
	    		$('#alertNotify').html('');		
	    	}

	    	if (billPay < billTotal){
	    		$('#walletNotify').css('display', 'none');
	    		$('#alertNotify').html('<p class="text-danger">Bạn đóng thiếu ! Bạn sẽ bị trừ tiền vào ví !</p>');	
	    	}  

	    }


	    function getPayCourseInfo(stu_id)
	    {
	    	$('#payModal').modal('show');

	    	$.ajax({
	    		url: "{{route('StudentGetOne')}}",
	    		method: 'POST',
	    		data: {
	    			stu_id: stu_id
	    		},
	    		success: function(data){

	    			if (data['success']) 
	    			{
	    				$('input[name=pStuId]').val(stu_id);
	    				var student = data['data']['0'];
	    				var courses = data['data']['0']['courses'];
	    				var html = "";

	    				$('.stuWallet').text( Number(student['stu_wallet']).formatnum() );

	    				courses.forEach( function(elem,index){

	    					html = '<tr id="pCou-'+elem['cou_id']+'" class="pCouItem">'
	    									+'<input type="hidden" class="payCouId" value="'+elem['cou_id']+'">'
	    									+'<td class="payCouName">'+elem['cou_name']+'</td>'
											+'<td class="pCouPrice">'+Number(elem['cou_price']).formatnum()+'</td>'
											+'<td><input type="number" class="form-control pTotalLesson" required="true" name="pTotalLesson[]" onkeyup="createTotalOfCourse('+elem['cou_id']+'); createTotalBill(); "></td>'
											+'<td><input type="number" class="form-control pCouDiscount" min="0" max="100" value="0" name="pCouDiscount[]" onkeyup="createTotalOfCourse('+elem['cou_id']+'); createTotalBill(); " placeholder="%"></td>'
											+'<td><input type="text" class="form-control pCouTotal" placeholder="VND" disabled="true"></td>'
											+'<td class="text-center btn-delete">'
												+'<a href="#" onclick="removePayCourse('+elem['cou_id']+'); return false;"><i class="icon-bin"></i></a>'
											+'</td>'
										+'</tr>'
							$('#payCourseInfo').append(html)
	    				});

	    			}
	    		},
	    		error:function() {
	    			console.log('fail');
	    			
	    		}
	    	});
	    }


	    function createTotalOfCourse(id)
	    {
	    	var totalLesson = $('#pCou-'+id+' .pTotalLesson').val();
	    	var couPrice = Number(_fomatStringToInt( $('#pCou-'+id+' .pCouPrice').text() ));
	    	var discount = $('#pCou-'+id+' .pCouDiscount').val();

	    	var total = (totalLesson * couPrice); 

	    	if (discount > 0 || discount == 100) var total = (totalLesson * couPrice * (1 - discount/100) ); 

	    	$('#pCou-'+id+' .pCouTotal').val(total.formatnum());
	    }



	    function createTotalBill()
	    {
	     	
	     	var domTotalBill = $('#payCourseInfo .pCouTotal');

	     	var wallet = Number(_fomatStringToInt( $('.stuWallet').text() ));
	     	var discount = Number( $('.pBillDiscount').val() );
	     	var total = 0;

	     	for(var i = 0; i < domTotalBill.length; i++) {
	     		total += Number(_fomatStringToInt( $(domTotalBill[i]).val()) );
	     	}

	     	total = total - wallet;

	     	if (discount > 0 || discount == 100) var total = total * (1 - discount/100) ;  

	     	if (total < 0) {total = 0;}

	     	$('.totalBill').val(total.formatnum());
	    }

	    function removePayCourse(id)
	    {
	    	$('#pCou-'+id).remove()
	    }


//-----------------------------------------------------------------------------------------------------------------------------------------	   
//Các hàm liên quan đến thao tác CSDL
//-----------------------------------------------------------------------------------------------------------------------------------------	   
	    function createBill()
	    {
	    	/*Lỗi: đẩy lên server thành công (stt 200) nhưng vẫn đả về error
				Hãy đảm bảo data gửi lên ko null, do việc covert sang kiểu json bị lỗi
	    	*/
	    	var isExcess = $('input[name=isExcess]:checked').val();
	    	var billDiscount = $('input[name=billDiscount]').val();

	    	if (isExcess == '') {isExcess = 0}
	    	if (billDiscount == '') {billDiscount = 0}

	    	var stuId = $('input[name=pStuId]').val();

	    	if ( $("#payForm").valid() ) 
	    	{
    			$.ajax({

		    		url: "{{ route('BillStore') }}",
		    		type: 'POST',
		    		data: {
		    			courses: getCourseToPay(),
		    			stuId: stuId,
		    			billMonth: $('select[name=billMonth]').val(),
		    			billDiscount: $('input[name=billDiscount]').val(),
		    			billPay: $('input[name=billPay]').val(),
		    			isExcess: isExcess
		    		},
		    		success: function(data) {
		    			
		    			if (data['validate'] == false) 
		    			{
		    				
		    				error = data['data'];
		    				
		    				if (typeof error['billMonth'] !== 'undefined')  $('.valid_err_billMonth').text(error['billMonth'][0]);
		    				if (typeof error['billDiscount'] !== 'undefined')  $('.valid_err_billDiscount').text(error['billDiscount'][0]);
		    				if (typeof error['billPay'] !== 'undefined')  $('.valid_err_billPay').text(error['billPay'][0]);
		    				
		    			}

		    			if (data['success']) 
		    			{
		    				var html = "";
		    				if( data['data']['stu_wallet'] < 0 ) 
		    					html = '<p title="Nợ" style="width:70%; font-weight:bold" class="label label-wallet border-left-danger label-striped">'
		    							+Number(data['data']['stu_wallet'] * - 1).formatnum() +'</p>' 

		    				if( data['data']['stu_wallet'] > 0 ) 
		    					html = '<p title="Nợ" style="width:70%; font-weight:bold" class="label label-wallet border-left-primary label-striped">'
		    							+Number(data['data']['stu_wallet']).formatnum() +'</p>' 

		    				if( data['data']['stu_wallet'] == 0 ) 
		    					html = '<p title="Nợ" style="width:70%; font-weight:bold" class="label label-wallet border-left-success label-striped">'
		    							+Number(data['data']['stu_wallet']).formatnum() +'</p>'  



		    				$('#payModal').modal('hide');
		    				$('#stu-' + data['data']['stu_id'] + ' .td-wallet').html(html);
		    				showNotify("",data['msg'],'bg-success');							
		    			} else {
		    				showNotify("",data['msg'],'bg-danger');							
		    			}
		    			 
		    		},	
		    		error:function(data) {
		    			console.log(data);
		    			console.log('error');
		    		}
		    	});
	    	}
	    	
	    	
	     }

	    function filterStudent()
	    {

	    	var grade  = $('select[name="filterGrade"]').val();
	    	var course = $('select[name="filterCourse"]').val();
	    	var search = $('input[name="filterSearch"]').val();
	    	var wallet = $('select[name="filterWallet"]').val();

	    	$.ajax({
	    		url: "{{ route('StudentGetFilter') }}",
	    		method: 'POST',
	    		data: {
	    			stuGrade: grade,
	    			stuSearch: search,
	    			stuCourse: course,
	    			stuWallet: wallet
	    		},
	    		success: function(data){
	    			$('#dataContent').html(data);
	    		
	    		},
	    		error:function() {
	    			console.log('error');	
	    		} 
	    	});
	    }


		function deteleStudent(id)
		{
			if (confirm("Bạn có chắc chắn muốn xóa Học Sinh này !")) {
				$.ajax({
					url: '{{route('DeleteStudent')}}',
					type: 'POST',
					data: {
						stuId: id
					},
					success: function(data) {
						console.log('success');
						
						console.log(data);
						if (data['success']) 
						{
							showNotify("",data['msg'],'bg-success');

							$('#stu-'+id).fadeTo(500,0, function(){
								studentDataTable.rows('#stu-'+id).remove().draw();
							});	
						} else {
							showNotify("",data['msg'],'bg-danger');							
						}
						
					},
					error: function() {
						console.log('error');
						showNotify("",'Xóa Học Sinh thất bại !','bg-danger');
					}
				});
			}
			
		}

	    function getStudentInfo(id)
	    {
	    	
	    	$.ajax({
	    		url: "{{route('StudentGetOne')}}",
	    		method: 'POST',
	    		data: {
	    			stu_id: id
	    		},
	    		success: function(data){
	    			$('#addStudentModal').modal('show');

	    			var student = data['data']['0'];
	    			var courses = data['data']['0']['courses'];

	    			$('input[name="stuId"]').val(student['stu_id']);
	    			$('input[name="stuName"]').val(student['stu_name']);
	    			$('select[name="stuGrade"]').val(student['stu_grade']);
	    			$('input[name="stuAddress"]').val(student['stu_address']);
	    			$('input[name="parentName"]').val(student['parent_name']);
	    			$('input[name="parentPhone"]').val(student['parent_phone']);

	    			
	    			var flag = false;
					var listCheckBox = $("#addStudentModal input[name='regCourse[]']");
				    	
				    for(var i = 0; i < listCheckBox.length; i++)
				    {	
						flag = false;
				    	
				    	courses.forEach( function(element, index) 
				    	{
				    		
							if ($(listCheckBox[i])[0].value == element['cou_id']) 
				  			{
				  				$(listCheckBox[i]).prop('checked',true);
				  				flag = true;
				  			} 
				  					
				    	}.bind(listCheckBox[i]) );
				    	
				    	if (!flag) { $(listCheckBox[i]).prop('checked',false); }
				    }

	    		},
	    		error:function() {
	    			console.log('fail');
	    			
	    		}
	    	});

	    
	    }



</script>

@endpush