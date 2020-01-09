<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Category;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index_category');
    }

    public function anyData()
    {   $list=Category::orderBy('id','desc');
        return Datatables::of($list)

        ->addColumn('action',function($category) {
            return '<button title="List Category" class="btn btn-info btnList button1" data-id='.$category["id"].'><i class="fa fa-address-book" aria-hidden="true"></i></button>
            <button title="Update Category" class="btn btn-warning  btnEdit button1" data-id='.$category["id"].'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            <button title="Delete Category" class="btn btn-danger b btnDelete button1" data-id='.$category["id"].'><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
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
     $data['slug'] = str_slug($request->name, '-');
     $exist=Category::where('name','=',$data['name'])->first();
     if (!isset($exist)) {
         return Category::create(
            [ 'name' => $data['name'],
              'description' => $data['description'],
              'slug' => $data['slug']
            ]);
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
        return Category::findOrFail($id);
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
        $response = Category::find($id)->update($data);
        
        if($response==true){
            return Category::find($id);
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
        $response = Category::find($id)->delete();
        if ($response==true) {
            return response(['success'], 200);
        } else {
            return response([],400);
        }    
    }
}
