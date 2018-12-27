
@csrf
<input type="hidden" name="pStuId"  value="">
<input type="hidden" name="billId"  value="">
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
		
	</div> {{-- /.col5 --}}	
</div> {{-- /.row --}}

</form>

@push('js-code')
<script>
	
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
</script>
<script>
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

	    	return total;
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
</script>
@endpush