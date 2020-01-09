@extends('admin.layouts.admin_master')

@section('content')
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Table of Brand</h3>
					<a class="btn btn-primary  " data-toggle="modal" id='btnAdd' style="float: right">&nbsp;
						<i class="fa fa-plus-square" aria-hidden="true"></i>
						<i class="fa fa-list" aria-hidden="true"></i>
					</a>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-hover table-bordered" id="tblBrand">
						<thead>
							<tr>
								<th width="5%" class="text-center">ID</th>
								<th class="text-center" >Name</th>
								<th class="text-center" >Country</th>
								<th class="text-center" >Description</th>
								<th class="text-center" width="15%">Created at</th>
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

	<div class="modal fade" id="modalAdd">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Add new Brand</h4>
				</div>
				<div class="modal-body">
					<form action="" method="POST" role="form" id="formAdd">
						@csrf
						<div class="form-group">
							<label for="">Name</label>
							<input type="text" class="form-control" id="name" placeholder="Brand" name="name">
						</div>	
						<div class="form-group">
							<label for="">Country</label>
							<input type="text" class="form-control" id="country" placeholder="Country" name="country">
						</div>
						<div class="form-group">
							<label for="">Description</label>
							<textarea class="form-control" id="description" placeholder="Description" name="description"></textarea>
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
					<h4 class="modal-title"><b>Edit brand</b></h4>
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
							<label for="">Country</label>
							<input type="text" class="form-control" id="edit-country" name="edit-country">
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
</section>
@endsection

@section('script')
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(function(){
		$('#tblBrand').DataTable({
			processing: true,
			serverSide: true,
			ajax:'{!! route('admin_brand.dataTable') !!}',
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'name', name: 'name' },
			{ data: 'country', name: 'country' },
			{ data: 'description', name: 'description' },
			{ data: 'created_at', name: 'created_at' },
			{ data: 'action', name: 'action', orderable: false, searchable: false}
			]
		});
	})

	$('#btnAdd').on('click', function(event) {
		event.preventDefault();
		$('#modalAdd').modal('show');
	});
	

	$('#formAdd').on('submit', function(event) {
		event.preventDefault();
		
		$.ajax({
			url: '{{ route('admin_brand.store') }}',
			type: 'POST',
			data: {
				name: $('#name').val(),
				country: $('#country').val(),
				description: $('#description').val()
			},
			success: function(res){
				$('#modalAdd').modal('hide');
				toastr['success']('Add new Brand successfully!');
				$('#tblBrand').DataTable().ajax.reload(null,false);
				
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr['error']('Add failed');
			}
		})		
	});

	$('#tblBrand').on('click','.btnDelete',function(event){
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
					url:'{{ asset('') }}admin/brand/'+id,
					type:'delete',
					success: function(res) {
						swal({
							title: "The category has been deleted!",
							icon: "success",
						});
						$('#tblBrand').DataTable().ajax.reload(null,false);
						
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

	$('#tblBrand').on('click', '.btnEdit', function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $(this).attr('data-id');
		
		$.ajax({
			url: '{{ asset('') }}admin/brand/'+id,
			type: 'GET',
			success: function(res){
				$('#modalEdit').modal('show');
				$('#edit-name').attr('value',res.name);
				$('#edit-country').attr('value',res.country);
				$('#edit-description').text(res.description);
				$('#edit-id').attr('value',res.id);
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr['error']('Can\'t display brand to edit');
			}
		})
	});

	$('#formEdit').on('submit',function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $('#edit-id').val();
		$.ajax({
			url: '{{ asset('') }}admin/brand/'+id,
			type: 'PUT',
			data: {
				name: $('#edit-name').val(),
				description: $('#edit-description').val(),
				country: $('#edit-country').val(),
			},
			success: function(res) {
				$('#modalEdit').modal('hide');
				toastr['success']('Update the brand successfully!');
				$('#tblBrand').DataTable().ajax.reload(null,false);
				
			},
			error: function(xhr, ajaxOptions, thrownError) {
				toastr['error']('Update brand failed!');
			}
		})
	});


</script>
@endsection