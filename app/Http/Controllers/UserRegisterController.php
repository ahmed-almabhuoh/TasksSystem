<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UserRegisterController extends Controller
{
    //
    public function showRegister () {
        return response()->view('cms.register');
    }

    public function register (Request $request) {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|string|min:5|max:40',
            'password' => 'required|string|min:8|max:50',
            're_password' => 'required|string|min:8|max:50',
        ]);

        if (!$validator->fails()) {

            if ($request->get('password') == $request->get('re_password')) {

                $role = Role::findById(2, 'user');

                $user = new User();
                $user->name = $request->get('name');
                $user->email = $request->get('email');
                $user->password = Hash::make($request->get('password'));

                $isSaved = $user->save();

                if ($isSaved) {
                    $user->assignRole($role);
                    return response()->json([
                        'message' => $isSaved ? 'Created successfully' : 'Registration fails',
                    ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
                }

            }else {
                return response()->json([
                    'message' => 'Your password does not maches'
                ], Response::HTTP_BAD_REQUEST);
            }


        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
