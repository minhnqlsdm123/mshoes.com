@extends('admin.layouts.admin_master')
@section('')
@section('content-header')
 <li><a href="#"><i class="fa fa-dashboard"></i> Home/Size</a></li>
@endsection
@section('content')
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Table of Size</h3>
					<a class="btn btn-primary  " data-toggle="modal" id='btnAdd' style="float: right">&nbsp;
						<i class="fa fa-plus-square" aria-hidden="true"></i>
						<i class="fa fa-list" aria-hidden="true"></i>
					</a>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-hover table-bordered" id="tblSize">
						<thead>
							<tr>
								<th width="5%" class="text-center">ID</th>
								<th class="text-center" width="20%">Size</th>
								<th class="text-center" width="25%">Created at</th>
								<th class="text-center" width="25%">Updated at</th>
								<th class="text-center" width="25%">Action</th>
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

	{{-- modal Add --}}
	<div class="modal fade" id="modalAdd">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Add new Size</h4>
				</div>
				<div class="modal-body">
					<form action="" method="POST" role="form" id="formAdd">
						@csrf
						<div class="form-group">
							<label for="">Size</label>
							<input type="number" class="form-control" id="size" placeholder="0" name="size" step="0.01" min="0" max="100">
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

	<div class="modal fade" id="modalEdit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Edit Size</h4>
				</div>
				<div class="modal-body">
					<form action="" role="form" id="formEdit">
						<input type="hidden" name="_method" value="PUT">
						@csrf
						<input type="hidden" name="edit-id" id="edit-id">
						<div class="form-group">
							<label for="">Size</label>
							<input type="number" class="form-control" id="edit-size" placeholder="0" name="edit-size" step="0.01" min="0" max="100">
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
</section>
@endsection


@section('script')
<script type="text/javascript">


	$(function() {
		$('#tblSize').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{!! route('admin_size.dataTable') !!}',
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'size', name: 'size' },
			{ data: 'created_at', name: 'created_at' },
			{ data: 'updated_at', name: 'updated_at' },
			{ data: 'action', name: 'action', orderable: false, searchable: false}
			]
		});
	});

	$('#btnAdd').on('click', function(event) {
		event.preventDefault();
		$('#modalAdd').modal('show');
	});

	$('#formAdd').on('submit', function(event){
		event.preventDefault();
		$.ajax({
			url: '{{ route('admin_size.store') }}',
			type: 'POST',
			data: {
				size: $('#size').val(),
			},
			success: function(res){
				$('#modalAdd').modal('hide');
				toastr['success']('Add new Size successfully!');
				$('#tblSize').DataTable().ajax.reload(null,false);

			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr['error']('Add failed');
			}
		})		
	});

	$('#tblSize').on('click','.btnDelete',function(event){
		event.preventDefault();
		var id=$(this).attr('data-id');
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this imaginary file!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url:'{{ asset('') }}admin/size/'+id,
					type:'delete',
					success: function(res) {
						swal({
							title: "The category has been deleted!",
							icon: "success",
						});
						$('#tblSize').DataTable().ajax.reload(null,false);

					},
					error: function(xhr, ajaxOptions, thrownError) {
						toastr.error(thrownError)
					}
				})
			} else {
				swal({
					title: "The category is safety!",
					icon: "success",
					button: "OK!",
				});
			}
		});
	})

	$('#tblSize').on('click','.btnEdit',function(event) {
		event.preventDefault();
		var id=$(this).attr('data-id');

		$.ajax({
			type: 'GET',
			url: '{{asset('')}}admin/size/' +id,
			success: function(response){
				$('#modalEdit').modal('show');
				$('#edit-size').attr('value',response.size);
				$('#edit-id').attr('value',response.id);
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr['error']('Can\'t display category to edit');
			}
		})
	})
	$('#formEdit').on('submit',function(event) {
		event.preventDefault();

		var id = $('#edit-id').val();

		$.ajax({
			type:'PUT',
			url: '{{asset('')}}admin/size/' +id,
			processing: true,
			serverSide: true,
			data:{
				size: $('#edit-size').val(),
			},
			success:  function(response){
				$('#modalEdit').modal('hide');
				toastr['success']('Update  Size successfully!');
				$('#tblSize').DataTable().ajax.reload(null,false);
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr['error']('Update Size Failse!')
			}
		});

	});
</script>
@endsection