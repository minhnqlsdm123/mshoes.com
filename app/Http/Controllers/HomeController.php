<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductDetails;
use App\Category;
use App\Brand;
use App\GalleryImage;
use App\Size;
use App\Color;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function getIndex()
    {
        $brand_list = Brand::all();
        $category_list = Category::all();

        $lastest_product = Product::orderBy('created_at', 'desc')->take(8)->get();
        foreach ($lastest_product as $item) {
            $thumbnail = GalleryImage::where('product_id', '=', $item['id'])->first()['link'];
            if ($thumbnail) {
                $item['thumbnail'] = $thumbnail;
            } else {
                $item['thumbnail'] = 'storage/products/shoes_default.png';
            }
        }

        

        return view('shop.index',[
            'brand_list' => $brand_list,
            'category_list' => $category_list,
            'lastest_product' => $lastest_product,
        ]);
    }

    public function getSearch(Request $request)
    {   
        $brand_list = Brand::all();
        $category_list = Category::all();

        $products = Product::where('name','like',$request->key."%")
                            ->orWhere('origin_price',$request->key)
                            ->orWhere('sale_price',$request->key)
                            ->get();
        foreach ($products as $item) {
            $thumbnail = GalleryImage::where('product_id', '=', $item['id'])->first()['link'];
            if ($thumbnail) {
                $item['thumbnail'] = $thumbnail;
            } else {
                $item['thumbnail'] = 'storage/products/shoes_default.png';
            }
        }
        return view('shop.pages.search',['products'=>$products,
                                    'brand_list' => $brand_list,
                                    'category_list' => $category_list,]);
    }
}
