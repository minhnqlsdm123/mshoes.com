<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Admin;
use Illuminate\Support\Facades\Hash;


class AdminListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index_admin');
    }

    public function anyData()
    {
        $list=Admin::all();
        // dd($list);
        return Datatables::of($list)

        ->addColumn('action',function($admin) {
            return '<button title="List Admin" class="btn btn-info btnshow button1" data-id='.$admin["id"].'><i class="fa fa-address-book" aria-hidden="true"></i></button>
            <button title="Update Admin" class="btn btn-warning  btnEdit button1" data-id='.$admin["id"].'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            <button title="Delete Admin" class="btn btn-danger b btnDelete button1" data-id='.$admin["id"].'><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        })
        ->editColumn('avatar', function($admin) {
            return '<img src="/' . $admin['avatar'] .'"style="width:50px; height=50px;">';
        })

        ->setRowId('id')
        ->rawColumns(['avatar','action'])
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

        $date = date('YmdHis', time());

        if ($request->hasFile('thumbnail')) {

            $extension = '.'.$data['thumbnail']->getClientOriginalExtension();

            $file_name = md5($request->name).'_'. $date . $extension;

            $data['thumbnail']->storeAs('public/admin_profile',$file_name);

            $data['avatar'] = 'storage/admin_profile/'.$file_name;

        }else {
            $data['avatar']='storage/admin_profile/userDefault.png';
        }

        $user_name = explode('@', $data['email'])[0];

        $data['password'] = Hash::make($user_name);

        return Admin::create($data);
    }

     /**
     * get admin's info and display
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
     public function show($id)
     {
        return Admin::findOrFail($id);
    }

    /**
     * get admin's infomation and display to edit
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        return Admin::find($id);
    }

    /**
     * update admin by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request,$id)
    {
        $data = $request->all();
        $res = Admin::find($id)->update($data);
        if($res ==true){
            return Admin::find($id);
        } else {
            return response([],400);
        }
    }

    /**
     * delete admin by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $res = Admin::find($id)->delete();
        if ($res==true) {
            return response(['success'], 200);
        } else {
            return response([],400);
        }       
    }
}
