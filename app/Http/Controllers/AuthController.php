<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //
    public function showLogin (Request $request, $guard){
        return response()->view('cms.login', ['guard' => $guard]);
    }


    public function login (Request $request){
        $validator = Validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:3|max:30',
            'remember' => 'required|boolean',
            'guard' => 'required|string|in:admin,user'
        ],[
            'guard.in' => 'Wrong URL'
        ]);

        if (!$validator->fails()) {

            $credentials = [
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ];

            if ( Auth::guard($request->get('guard'))->attempt($credentials, $request->get('remember'))){
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

    // public function login (Request $request){
    //     $validator = Validator($request->all(), [
    //         'email' => 'required|email|exists:admins,email',
    //         'password' => 'required|string|min:3|max:30',
    //         'remember' => 'required|boolean',
    //     ]);

    //     if (!$validator->fails()) {

    //         $credentials = [
    //             'email' => $request->get('email'),
    //             'password' => $request->get('password'),
    //         ];

    //         if ( Auth::guard('admin')->attempt($credentials, $request->get('remember'))){
    //             return response()->json([
    //                 'message' => 'Login successfully',
    //             ], Response::HTTP_OK);
    //         }else {
    //             return response()->json([
    //                 'message' => 'Failed login'
    //             ], Response::HTTP_BAD_REQUEST);
    //         }

    //     }else {
    //         return response()->json([
    //             'message' => $validator->getMessageBag()->first()
    //         ], Response::HTTP_BAD_REQUEST);
    //     }
    // }

    // public function logout (Request $request){
    //     auth($request->get('guard'))->logout();
    //     $request->session()->invalidate();
    //     return redirect()->route('logout');
    // }

    public function editPassword () {
        return response()->view('cms.auth.change-password');
    }

    public function updatePassword (Request $request) {

        $guard = auth('admin')->check() ? 'admin' : 'user';

        $validator = Validator($request->all(), [
            // 'current_password' => 'required|string|password:' . $guard,
            'current_password' => "required|string|password:$guard",
            'new_password' => 'required|string|confirmed|min:8|max:30',
        ]);

        if (!$validator->fails()) {

            $user = auth($guard)->user();

            $user->password = Hash::make($request->get('new_password'));
            $isUpdated = $user->save();

            if ($isUpdated) {

                return response()->json([
                    'message' => 'Password changed successfully',
                ], Response::HTTP_OK);

            }else {
                return response()->json([
                    'message' => 'Failed to change password'
                ], Response::HTTP_BAD_REQUEST);
            }

        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function logout (Request $request){
        // if (auth('admin')->check()) {
        //     auth('admin')->logout();
        //     $request->session()->invalidate();
        //     return redirect()->route('logout', 'admin');
        // }else {
        //     auth('user')->logout();
        //     $request->session()->invalidate();
        //     return redirect()->route('logout', 'user');
        // }

        $guard = auth('admin')->check() ? 'admin' : 'user';

        auth($guard)->logout();
        $request->session()->invalidate();
        return redirect()->route('login', $guard);
    }
}
