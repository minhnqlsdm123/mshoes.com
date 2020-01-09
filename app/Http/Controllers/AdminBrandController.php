<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductDetails;
use App\Brand;
use App\GalleryImage;
use App\Category;
use Yajra\Datatables\Datatables;

class AdminBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index_brand');
    }

    public function anyData()
    {   $list=Brand::orderBy('id','desc');
        return Datatables::of($list)
        
        ->addColumn('action',function($brand) {
            return '
            <button title="Update Brand" class="btn btn-warning  btnEdit button1" data-id='.$brand["id"].'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            <button title="Delete Brand" class="btn btn-danger b btnDelete button1" data-id='.$brand["id"].'><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        })
        
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
        $data = $request->all();
        $data['slug'] = str_slug($data['name'], '-');
        $exist=Brand::where('name','=',$data['name'])->first();
        if (!isset($exist)) {
            return Brand::create($data);
        }
        else{
            return response($content = 'error', $status = 400);
        }
        
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
        return Brand::find($id);
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
        $data = $request->all();
        $res = Brand::find($id)->update($data);
        
        if($res ==true){
            return Brand::find($id);
        } else {
            return response([],400);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Brand::find($id)->delete();
        if ($res==true) {
            return response(['success'], 200);
        } else {
            return response([],400);
        }    
    }
}
