@extends('admin.layouts.admin_master')
@section('style')
<style type="text/css">
	.selectColor{
		width: 100% !important;
		height: 20px !important;
		border: 1px solid;
	}
</style>
@endsection
@section('content')
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Table of Color</h3>
					<a class="btn btn-primary " data-toggle="modal" id='btnAdd' style="float: right">&nbsp;
						<i class="fa fa-plus-square" aria-hidden="true"></i>
						<i class="fa fa-list" aria-hidden="true"></i>
					</a>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-hover table-bordered" id="tblColor">
						<thead>
							<tr>
								<th width="5%" class="text-center">ID</th>
								<th class="text-center" width="20%">Color</th>
								<th class="text-center" width="20%">Code</th>
								<th class="text-center" width="20%">Created at</th>
								<th class="text-center" width="15%">Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->	

<!-- /.content -->


{{-- modal Add --}}
<div class="modal fade" id="modalAdd">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add new Color</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST" role="form" id="formAdd">
					@csrf
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="color" placeholder="Name" name="color">
					</div>
					<div class="form-group">
						<label for="">Color</label>
						<input type="color" class="form-control" id="code" name="code">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Create</button>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>
</secti	on>
<!-- /.content -->
@endsection

@section('script')
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(function() {
		$('#tblColor').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{!! route('admin_color.dataTable') !!}',
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'color', name: 'color' },
			{ data: 'code', name: 'code' },
			{ data: 'created_at', name: 'created_at' },
			{ data: 'action', name: 'action', orderable: false, searchable: false}
			]
		});
	});

	$('#btnAdd').on('click', function(event) {
		event.preventDefault();
		$('#modalAdd').modal('show');
	});

	$('#formAdd').on('submit', function(event) {
		event.preventDefault();
		$.ajax({
			url: '{{ route('admin_color.store') }}',
			type: 'POST',
			data: {
				color: $('#color').val(),
				code: $('#code').val(),
			},
			success: function(res){
				$('#modalAdd').modal('hide');
				toastr['success']('Add new color successfully!');
				$('#tblColor').DataTable().ajax.reload(null,false);
				
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr['error']('Add failed');
			}
		})		
	});

	$('#tblColor').on('click', '.btnEdit', function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $(this).data('id');
		
		$.ajax({
			url: '{{ asset('') }}admin/colors/edit/'+id,
			type: 'GET',
			success: function(res){
				$('#modalEdit').modal('show');
				$('#edit-color').val(res.color);
				$('#edit-id').attr('value',res.id);
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr['error']('Can\'t display color to edit');
			}
		})
	});

	$('#formEdit').on('submit',function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $('#edit-id').val();
		$.ajax({
			url: '{{ asset('') }}admin/color/update/'+id,
			type: 'PUT',
			data: {
				color: $('#edit-color').val(),
			},
			success: function(res) {
				$('#modalEdit').modal('hide');
				var row = document.getElementById(id);
				row.remove();
				toastr['success']('Update the Color successfully!');
				$('#tblColor').prepend('<tr id="'+res.id+'"><td width="5%" class="text-center">'+res.id+'</td><td class="text-center">'+res.color+'</td><td class="text-center">'+res.created_at+'</td><td>'+res.updated_at+'</td><td class="text-center" width="15%" ><a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'+res.id+'" id="row-'+res.id+'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='+res.id+'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='+res.id+'></a></td></tr>');
				
			},
			error: function(xhr, ajaxOptions, thrownError) {
				toastr['error']('Update color failed!');
			}
		})
	});

	$('#tblColor').on('click', '.btnDelete', function(event) {
		event.preventDefault();
		var id = $(this).attr('data-id');
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will delete ALL PRODUCT has this color",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: '{{ asset('') }}admin/color/'+ id,
					type: 'DELETE',
					success: function(res) {
						
						swal({
							title: "The color has been deleted!",
							icon: "success",
						});
						$('#tblColor').DataTable().ajax.reload(null,false);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						toastr.error(thrownError)
					}
				})
				
			} else {
				swal({
					title: "The color is safety!",
					icon: "success",
					button: "OK!",
				});
			}
		});
	});

	$('#tblColor').on('click', '.btnShow', function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $(this).data('id');
		$('#modalShow').modal('show');
		$('#tblProductByColor').DataTable({
			processing: true,
			serverSide: true,
			destroy: true,
			ajax: '{{ asset('') }}admin/colors/listProduct/'+id,
			columns: [
				{ data: 'id', name: 'id' },
				{ data: 'name', name: 'name' },
				{ data: 'thumbnail', name: 'thumbnail', render: function(data, type, full, meta){
					return '<img src=\"http://ashoes.com/'+data+'" alt="" height="80px">' }
				},
				{ data: 'brand', name: 'brand' },
				{ data: 'category', name: 'category' },
			]
		})
	});

</script>
@endsection