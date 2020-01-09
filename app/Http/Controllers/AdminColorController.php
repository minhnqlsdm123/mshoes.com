<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Product;
use App\ProductDetails;
use App\Category;
use App\Brand;
use App\GalleryImage;
use App\Size;
use App\Color;

class AdminColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index_color');
    }

    public function anyData()
    {   
        $list=Color::orderBy('id','desc');
        return Datatables::of($list)
        ->addColumn('action',function($color){

            return '
            <button title="Delete Color" class="btn btn-danger b btnDelete button1" data-id='.$color["id"].'><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        })
        ->editcolumn('code',function($color) {
            return '<div style="background-color:'. $color->code.';  " class="selectColor"></div>';
        })
        ->rawcolumns(['code','action'])
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
        $data=$request->all();
        $exist=Color::where('code','=',$data['code'])->first();
        if (!isset($exist)) {
            return Color::create($data);
        }else{
            return response($content='error',$status=400);
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
          $res =Color::find($id)->delete();
       if ($res==true) {
        return response(['success'], 200);
    } else {
        return response([],400);
    }    
    }
}
