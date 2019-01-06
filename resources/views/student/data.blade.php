
	
		<?php $i = 0; ?>

		@foreach ($students as $key => $student)
				
			<tr id="stu-{{ $student->stu_id }}" class="cursor-pointer">
				<td class="text-center w-5 stu-render-1"><?=++$i ?></td>
				<td class="stu-render-1">
					<a href="javascript:void(0)" class="stuName" 
						data-type="text" 
						data-pk="{{$student->stu_id}}" 
						data-url="{{ route('StudentEditName') }}" 
						data-title="Click vào để sửa">
						{{ $student->stu_name }}</a>	
				</td>
				<td class="text-center w-5 stu-render-3">{{ $student->stu_grade }}</td>	
				<td class=" stu-render-4">{{ $student->stu_address }}</td>	
				<td class=" stu-render-5">{{ $student->parent_name }}</td>	
				<td class=" stu-render-6">{{ $student->parent_phone }}</td>
				<td class="text-center td-wallet stu-render-7"> 
					{!! $student->stu_wallet == 0 ? "<p title='Nộp đủ' style='width:70%' class='label label-wallet text-bold border-left-success label-striped' > $student->stu_wallet </p>" : "" !!}
					{!! $student->stu_wallet > 0 ? "<p title='Thừa' style='width:70%' class='label label-wallet text-bold border-left-primary label-striped' > $student->stu_wallet </p>" : "" !!}
					{!! $student->stu_wallet < 0 ? "<p title='Nợ' style='width:70%' class='label label-wallet text-bold border-left-danger label-striped' >". ($student->stu_wallet * -1) ."</p>" : "" !!}
				</td>
				<td class="w-5 text-center stu-render-8">
					<ul class="icons-list pull-left">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-menu9"></i>
							</a>

							<ul class="dropdown-menu dropdown-menu-right" style="padding: 10px; width: 220px;">
								<button type="button" class="btn btn-primary" onclick="getDetailStudentInfo({{ $student->stu_id }});">
									<i class="icon-eye"></i>
								</button>
								<button type="button" class="btn btn-warning" 
									onclick="getStudentInfo({{$student->stu_id}}); createModel('#addStudentModal','update','Cập nhật học sinh');">
									<i class="icon-pencil3"></i>
								</button>

								<button type="button" class="btn btn-danger" onclick="deteleStudent( {{$student->stu_id}} )">
									<i class="icon-bin"></i>
								</button>
								<button type="button" class="btn btn-success" onclick="getPayCourseInfo( {{$student->stu_id}} )">
										<i class="icon-cash"></i>
									</button>
							</ul>
						</li>
					</ul>	
				</td>

				
			</tr>

		@endforeach

	
