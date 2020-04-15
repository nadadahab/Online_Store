<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ControllerHelperTrait;
    private $rules = array(
        'name' => 'required|min:4',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6'
    ); 

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errors = $this->validation($request,$this->rules);
        $code =201;
        if($errors){
            $code = 500;
            return $this->apiResponse(null,$errors,$code,"Validations errors");
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $token = $user->createToken('token-name');
        return $this->apiResponse(["user" => $user ,"token" => $token->plainTextToken],null,$code,'User registered successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('token-name')->plainTextToken;
            return $this->apiResponse(["token" => $token],null,200,'User logged in successfully');
        } else {
            return $this->apiResponse(null,['errors' => 'UnAuthorised'],401,"incorrect credentials");
        }
    }
}
