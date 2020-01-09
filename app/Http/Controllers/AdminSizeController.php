<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Size;
use App\Product;
use App\ProductDetails;
use App\Brand;
use App\GalleryImage;
use App\Category;
use Yajra\Datatables\Datatables;


class AdminSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index_size');
    }

    public function anyData()
    {
        $list=Size::orderBy('id','desc');
        return Datatables::of($list)

        ->addColumn('action',function($size) {
            return ' 
            <button title="Update Size" class="btn btn-warning  btnEdit button1" data-id='.$size["id"].'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            <button title="Delete Size" class="btn btn-danger b btnDelete button1" data-id='.$size["id"].'><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
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
        $exist = Size::where('size','=',$data['size'])->first();
        if ( !isset($exist) ) {
            return  Size::create($data);
            
        } else {
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
        return Size::find($id);
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
        $data=$request->all();
        $exist=Size::where('size','=',$data['size'])->first();
        $response=Size::find($id)->update($data);
        if (!isset($exist)) {
            if ($response==true) {
                return Size::find($id);

            }else{
                return response(['error'],400);
            }
        }else{
            return response(['error'],400);
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
        $response = Size::find($id)->delete();
        if ($response == true) {
            return response(['success'], 200);
        } else {
            return response([],400);
        }    
    }
}
