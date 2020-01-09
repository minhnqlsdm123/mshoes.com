<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Product;
use App\ProductDetails;
use App\Category;
use App\Brand;
use App\GalleryImage;
use App\Size;
use App\Color;
use Auth;

class AdminProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $categories = Category::all();
        $brands = Brand::all();
        $colors= Color::all();
        $sizes= Size::all();

        // dd($colors);
        return view('admin.index_product',[
            'categories' => $categories,
            'brands' => $brands,
            'colors' =>$colors,
            'sizes'=>$sizes,
            
        ]);

    }

     /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     public function anyData(){

        $list=Product::with(['galleryImages', 'brand', 'category'])->orderBy('id', 'desc');

        return DataTables::of($list)

        ->addColumn('action',function($product) {
            return '
            
            <button title="Add Detail Product" class="btn btn-success btnaddDetail button1" data-id="'.$product["id"].'" id="row-'.$product["id"].'"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
            <button title="List Product" class="btn btn-info btnShow button1" data-id='.$product["id"].'><i class="fa fa-address-book" aria-hidden="true"></i></button>
            <button title="Update Product" class="btn btn-warning  btnEdit button1" data-id='.$product["id"].'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            <button title="Delete Product" class="btn btn-danger b btnDelete button1" data-id='.$product["id"].'><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        })
        ->editColumn('brand_id', function($product) {
            return $product->brand->name;
        })
        ->editColumn('category_id', function($product) {    
            return $product->category->name;
        })

        ->editColumn('thumbnail', function($product) {
            return '<img src="/' . $product->galleryImages->first()->link .'"style="width:50px; height=50px;">';
        })

        ->setRowId('id')
        ->rawColumns(['thumbnail','action'])
        ->make(true);
    }

        // public function dataTableDetail()
    // {   $product=Product::all();
    //     $list=ProductDetails::where('product_id','=',$product['id'])->first();

    //     return DataTables::of($list)
    //     ->addColumn('',function($))
    // }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     $data = $request->all();
        // dd($data);
     $product = array(
        'name' => $data['name'], 
        'origin_price' => $data['origin_price'], 
        'sale_price' => $data['sale_price'], 
        'brand_id' => $data['brand'], 
        'category_id' => $data['category'], 
        'color_id' => $data['color'],
        'description' => $data['description'], 
        'content' => $data['content'], 
        'slug' => str_slug($data['name'], '-'),
        );

     $new_product = Product::create($product);

     if (!$new_product) {
        return redirect()->route('admin_product.index',[
            'error' => 'Add failed!',
        ]);
    } else {

            //save gallery images
        if ($request->hasFile('images')) {

            $date = date('YmdHis', time());

            $images = $request->file('images');

            $gallery_image['product_id'] = $new_product['id'];

            foreach ($images as $image) {
                $name = $image->getClientOriginalName();

                $extension = '.'.$image->getClientOriginalExtension();

                $file_name = md5($request->name.$name).'_'. $date . $extension;

                $image->storeAs('public/products',$file_name);

                $gallery_image['link'] = 'storage/products/'.$file_name;

                GalleryImage::create($gallery_image);
            }

        } else {
                // $data['thumbnail']='storage/products/shoes_default.png';
        }

        return redirect()->route('admin_product.index',[
            'success' => 'Add success!',
        ]);
    }
}

public function add_Detail(Request $request)
{
  $data = $request->all();
    // dd($data);
    $quantity = [];
    foreach ($data as $key => $value) {
        if(str_contains($key, 'quantity')){
            $quantity [] = $value;
        }
    }
    // dd($data);
    $product=ProductDetails::create([
        'product_id' =>$data['id'],
        'size_id' => $data['size'],
        'quantity' =>$data['quantity']

    ]);

    return redirect()->route('admin_product.index',[
        'success' => 'Add Detail success!',
    ]);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        if ($product){
            $product['brand'] = Brand::find($product['brand_id'])['name'];
            $product['category'] = Category::find($product['category_id'])['name'];
            $product['color'] = Color::find($product['color_id'])['color'];
            $thumbnail = GalleryImage::where('product_id','=',$product['id'])->first()['link']; 
            if (!$thumbnail) {
                $product['thumbnail'] = 'storage/products/shoes_default.png';
            } else {
                $product['thumbnail'] = $thumbnail;
            }
        }

        return $product;     
    }

    // public function showImage($id)
    // {
    //     $product=Product::where('id','=',$product['id']);
    
    
    //     $product['gallery']=GalleryImage::where('product_id','=',$product['id'])->select('link')->get();
    
    //     return view('admin.index_product', ['product'=>$product]);
    // }
    

    public function getProductDetails($id)  
    {
        $product_list = ProductDetails::where('product_id', '=', $id)
        ->join('sizes', 'product_details.size_id', '=', 'sizes.id')
        ->select('product_details.*', 'sizes.size')
        ->get();
        // dd($product_list);   
        $infor = Product::find($id);
        $category = Category::find($infor['category_id']);
        $brand = Brand::find($infor['brand_id']);

        foreach ($product_list as $item) {
            $item['name'] = $infor['name'];
            $item['brand'] = $brand['name'];
            $item['category'] = $category['name'];
        }
        return Datatables::of($product_list)
        ->addColumn('action',function($product) {
            return '
            
            <button title="Update Product Detail" class="btn btn-warning  btnEditDetail button1" data-id='.$product["id"].'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            <button title="Delete Product Detail" class="btn btn-danger b btnDeleteDetail button1" data-id='.$product["id"].'><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        })
        // ->editColumn('code', function($product) {
        //     return '<div style="background-color: '.$product->code.'; " class=colordetail></div>';
        // })
        
        // ->rawColumns(['code','action'])
        ->setRowId('id')
        ->make(true);
    }
    public function destroyDetail($id)
    { 
       $res = ProductDetails::find($id)->delete();
       if ($res==true) {

        return response(['success'], 200);
    } else {
        return response([],400);
    }
}    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
       $res = Product::find($id)->delete();
       if ($res==true) {
        $product_detail=ProductDetails::where('product_id','=',$id)->delete();
        $image=GalleryImage::where('product_id','=',$id)->delete();
        return response(['success'], 200);
    } else {
        return response([],400);
    }    
}
}
