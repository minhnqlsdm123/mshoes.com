<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// use Gloudemans\Shoppingcart\ShoppingcartServiceProvider;

// Route::get('/cart', function () {
// 	// Add some items in your Controller.
// 	Cart::add('192ao12', 'Product 1', 2, 1000);
// 	Cart::add('1239ad0', 'Product 2', 1, 2000, ['size' => 'large']);

// 	return view('cart');
// });

// Route::get('card/add',function() {
// 	$rowId=request()->all();
// 	$addOrMinus=request()->status;

// 	$product=Cart::get($rowId);

// 	$number=$product->qty;

// 	Cart::update($rowId,$number + $addOrMinus);

// 	return Cart::get($rowId);
// });



Route::prefix('admin')->group(function(){
	Route::get('login', 'AdminAuth\AdminLoginController@showLoginForm')->name('admin.showLoginForm');
	Route::post('login', 'AdminAuth\AdminLoginController@login')->name('admin.login');
	// dang xuat admin
	Route::post('logout', 'AdminAuth\AdminLoginController@logout')->name('admin.logout');
	// dang ky admin
	Route::get('register', 'AdminAuth\AdminRegisterController@showRegistrationForm')->name('admin.showRegistrationForm');
	Route::post('register', 'AdminAuth\AdminRegisterController@register')->name('admin.register');
	
		// Route::get('mail/send', 'MailController@send');
	Route::middleware('admin.auth')->group(function(){
		Route::get('home','AdminHomeController@index')->name('admin_home.index');
		//Admin_Product
		
		Route::get('product','AdminProductController@index')->name('admin_product.index');
		Route::get('product/get-data','AdminProductController@anyData')->name('admin_product.dataTable');
		Route::post('product/store','AdminProductController@store')->name('admin_product.store');
		Route::post('product/add-detail','AdminProductController@add_Detail')->name('admin_product.add_detail');
		Route::get('product/{id}','AdminProductController@show')->name('admin_product.show');
		
		Route::delete('product/{id}','AdminProductController@destroy')->name('admin_product.destroy');
		Route::delete('product/detail/delete/{id}','AdminProductController@destroyDetail');
		Route::get('product/detail/{id}', 'AdminProductController@getProductDetails');


		//Admin_Size
		
		Route::get('size','AdminSizeController@index')->name('admin_size.index');
		Route::get('size/get-data','AdminSizeController@anyData')->name('admin_size.dataTable');
		Route::post('size','AdminSizeController@store')->name('admin_size.store');
		Route::delete('size/{id}','AdminSizeController@destroy')->name('admin_size.destroy');
		Route::get('size/{id}','AdminSizeController@edit')->name('admin_size.edit');
		Route::put('size/{id}','AdminSizeController@update')->name('admin_size.update');



		//Admin_Category
		
		Route::get('category','AdminCategoryController@index')->name('admin_category.index');
		Route::get('category/get-data','AdminCategoryController@anyData')->name('admin_category.dataTable');
		Route::post('category','AdminCategoryController@store')->name('admin_category.store');
		Route::delete('category/{id}','AdminCategoryController@destroy')->name('admin_category.destroy');
		Route::get('category/{id}','AdminCategoryController@edit')->name('admin_category.edit');
		Route::put('category/{id}','AdminCategoryController@update')->name('admin_category.update');



		//Admin_Brand
		
		Route::get('brand','AdminBrandController@index')->name('admin_brand.index');
		Route::get('brand/get-data','AdminBrandController@anyData')->name('admin_brand.dataTable');
		Route::post('brand','AdminBrandController@store')->name('admin_brand.store');
		Route::delete('brand/{id}','AdminBrandController@destroy')->name('admin_brand.destroy');
		Route::get('brand/{id}','AdminBrandController@edit')->name('admin_brand.edit');
		Route::put('brand/{id}','AdminBrandController@update')->name('admin_brand.update');



		//Admin_Color
		
		Route::get('color','AdminColorController@index')->name('admin_color.index');
		Route::get('color/get-data','AdminColorController@anyData')->name('admin_color.dataTable');
		Route::post('color','AdminColorController@store')->name('admin_color.store');
		Route::delete('color/{id}','AdminColorController@destroy');



		//Admin List
		
		Route::get('admin_list','AdminListController@index')->name('admin_list.index');
		Route::get('admin_list/get-data','AdminListController@anyData')->name('admin_list.dataTable');
		Route::post('admin_list','AdminListController@store')->name('admin_list.store');
		Route::get('admin_list/{id}','AdminListController@show');
		Route::delete('admin_list/{id}','AdminListController@destroy');

		//User List

		Route::get('user_list','AdminListUserController@index')->name('user_list.index');
		Route::get('user_list/get-data','AdminListUserController@anyData')->name('user-list.dataTable');


		//Admin list cart
		Route::get('order','AdminCheckoutController@index');
		Route::get('order/get-data','AdminCheckoutController@anyData')->name('admin_order.dataTable');
		Route::get('order/listProduct/{id}','AdminCheckoutController@anyDataProduct')->name('admin_orderDetail.dataTable');
		Route::delete('order/{id}', 'AdminCheckoutController@destroy');

		
	});
	
});

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('showLoginForm');
	Route::post('/login', 'Auth\LoginController@login')->name('login');
	// dang xuat admin
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');
	// dang ky admin
	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('showRegistrationForm');
	Route::post('register', 'Auth\RegisterController@register')->name('register');

Route::get('home', 'HomeController@getIndex')->name('shop.home');
Route::get('/search','HomeController@getSearch')->name('shop.search');
Route::get('product/{slug}', 'ProductController@product_details' );
Route::get('category/{slug}', 'ProductController@getProductByCategory' );
Route::get('brand/{slug}', 'ProductController@getProductByBrand' );
Route::get('size/{size}', 'ProductController@getProductBySize' );
Route::get('color/{color}', 'ProductController@getProductByColor' );
Route::get('all-item', 'ProductController@getAllItemPage')->name('all-item');
Route::get('sale', 'ProductController@product_sale')->name('product-sale');
Route::get('cart', 'ProductController@getCart')->name('getCart');
Route::post('add2cart', 'ProductController@add2cart')->name('add2cart');
Route::get('updateCart/increase/{rowId}', 'ProductController@increase');
Route::get('updateCart/decrease/{rowId}', 'ProductController@decrease');
Route::get('checkout','ProductController@getCheckout')->name('getCheckout');
Route::post('checkout', 'ProductController@checkout')->name('checkout');