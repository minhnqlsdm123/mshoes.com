@extends('shop.layouts.master')
@section('content')
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<!-- section title -->

			<div class="col-md-12">
				<div class="section-title">
					<h2 class="title">Search:</h2>
					<h4>FIND {{ count($products) }} PRODUCT</h4>
				</div>
			</div>
			<!-- section title -->

			<!-- Product Single -->
			@foreach ($products as $product)
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="product product-single">
					<div class="product-thumb">
						{{-- <div class="product-label">
							<span>New</span>
							<span class="sale">
								@if ($product->sale_price!=$product->origin_price)
								{{$product['origin_price']/$product['sale_origin']}}
								@endif
							</span>
						</div> --}}
						<button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button>
						<img src="http://localhost/{{$product['thumbnail']}}" alt="">
					</div>
					<div class="product-body">
						<h3 class="product-price">$ {{$product['sale_price']}}
							<del class="product-old-price">
								@if ($product->sale_price!=$product->origin_price)
								{{$product['origin_price']}}
								@endif
							</del>
						</h3>
						<div class="product-rating">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-o empty"></i>
						</div>
						<h2 class="product-name"><a href="{{ asset('product') }}/{{$product['slug']}}">{{$product['name']}}</a></h2>
						<div class="product-btns">
							<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
							<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
							<a class="primary-btn  btn" href="{{ asset('product') }}/{{$product['slug']}}"><i class="fa fa-bars"></i> More infor</a>
						</div>
					</div>
				</div>
			</div>
			@endforeach
			<!-- /Product Single -->
		</div>
		<!-- /row -->

		<!-- row -->
		{{-- <div class="row">
			<!-- banner -->
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="banner banner-2">
					<img src="{{ asset('shop_assets/img/banner15.jpg') }}" alt="">
					<div class="banner-caption">
						<h2 class="white-color">NEW<br>COLLECTION</h2>
						<button class="primary-btn">Shop Now</button>
					</div>
				</div>
			</div>
			<!-- /banner -->

			<!-- Product Single -->
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="product product-single">
					<div class="product-thumb">
						<div class="product-label">
							<span>New</span>
							<span class="sale">-20%</span>
						</div>
						<button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button>
						<img src="{{ asset('shop_assets/img/product07.jpg') }}" alt="">
					</div>
					<div class="product-body">
						<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
						<div class="product-rating">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-o empty"></i>
						</div>
						<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
						<div class="product-btns">
							<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
							<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
							<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
						</div>
					</div>
				</div>
			</div>
			<!-- /Product Single -->
		</div> --}}
		<!-- /row -->

		<!-- row -->
		{{-- <div class="row">
			<!-- section title -->
			<div class="col-md-12">
				<div class="section-title">
					<h2 class="title">Picked For You</h2>
				</div>
			</div>
			<!-- section title -->

			<!-- Product Single -->
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="product product-single">
					<div class="product-thumb">
						<div class="product-label">
							<span>New</span>
							<span class="sale">-20%</span>
						</div>
						<button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button>
						<img src="{{ asset('shop_assets/img/product01.jpg') }}" alt="">
					</div>
					<div class="product-body">
						<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
						<div class="product-rating">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-o empty"></i>
						</div>
						<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
						<div class="product-btns">
							<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
							<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
							<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
						</div>
					</div>
				</div>
			</div>
			<!-- /Product Single -->
		</div> --}}
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /section -->
@endsection