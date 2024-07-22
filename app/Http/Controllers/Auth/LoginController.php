<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;




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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

        $inputVal = $request->all();
//        dd($inputVal);
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->attempt(array('email' => $inputVal['email'], 'password' => $inputVal['password']))){
            if (auth()->user()->is_admin == 1) {
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('home');
            }
        }else{
            return back()->with('mesg','Email & Password are incorrect.');
        }
    }

    public function Userlogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            $user = auth()->user();
            $token = JWTAuth::fromUser($user);
            $user_id = $user->id;
            $user_name = $user->name;
            

            return response()->json(['token' => $token, 'message' => 'Login successful' , 'user_id' => $user_id , 'user_name' => $user_name]);
        } else {
            return response()->json(['error' => 'Email Or Password are incorrect.'], 401);
        }
    }


    public function logout () {
        //logout user
        auth()->logout();
        // redirect to homepage
        return redirect('/');
    }
}
