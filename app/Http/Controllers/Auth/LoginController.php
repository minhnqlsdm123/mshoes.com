<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Category;
use App\Brand;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
   use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * show login form
     * @return [type] [description]
     */
    public function showLoginForm()
    {   
        $brand_list=Brand::all();
        $category_list=Category::all();
        return view('shop.auth.login',['category_list'=>$category_list,
                                        'brand_list'=>$brand_list
                                            ]);
    }

     public function logout(Request $request)
    {
        $this->guard()->logout();
        // $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect()->route('shop.home');
    }
}