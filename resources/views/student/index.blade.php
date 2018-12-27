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
					@include('student.bill-form')	
					<div class="clearfix">
						<button type="submit" class="btn btn-primary pull-right" onclick="createBill()">Xác nhận</button>
					</div>
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
	    		showLargeLoading('#payModal .modal-dialog');
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
							hideOverLoading('#payModal .modal-dialog');
		    				error = data['data'];
		    				
		    				if (typeof error['billMonth'] !== 'undefined')  $('.valid_err_billMonth').text(error['billMonth'][0]);
		    				if (typeof error['billDiscount'] !== 'undefined')  $('.valid_err_billDiscount').text(error['billDiscount'][0]);
		    				if (typeof error['billPay'] !== 'undefined')  $('.valid_err_billPay').text(error['billPay'][0]);

		    				return false;
		    				
		    			}

		    			if (data['success'] == true) 
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


		    				hideOverLoading('#payModal .modal-dialog');
		    				$('#payModal').modal('hide');
		    				$('#stu-' + data['data']['stu_id'] + ' .td-wallet').html(html);
		    				showNotify("",data['msg'],'bg-success');							
		    			} else {
		    				hideOverLoading('#payModal .modal-dialog');
		    				$('#payModal').modal('hide');
		    				showNotify("",data['msg'],'bg-danger');							
		    			}
		    			 
		    		},	
		    		error:function(data) {
		    			hideOverLoading('#payModal .modal-dialog');
						showNotify("",'Lỗi gửi dữ liệu !','bg-danger');	
		    			console.log('error');
		    		}
		    	});
	    	}
	    	
	    	
	     }

	    function filterStudent()
	    {
	    	showLargeLoading('#dataContent');

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
	    			hideOverLoading('#dataContent');
	    		},
	    		error:function() {
	    			console.log('error');	
	    			showNotify("",'Lỗi gửi yếu cầu !','bg-danger');
	    			hideOverLoading('#dataContent');
	    		} 
	    	});
	    }


		function deteleStudent(id)
		{
			if (confirm("Bạn có chắc chắn muốn xóa Học Sinh này !")) {
				showLargeLoading('body');
				$.ajax({
					url: '{{route('DeleteStudent')}}',
					type: 'POST',
					data: {
						stuId: id
					},
					success: function(data) {
						console.log('success');
						
						if (data['success']) 
						{
							showNotify("",data['msg'],'bg-success');

							$('#stu-'+id).fadeTo(500,0, function(){
								studentDataTable.rows('#stu-'+id).remove().draw();
							});
							hideOverLoading('body');	
						} else {
							showNotify("",data['msg'],'bg-danger');							
							hideOverLoading('body');
						}

						
					},
					error: function() {
						console.log('error');
						hideOverLoading('body');
						showNotify("",'Xóa Học Sinh thất bại !','bg-danger');

					}
				});
			}
			
		}

	    function getStudentInfo(id)
	    {
	    	showLargeLoading('#addStudentModal .modal-dialog');
	    	$('#addStudentModal').modal('show');
	    	$.ajax({
	    		url: "{{route('StudentGetOne')}}",
	    		method: 'POST',
	    		data: {
	    			stu_id: id
	    		},
	    		success: function(data)
	    		{
	    			if (data['success'] == true) 
	    			{
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
					    hideOverLoading('#addStudentModal .modal-dialog');
	    			} else {
	    				showNotify("",'Lấy dữ liệu thất bại','bg-danger');
	    				hideOverLoading('#addStudentModal .modal-dialog');	
	    			}

	    		},
	    		error:function() 
	    		{
	    			console.log('fail');
	    			showNotify("",'Gửi dữ liệu thất bại !','bg-danger');
	    			hideOverLoading('#addStudentModal .modal-dialog');
	    			$('#addStudentModal').modal('hide');
	    		}
	    	});
	    	
	    
	    }



</script>

@endpush