<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Brand;
use App\Category;
use App\Product;
use App\ProductDetails;
use App\Order;
use App\OrderDetail;
use App\GalleryImage;
use App\Color;
use App\Size;
use App\User;
class AdminCheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view('admin.index_order');
    }

    public function anyData()
    {
        // return Datatables::of(Order::query())
        // ->addColumn('action', function ($order) {
        //  return '<a title="Detail" href="http://ashoes.com/admin/orders/listProduct/'.$order["id"].'" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'.$order["id"].'" id="row-'.$order["id"].'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='.$order["id"].'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='.$order["id"].'></a>';
        // })
        // ->setRowId('id')
        // ->make(true);


        return Datatables::of(Order::query())
        ->addColumn('action', function ($order) {
            return '<a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'.$order["id"].'" id="row-'.$order["id"].'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='.$order["id"].'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='.$order["id"].'></a>';
        })
        // ->editColumn('total',function($order){
        //     return '<p>"'.$order->totail.'"$</p>';
        // })
        ->setRowId('id')
        ->rawColumns(['total','action'])
        ->make(true);
    }


    public function anyDataProduct($id)
    {
        $list_pro = [];
        $list_product_details_id = OrderDetail::where('order_id','=',$id)->get();
        // dd($list_product_details_id);
        foreach ($list_product_details_id as $item) {
            // $product_detail_id = $item['product_detail_id'];
// dd($item);
            $product_id = ProductDetails::where('id','=', $item['product_detail_id'])->first()['product_id'];
            $product = Product::find($product_id);
            $product_detail = ProductDetails::where('id','=', $item['product_detail_id'])->first();

            // dd($product);
            // dd($product_detail);
            $size = Size::where('id','=',$product_detail['size_id'])->first()['size'];
            $color = Color::where('id','=',$product['color_id'])->first()['code'];

            // $list = Product::whereIn('id', $list_product_id)->get();
            $item['name'] = $product['name'];
            $item['brand'] = Brand::find($product['brand_id'])['name'];
            $item['category'] = Category::find($product['category_id'])['name'];
            $thumbnail = GalleryImage::where('product_id','=', $product['id'])->first();
            if (!$thumbnail) {
                $item['thumbnail'] = 'storage/products/shoes_default.png';
            } else {
                $item['thumbnail'] = $thumbnail['link'];
            }
            $item['size'] =$size;
            $item['color'] = $color;
            // dd($item);
            $list_pro[] = $item;
            
        }       
        // dd($list_pro);
        return Datatables::of($list_pro)
        // ->editColumn('thumbnail', function($order) {
        //     return '<img src="/' . $order->galleryImages->first()->link .'"style="width:50px; height=50px;">';
        // })
        
        ->setRowId('id')
        ->rawColumns(['thumbnail'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $res = Order::find($id)->delete();
     if ($res==true) {
        $order_detail=OrderDetail::where('order_id','=',$id)->delete();
       
        return response(['success'], 200);
    } else {
        return response([],400);
    }    
    }
}
