@extends('admin.layouts.admin_master')
@section('content')
<section>
	<a class="btn btn-primary btnAdd" id="btnAdd" style="float: right">
	<i class="fa fa-plus-square" aria-hidden="true"></i>
	<i class="fa fa-list" aria-hidden="true"></i>
</a>
<table class="table table-bordered table-hover" id="tblAdmin">
	<thead>
		<tr>
			<th>ID</th>
			<th>AVATAR</th>
			<th>NAME</th>
			<th>EMAIL</th>
			<th>CREATE AT</th>
			<th>ACTION</th>
		</tr>
	</thead>
	
</table>

{{-- modal Add --}}
<div class="modal fade" id="modalAdd">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add new Admin</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST" role="form" id="formAdd" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="name" placeholder="Name" name="name">
					</div>	
					<div class="form-group">
						<label for="">Email</label>
						<input type="email" class="form-control" id="email" placeholder="Email" name="email">
					</div>
					<div class="form-group">
						<label for="">Phone</label>
						<input class="form-control" id="phone" placeholder="Phone" name="phone">
					</div>
					<div class="form-group">
						<label for="">Birthday</label>
						<input class="form-control" id="birthday" name="birthday" type="date">
					</div>
					<div class="form-group">
						<label for="">Avatar</label>
						<div class="input-group">
							
							<span class="input-group-btn">
								<a id="lfm" data-input="thumbnail" data-preview="previewimg" class="btn btn-primary">
									<input type="file" name="thumbnail" id="thumbnail">
								</a>
							</span>
							
						</div>
						<img id="holder" style="margin-top:15px;max-height:100px;">
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

{{-- modal Show --}}
<div class="modal fade" id="modalShow">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><b>ADMIN INFORMATION-ID:<span id="show-id"></span></b></h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover">
					<tbody>
						<tr>
							<th width="25%">
								<img src="" alt="" id="show-avatar" height="80px">
							</th>
							<td><h2  id="show-name"></h2></td>
						</tr>
						<tr>
							<th width="25%">Birthday</th>
							<td id="show-birthday"></td>
						</tr>
						<tr>
							<th width="25%">Email</th>
							<td id="show-email"></td>
						</tr>
						<tr>
							<th width="25%">Mobile</th>
							<td id="show-mobile"></td>
						</tr>
						<tr>
							<th width="25%">Created at</th>
							<td id="show-created-at"></td>
						</tr>
						<tr>
							<th width="25%">Lastest updated</th>
							<td id="show-lastest-updated"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
</section>
@endsection

@section('script')
	<script type="text/javascript">
		$(function() {
			$('#tblAdmin').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{!! route('admin_list.dataTable') !!}',
				columns:[
					{data: 'id', name: 'id'},
					
					{data: 'avatar',name: 'avatar'},
					{data: 'name', name: 'name'},
					{data: 'email', name: 'email'},
					{data: 'created_at', name: 'created_at'},
					{data: 'action', name: 'action', orderable: false, searchable: false},
				],
			})
		})

		$('#btnAdd').on('click', function(event) {
		event.preventDefault();
		$('#modalAdd').modal('show');

	});

	$('#formAdd').on('submit', function(event) {
		event.preventDefault();

		var thumbnail = $('#thumbnail').get(0).files[0];
		var newAdmin = new FormData();

		newAdmin.append('name',$('#name').val());
		newAdmin.append('email',$('#email').val());
		newAdmin.append('thumbnail',thumbnail);
		newAdmin.append('phone',$('#phone').val());
		newAdmin.append('birthday',$('#birthday').val());

		$.ajax({
			url: '{{ route('admin_list.store') }}',
			type: 'POST',
			processData: false,
			contentType: false,
			cache: false,
			dataType: 'JSON',
			data: newAdmin,
			success: function(res){
				$('#modalAdd').modal('hide');
				toastr['success']('Add new Admin successfully!');
				$('#tblAdmin').DataTable().ajax.reload(null,false);
				
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr['error']('Add failed');
			}
		})		
	});

	$('#tblAdmin').on('click', '.btnDelete', function(event) {
		event.preventDefault();
		var id = $(this).attr('data-id');
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this Admin!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: '{{ asset('') }}admin/admin_list/' +id,
					type: 'DELETE',
					success: function(res) {
						var row = document.getElementById(id);
						row.remove();
						swal({
							title: "The admin has been deleted!",
							icon: "success",
						});
					},
					error: function(xhr, ajaxOptions, thrownError) {
						toastr.error(thrownError)
					}
				})
				
			} else {
				swal({
					title: "The admin is safety!",
					icon: "success",
					button: "OK!",
				});
			}
		});
	});

	$('#tblAdmin').on('click', '.btnshow', function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $(this).data('id');
		$.ajax({
			url: '{{ asset('') }}admin/admin_list/'+id,
			type: 'GET',
			success: function(res){
				$('#modalShow').modal('show');
				$('#show-id').text(res.id);
				$('#show-name').text(res.name);
				$('#show-avatar').attr('src', 'http://mshoes.com/'+res.avatar);
				$('#show-birthday').text(res.birthday);
				$('#show-email').text(res.email);
				$('#show-mobile').text(res.phone);
				$('#show-created-at').text(res.created_at);
				$('#show-lastest-updated').text(res.updated_at);
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr.error(thrownError);
			}
		})		
	});
	</script>
@endsection