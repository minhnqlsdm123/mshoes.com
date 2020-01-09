@extends('admin.layouts.admin_master')
@section('style')
<style type="text/css">
	.button1{
		width: 30px;
		padding: 5px;
	}
	
</style>
@endsection

{{-- @section('content-header')
<li><a href="#"><i class="fa fa-dashboard"></i>Home/Product</a></li>
@endsection --}}

@section('content')
<section>
	<a class="btn btn-primary btnAdd" id="btnAdd" style="float: right">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		<i class="fa fa-list" aria-hidden="true"></i>
	</a>
	<table class="table table-bordered table-hover" id="tblProduct">
		<thead>
			<tr>
				<th>ID</th>
				<th>NAME</th>
				<th>BRAND</th>
				<th>CATEGORY</th>
				<th>CREATE AT</th>
				<th>THUMBNAIL</th>
				<th>ACTION</th>
			</tr>
		</thead>

	</table>


	<div class="modal fade" id="modalAdd">
		<div class="container">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">ADD NEW PRODUCT</h4>
				</div>
				<div class="modal-body">
					<form action="{{ route('admin_product.store') }}" method="POST" role="form" enctype="multipart/form-data" id="formAdd" name="formAdd">
						@csrf
						<div>
							<table class="table table-hover">
								<tbody>
									<tr>
										<td>
											<div class="form-group">
												<label for="">Name</label>
												<input type="text" class="form-control" id="name" placeholder="Name" name="name">
											</div>
										</td>
										<td>
											<div class="form-group">
												<label for="">Price</label>
												<input type="number" class="form-control" id="price" placeholder="0" name="origin_price">
											</div>
										</td>
										<tr>
											<td>
												<label for="">Brand</label>
												<select name="brand" id="inputBrand" class="form-control" >
													@foreach ($brands as $brand)
													<option id="brand" value="{{$brand['id']}}">{{$brand['name']}}</option>
													@endforeach													
												</select>
											</td>
											<td>
												<div class="form-group">
													<label for="">Sale price</label>
													<input type="number" class="form-control" id="sale_price" placeholder="0" name="sale_price">
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<label for="">Category</label>
												<select name="category" id="inputCategory" class="form-control">
													@foreach ($categories as $category)
													<option id="category" value="{!!$category['id']!!}">{!!$category['name']!!}</option>
													@endforeach

												</select>
											</td>
											<td>
												<div class="form-group">
													<label for="">Color</label>
													<select name="color" id="inputColor" class="form-control">
														
													@foreach ($colors as $color)

													<option id="color" value="{!!$color['id']!!}">{!!$color['color']!!}</option>
													@endforeach

												</select>
												</div>
											</td>
										</tr>
										<tr>									
											<td colspan="2">
												<div class="form-group">
													<label for="">Description</label>
													<textarea name="description" type="text" class="form-control" id="description" placeholder="Input field"></textarea>
												</div>
											</td>									
										</tr>								
										<tr>
											<td colspan="2">
												<div class="form-group">
													<label for="">Content</label>
													<textarea name="content" type="text" class="form-control" id="content" placeholder="Input field"></textarea>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<div class="form-group">
													<label for="">Image</label>
													<div class="input-group">

														<input id="thumbnail" class="form-control" type="file" name="images[]" multiple>
													</div>
													<img id="holder" style="margin-top:15px;max-height:100px;">
												</div>
											</td>
										</tr>
									</tbody>

								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" id="adddetail" class="btn btn-primary">Create</button>
							</div>

						</form>

					</div>

				</div>
			</div>
		</div>

		<div class="modal fade" id="modalAddDetail">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">ADD DETAIL</h4>
					</div>
					<form action="" method="POST" role="form" id="formAddDetail">

						<div class="modal-body">

							<br>
							<table class="table table-hover" id="tblAddDetail">
								<thead>
									<tr>
										<th width="31%">Size</th>
										<th width="31%">Quantity</th>
										<th width="7%"></th>
									</tr>
								</thead>
								<tbody>

								</tbody>
								<tbody id="tbody">
									@csrf
									<tr class="detail" id="1" data-length='1'>

										<td>
											<select name="size" id="inputSize" class="form-control" >
												@foreach ($sizes as $size)
												<option  value="{{$size['id']}}">{{$size['size']}}</option>
												@endforeach													
											</select>

										</td>
										<td>
											<input type="number" class="form-control" id="quantity" name="quantity-1" placeholder="0" min="0" required>
										</td>
										<td>
											<a class="btn btn-info" id="btnaddDetail" type="submit" ><i class="fa fa-plus-square" aria-hidden="true"></i></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Create</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modalShow">
			<div class="container">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">PRODUCT'S INFORMATION </h4>
					</div>
					<br>
					<div class="col-lg-8">
						<table class="table table-bordered" >
							<tbody>
								<tr colspan="6">
									<td rowspan="6" >
										<img src="" alt="" id="show-thumbnail" width="500px" height="50%">
									</td>
								</tr>
								<tr>
									<td width="15%">Product : </td>
									<td id="show-name" width="35%"></td>
								</tr>
								<tr>
									<td>Color : </td>
									<td id="show-color"></td>
								</tr>
								<tr>
									<td>Brand : </td>
									<td id="show-brand"></td>
								</tr>
								<tr>
									<td>Category : </td>
									<td id="show-category"></td>
								</tr>
								<tr>
									<td>Price : </td>
									<td id="show-price"></td>
								</tr>
								<tr>
									<td>Description : </td>
									<td id="show-description" colspan="3"></td>
								</tr>
								<tr>
									<td>Content : </td>
									<td id="show-content" colspan="3"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-lg-4"><table class="table table-hover table-bordered" id="tblProductDetails">
						<thead>
							<tr>
								<th width="5%" >#</th>
								<th >Size</th>
								<th >Quantity</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalShowImage">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">IMAGES</h4>
				</div>
				<div class="modal-body">
				{{-- @foreach ($product['gallery'] as $image)
						<div class="product-view">
							<img src="http://mshoes.com/{{$image['link']}}" alt="">
						</div>
						@endforeach --}}
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>
	</section>
	@endsection

	@section('script')
	<script type="text/javascript">

		function escapeHtml(text) {
			return text
			.replace(/&/g, "&amp;")
			.replace(/</g, "&lt;")
			.replace(/>/g, "&gt;")
			.replace(/"/g, "&quot;")
			.replace(/'/g, "&#039;");
		}
		$('#tblProduct').DataTable({
			processing: true,
			serverSide: true,
			ajax:'{{route('admin_product.dataTable')}}',
			columns:[
			{data: 'id', name: 'id'},
			{data: 'name', name: 'name'},
			{data: 'brand_id', name: 'brand_id'},

			{ data: 'category_id', name: 'category_id' },
			{ data: 'created_at', name: 'created_at' },
			{data: 'thumbnail', name: 'thumbnail'},
			{data: 'action', name: 'action'}
			]
		});

		CKEDITOR.replace('content');

		$('#btnAdd').on('click', function(event) {
			event.preventDefault();
			/* Act on the event */
			$('#modalAdd').modal('show');
		});

		$('#tblProduct').on('click','.btnDelete', function(){
			var id=$(this).data('id');
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
				//phương thức delete
				type: 'delete',
				url: '{{asset('')}}admin/product/' +id,
				success: function (response) {
					swal({
						title: "The Product has been deleted!",
						icon: "success",
					});
					$('#tblProduct').DataTable().ajax.reload(null,false);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					toastr.error(thrownError);
				}
			})
				} else {
					swal({
						title: "The Product is safety!",
						icon: "success",
						button: "OK!",
					});
				}
			})
		})
		$('#tblProductDetails').on('click','.btnDeleteDetail', function(){
			var id=$(this).data('id');
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
				//phương thức delete
				type: 'delete',
				url: '{{asset('')}}admin/product/detail/delete/' +id,
				success: function (response) {
				//thông báo xoá thành công bằng toastr
				swal({
					title: "The Product Detail has been deleted!",
					icon: "success",
				});
				$('#tblProductDetails').DataTable().ajax.reload(null,false);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				toastr.error(thrownError);
			}
		})
				} else {
					swal({
						title: "The Product Detail is safety!",
						icon: "success",
						button: "OK!",
					});
				}
			})
		})

		$('.btnadd').click(function(event){
			event.preventDefault();
		//hien len modal add
		$('#modaladd').modal('show');
	})

		$('#tblProduct').on('submit',function(event){
			event.preventDefault();
			$.ajax({
				type:'POST',
				url: '{{ route('admin_product.store')}}',
				data:{
					name: $('#name').val(),
					origin_price: $('#price').val(),
					brand: $('#brand').val(),
					sale_price: $('#sale_price').val(),
					category: $('#category').val(),
					description: $('#description').val(),
					color: $('#color').val(),
					content: CKEDITOR.instances['content'].getData(),
					gallery_image: $('#thumbnail')[0].files[0],
				},
				success: function(res){
					$('#modalAdd').modal('hide');
					toastr['success']('Add new Product successfully!');
					$('#tblProduct').DataTable().ajax.reload(null,false);

				},
				error: function(xhr, ajaxOptions, thrownError){
					toastr['error']('Add failed');
				}
			})
		})


		$('#tblProduct').on('click', '.btnShow', function(event) {

			event.preventDefault();
			$('#modalShow').modal('show');
			var product_id = $(this).data('id');
			$('#tblProductDetails').DataTable({
				processing: true,
				serverSide: true,
				destroy: true,
				ajax: '{{ asset('') }}admin/product/detail/'+product_id,
				columns: [
				{ data: 'id', name: 'id' },
				{ data: 'size', name: 'size' },
				{ data: 'quantity', name: 'quantity' },
				{ data: 'action', name: 'action' }
				]
			})
			$.ajax({
				url: '{{ asset('') }}admin/product/'+product_id,
				type: 'GET',
				success: function(res) {
					$('#show-name').text(res.name);
					$('#btnMoreInfor').attr('data-id', res.id);
					$('#show-color').text(res.color);
					$('#show-brand').text(res.brand);
					$('#show-category').text(res.category);
					$('#show-price').text(res.sale_price+' $/ '+res.origin_price +' $');
					$('#show-description').text(res.description);
					$('#show-content').html(res.content);
					$('#show-thumbnail').attr('src', 'http://localhost/'+res.thumbnail);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					toastr['error']('Load this product failed!');
				}
			})
		});

		$('#tblProduct').on('click','.btnShowImage',function(event){
			event.preventDefault();
			$('#modalShowImage').modal('show');

		})


		$(function(){
		var i= 1; //chỉ số để thêm chi tiết sản phẩm khi thêm sản phẩm mới
		$('#tblProduct').on('click','.btnaddDetail', function(e){
			e.preventDefault();
			//hien len modal add
			$('#modalAddDetail').modal('show');
			var id= $(this).data('id');
			$('#tblAddDetail').attr('data-id', id);
			
			// alert(id);
			

		})		
		$('#tblAddDetail').on('click','#btnAddDetail' ,function(event) {

			event.preventDefault();
			var row = document.getElementsByClassName('detail');

			var length = ++i;
			$('#tbody #1').attr('data-length', length);
			console.log(length);

			$('#tblAddDetail').append('<tr class="detail" id="'+length+'"><td><input type="number" class="form-control" id="size-'+length+'" name="size-'+length+'" step="0.01" min="0" max="100" required></td><td><input type="number" class="form-control" id="quantity-'+length+'" name="quantity-'+length+'" placeholder="0" required></td><td><a class="btn btn-info btnRemoveDetail" id="btnRemoveDetail" data-row="'+length+'"><i class="fa fa-minus-circle" aria-hidden="true"></i></a></td></tr>');
		});

		$('#tblAddDetail').on('click', '.btnRemoveDetail', function(event) {
			event.preventDefault();
			var row_id = $(this).data('row');
			console.log(row);
			var row = document.getElementById(row_id);
			row.remove();
		});

		$('#formAddDetail').on('submit',function(event){
			event.preventDefault();
			// $('#tblAddDetail').attr('data-id', id);
			var id= $('#tblAddDetail').data('id');
			console.log($('#inputSize').val());
			// console.log($('#inputColor').val());
			// alert(id);
			$.ajax({
				type:'POST',
				url:'{{route('admin_product.add_detail')}}',
				processing: true,
				serverSide:true,
				data:{
					id: id,
					
					size: $('#inputSize').val(),
					quantity: $('#quantity').val()
				},
				success: function(res){
					$('#modalAddDetail').modal('hide');
					toastr['success']('Add new Product Detail successfully!');
						// $('#tblProductDetails').DataTable().ajax.reload(null,false);

					},
					error: function(xhr, ajaxOptions, thrownError){
						toastr['error']('Add failed');
					}
				})
		})
	})
</script>
@endsection
