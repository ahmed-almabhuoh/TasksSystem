<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //
    public function showLogin (){
        return response()->view('cms.login');
    }

    public function login (Request $request){
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string|min:3|max:30',
            'remember' => 'required|boolean',
        ]);

        if (!$validator->fails()) {

            $credentials = [
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ];

            if ( Auth::guard('admin')->attempt($credentials, $request->get('remember'))){
                return response()->json([
                    'message' => 'Login successfully',
                ], Response::HTTP_OK);
            }else {
                return response()->json([
                    'message' => 'Failed login'
                ], Response::HTTP_BAD_REQUEST);
            }

        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout (Request $request){
        auth('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('logout');
    }
}
