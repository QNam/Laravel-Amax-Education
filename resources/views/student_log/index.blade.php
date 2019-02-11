@php
    $brc_main ="Lưu trữ";
	$brc_active = "Danh sách Học Sinh cũ";
@endphp
@extends('template.layout')

@section('title',$title)

@section('content')
<div class="panel panel-flat">
<div class="panel-body">
	<table id="listLogStudent" class="table table-bordered">
		<thead>
			<th class="text-center text-bold">ID</th>
			<th class="text-center text-bold">Họ Tên</th>
			<th class="text-center text-bold">Khối</th>
			<th class="text-center text-bold">Địa chỉ</th>
			<th class="text-center text-bold">Phụ huynh</th>
			<th class="text-center text-bold">SDT Phụ Huynh</th>
			<th class="text-center text-bold">Ngày nhập học</th>
			{{-- <th class="text-center">Nợ/dư</th> --}}
			<th></th>
		</thead>
		<tbody>
			@foreach($slogs as $slog)
				<tr>
					<td class="w-5 text-center">{{$slog->stu_id}}</td>
					<td>{{$slog->stu_name}}</td>
					<td>{{$slog->stu_grade}}</td>
					<td>{{$slog->stu_address}}</td>
					<td>{{$slog->parent_name}}</td>
					<td>{{$slog->parent_phone}}</td>
					<td>{{$slog->reg_day}}</td>
					<td></td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
</div>
@endsection
@push('css-file')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    {{-- <link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}"> --}}
@endpush

@push('js-file')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	{{-- <script type="text/javascript" src="{{ URL::asset('js/datatables.min.js') }}"></script>  --}}
@endpush

@push('js-code')
	
<script>
var studentLogDataTable;

function setStudentLogDataTable()
{
	studentLogDataTable = $('#listLogStudent').DataTable({
		searching: true,
		lengthChange: true,
		language: {
	      emptyTable: "<h3>Không tìm thấy dữ liệu !</h3>"
	    }
	});
}

$(document).ready( function () {
	setStudentLogDataTable();	
})
</script>

@endpush