@extends('shop.layouts.master')

@section('content')
<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="{{ route('shop.home')}}">Home</a></li>
				<li class="active">Checkout</li>
			</ul>
		</div>
	</div>

	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<form id="checkout-form" method="POST" class="clearfix" action="">
					@csrf

					@if(Auth::check())
					<div class="col-md-6">
						<div class="billing-details">
							<p>Already a customer ? <a href="#">Login</a></p>
							<div class="section-title">
								<h3 class="title">Billing Details</h3>
							</div>
							<div class="form-group">
								<input class="input" type="text" id="name1" name="name" placeholder="Name" value="{{ Auth::user()->name }}">
							</div>
							<div class="form-group">
								<input class="input" type="text" id="addr1" name="address" placeholder="Address">
							</div>
							<div class="form-group">
								<input class="input" type="number" id="mobile1" name="mobile" placeholder="Mobile">
							</div>
							<div class="form-group">
								<input class="input" type="email" id="email1" name="email" placeholder="Email" value="{{ Auth::user()->email }}">
							</div>
							
							{{-- <div class="form-group">
								<div class="input-checkbox">
									<input type="checkbox" id="register">
									<label class="font-weak" for="register">Create Account?</label>
									<div class="caption">
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.
											<p>
												<input class="input" type="password" name="password" placeholder="Enter Your Password">
									</div>
								</div>
							</div> --}}
						</div>
					</div>
					@else
					<div class="col-md-6">
						<div class="billing-details">
							<p>Already a customer ? <a href="#">Login</a></p>
							<div class="section-title">
								<h3 class="title">Billing Details</h3>
							</div>
							<div class="form-group">
								<input class="input" type="text" id="name1" name="name" placeholder="Name">
							</div>
							<div class="form-group">
								<input class="input" type="text" id="addr1" name="address" placeholder="Address">
							</div>
							<div class="form-group">
								<input class="input" type="number" id="mobile1" name="mobile" placeholder="Mobile">
							</div>
							<div class="form-group">
								<input class="input" type="email" id="email1" name="email" placeholder="Email">
							</div>
							
							{{-- <div class="form-group">
								<div class="input-checkbox">
									<input type="checkbox" id="register">
									<label class="font-weak" for="register">Create Account?</label>
									<div class="caption">
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.
											<p>
												<input class="input" type="password" name="password" placeholder="Enter Your Password">
									</div>
								</div>
							</div> --}}
						</div>
					</div>
					@endif
{{-- 			
					<div class="col-md-6">
						<div class="shiping-methods">
							<div class="section-title">
								<h4 class="title">Shiping Methods</h4>
							</div>
							<div class="input-checkbox">
								<input type="radio" name="shipping" id="shipping-1" checked>
								<label for="shipping-1">Free Shiping -  $0.00</label>
								<div class="caption">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
										<p>
								</div>
							</div>
							<div class="input-checkbox">
								<input type="radio" name="shipping" id="shipping-2">
								<label for="shipping-2">Standard - $4.00</label>
								<div class="caption">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
										<p>
								</div>
							</div>
						</div>

						<div class="payments-methods">
							<div class="section-title">
								<h4 class="title">Payments Methods</h4>
							</div>
							<div class="input-checkbox">
								<input type="radio" name="payments" id="payments-1" checked>
								<label for="payments-1">Direct Bank Transfer</label>
								<div class="caption">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
										<p>
								</div>
							</div>
							<div class="input-checkbox">
								<input type="radio" name="payments" id="payments-2">
								<label for="payments-2">Cheque Payment</label>
								<div class="caption">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
										<p>
								</div>
							</div>
							<div class="input-checkbox">
								<input type="radio" name="payments" id="payments-3">
								<label for="payments-3">Paypal System</label>
								<div class="caption">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
										<p>
								</div>
							</div>
						</div>
					</div> --}}

					<div class="col-md-12">
						<div class="order-summary clearfix">
							<div class="section-title">
								<h3 class="title">Order Review</h3>
							</div>
							<table class="shopping-cart-table table">
								<thead>
									<tr>
										<th>Product</th>
										<th></th>
										<th class="text-center">Price</th>
										<th class="text-center">Quantity</th>
										<th class="text-center">Total</th>
										<th class="text-right"></th>
									</tr>
								</thead>
								<tbody>
									@foreach($cart as $rowId =>$item)
									<tr id="row-{!! $rowId !!}">
										<td class="thumb"><img src="http://localhost/{!!$item->thumbnail!!}" alt=""></td>
										<td class="details">
											<a href="#">{!!$item->name!!}</a>
											<ul>
												<li><span>Size: {!!$item->size!!}</span></li>
												<li><span>Color: <a style="background-color:{!!$item->color!!}; border:1px solid grey; width: 15px; height: 15px" class="btn"></a></span></li>
											</ul>
										</td>
										<td class="price text-center"><strong>${!!$item->price!!}</strong><br></td>
										<td class="qty text-center"><strong><h4>{{$item->qty}}</h4></strong></td>
										<td class="total text-center"><strong class="primary-color">{!!$item->subtotal!!}</strong></td>
										<td class="text-right"><button class="main-btn icon-btn"><i class="fa fa-close"></i></button></td>
									</tr>
									@endforeach
									
								</tbody>
								<tfoot>
									<tr>
										<th class="empty" colspan="3"></th>
										<th>SUBTOTAL</th>
										<th colspan="2" class="sub-total">{!!$total!!}</th>
									</tr>
									<tr>
										<th class="empty" colspan="3"></th>
										<th>SHIPING</th>
										<td colspan="2">Free Shipping</td>
									</tr>
									<tr>
										<th class="empty" colspan="3"></th>
										<th>TOTAL</th>
										<th colspan="2" class="total" id="total_price1">{!!$total!!}</th>
									</tr>
								</tfoot>
							</table>
							<div class="pull-right">
								<button type="submit" id="checkout" class="primary-btn">Place Order</button>
							</div>
						</div>

					</div>
				</form>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
@endsection

@section('script')
	<script type="text/javascript">
			$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(function() {
		$('#checkout').on('click',function(event) {
			$.ajax({
				type: 'POST',
				url: '{{ Route('checkout') }}',
				data: {
					name: $('#name1').val(),
					address: $('#addr1').val(),
					mobile: $('#mobile1').val(),
					email: $('#email1').val(),
					total_price: $('#total_price1').val(),
				},
				success: function(res){
					toastr['success']('Add new Product successfully!');
					console.log(res);
				},
				error: function(xhr, ajaxOptions, thrownError){
					toastr['error']('Add failed');
				}
			
			})
		});
	}
	</script>

