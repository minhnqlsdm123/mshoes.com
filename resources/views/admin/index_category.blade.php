@extends('admin.layouts.admin_master')

@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Table of Category</h3>
					<a class="btn btn-primary  " data-toggle="modal" id='btnAdd' style="float: right">&nbsp;
						<i class="fa fa-plus-square" aria-hidden="true"></i>
						<i class="fa fa-list" aria-hidden="true"></i>
					</a>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-hover table-bordered" id="tblCategory">
						<thead>
							<tr>
								<th width="5%" class="text-center">ID</th>
								<th class="text-center" >Name</th>
								<th class="text-center" >Description</th>
								<th class="text-center" >Created at</th>
								<th class="text-center" >Action</th>
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
</section>
<!-- /.content -->

{{-- modal Add --}}
<div class="modal fade" id="modalAdd">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add new Category</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST" role="form" id="formAdd">
					@csrf
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="name" placeholder="Category" name="name">
					</div>	
					<div class="form-group">
						<label for="">Description</label>
						<input type="text" class="form-control" id="description" placeholder="Description" name="description">
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

{{-- modal Edit --}}
<div class="modal fade" id="modalEdit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add new Category</h4>
			</div>
			<div class="modal-body">
				<form action="" role="form" id="formEdit">
					<input type="hidden" name="_method" value="PUT">
					@csrf
					<input type="hidden" name="edit-id" id="edit-id">
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="edit-name" name="edit-name">
					</div>
					<div class="form-group">
						<label for="">Description</label>
						<textarea type="text" class="form-control" id="edit-description" name="edit-description"></textarea>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Update</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
	

	$(function() {
		$('#tblCategory').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{route('admin_category.dataTable')}}',
			columns: [
			{data:'id', name: 'id'},
			{data:'name', name: 'name'},
			{data:'description', name: 'description'},
			{data:'created_at', name: 'created_at'},
			{data:'action', name: 'action'},

			]
			
		});
	});

	$('#btnAdd').on('click', function(event) {
		event.preventDefault();
		// $('#formAdd input').reset();
		$('#modalAdd').modal('show'); 
	});

	$('#formAdd').on('submit', function(event) {
		event.preventDefault();
		/* Act on the event */
		$.ajax({
			url: '{{ route('admin_category.store') }}',
			type: 'POST',
			data: {
				name: $('#name').val(),
				description: $('#description').val(),
				
			},
			success: function(res) {
				$('#modalAdd').modal('hide');
				toastr['success']('Add new Category successfully!');
				$('#tblCategory').DataTable().ajax.reload(null,false);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				toastr['error']('Add failed');
			}
		})		
	});


	$('#tblCategory').on('click','.btnDelete',function(event){
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
					url:'{{ asset('') }}admin/category/'+id,
					type:'delete',
					success: function(res) {
						swal({
							title: "The category has been deleted!",
							icon: "success",
						});
						$('#tblCategory').DataTable().ajax.reload(null,false);
						
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

	$('#tblCategory').on('click', '.btnEdit', function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $(this).attr('data-id');
		
		$.ajax({
			url: '{{ asset('') }}admin/category/'+id,
			type: 'GET',
			success: function(res){
				$('#modalEdit').modal('show');
				$('#edit-name').attr('value',res.name);
				$('#edit-description').text(res.description);
				$('#edit-id').attr('value',res.id);
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr['error']('Can\'t display category to edit');
			}
		})
	});

	$('#formEdit').on('submit',function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $('#edit-id').val();
		$.ajax({
			url: '{{ asset('') }}admin/category/'+id,
			type: 'PUT',
			data: {
				name: $('#edit-name').val(),
				description: $('#edit-description').val(),
			},
			success: function(res) {
				$('#modalEdit').modal('hide');
				toastr['success']('Update the Category successfully!');

				$('#tblCategory').DataTable().ajax.reload(null,false);
				
			},
			error: function(xhr, ajaxOptions, thrownError) {
				toastr['error']('Update Category failed!');
			}
		})
	});
</script>
@endsection