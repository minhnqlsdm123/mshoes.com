@extends('admin.layouts.admin_master')
@section('content')
<section>
	<a class="btn btn-primary btnAdd" id="btnAdd" style="float: right">
	<i class="fa fa-plus-square" aria-hidden="true"></i>
	<i class="fa fa-list" aria-hidden="true"></i>
</a>
<table class="table table-bordered table-hover" id="tblUser">
	<thead>
		<tr>
			<th>ID</th>
			<th>NAME</th>
			<th>EMAIL</th>
			<th>CREATE AT</th>
			<th>ACTION</th>
		</tr>
	</thead>
	
</table>
</section>
@endsection

@section('script')
<script>
	$(function() {
		$('#tblUser').DataTable({
			processing:true,
			serverSide:true,
			ajax: '{{ route('user-list.dataTable') }}',
			columns:[
				{data: 'id',name: 'id'},
				{data: 'name',name: 'name'},
				{data: 'email',name: 'email'},
				{data: 'created_at',name: 'created_at'},
				{data: 'action',name:'action'}
			]
		})
	})
</script>
@endsection
