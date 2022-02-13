<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{
    //

    // public function login (Request $request)
    // {
    //     $validator = Validator($request->all(), [
    //         'email' => 'required|string|email|exists:users,email',
    //         'password' => 'required|string' // |password:api
    //     ]);

    //     if (!$validator->fails()) {
    //         $user= User::where('email', $request->get('email'))->first();
    //         if (Hash::check($request->get('password'), $user->password)) {

    //             $this->revokePreviosTokens($user->id);
    //             $token = $user->createToken('User-Api');
    //             $user->setAttribute('token', $token->accessToken);

    //             return response()->json([
    //                 'message' => 'Loggin successfully',
    //                 'data' => $user
    //             ], Response::HTTP_OK);
    //         }else {
    //             return response()->json([
    //                 'message' => 'Wrong password',
    //             ], Response::HTTP_BAD_REQUEST);
    //         }
    //     }else{
    //         return response()->json([
    //             'message' => $validator->getMessageBag()->first()
    //         ], Response::HTTP_BAD_REQUEST);
    //     }
    // }


    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string' // |password:api
        ]);

        if (!$validator->fails()) {
            $user = User::where('email', $request->get('email'))->first();
            if (Hash::check($request->get('password'), $user->password)) {

                if (!$this->checkForActiveTokens($user->id)) {
                    $token = $user->createToken('User-Api');
                    $user->setAttribute('token', $token->accessToken);

                    return response()->json([
                        'message' => 'Loggin successfully',
                        'data' => $user
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'message' => 'You cannot login from more than one device at the save time.',
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'message' => 'Wrong password',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function adminLogin(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|string|email|exists:admins,email',
            'password' => 'required|string' // |password:api
        ]);

        if (!$validator->fails()) {
            $admin = Admin::where('email', $request->get('email'))->first();
            if (Hash::check($request->get('password'), $admin->password)) {

                if (!$this->checkForActiveTokens($admin->id)) {
                    $token = $admin->createToken('User-Api');
                    $admin->setAttribute('token', $token->accessToken);

                    return response()->json([
                        'message' => 'Loggin successfully',
                        'data' => $admin
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'message' => 'You cannot login from more than one device at the save time.',
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'message' => 'Wrong password',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    // public function login (Request $request)
    // {
    //     $validator = Validator($request->all(), [
    //         'email' => 'required|string|email|exists:users,email',
    //         'password' => 'required|string' // |password:api
    //     ]);

    //     if (!$validator->fails()) {
    //         $response = Http::asForm()->post('http://localhost:8001/oauth/token/', [
    //             'grant_type' => 'password',
    //             'client_id' => '3',
    //             'client_secret' => 'Pvyo3Pzhzn6nvwJcLwekEY15IusMGban8nMoVg12',
    //             'username' => $request->get('email'),
    //             'password' => $request->get('password'),
    //             'scope' => '*'
    //         ]);

    //         return $request->json();
    //     }else{
    //         return response()->json([
    //             'message' => $validator->getMessageBag()->first()
    //         ], Response::HTTP_BAD_REQUEST);
    //     }
    // }

    public function forgetPassword(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if (!$validator->fails()) {
            $code = rand(5000, 100000);
            $user = User::where('email', $request->get('email'))->first();
            $user->verification_code = Hash::make($code);
            $isSaved = $user->save();
            if ($isSaved) {
                return response()->json([
                    'message' => 'Verfication code send',
                    'code' => $code,
                    'email' => $request->get('email')
                ], Response::HTTP_OK);
            }else {
                return response()->json([
                    'message' => 'Something wrong happened'
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function resetPassword (Request $request) {
        $validator = Validator($request->all(), [
            'email' => 'required|string|exists:users,email',
            'code' => 'required|numeric|digits:5',
            'password' => 'required|string|min:8|max:40|confirmed',
        ]);

        if (!$validator->fails()) {
            $user = User::where('email', $request->get('email'))->first();
            if (Hash::check($request->get('code'), $user->verification_code)) {
                $user->password = Hash::make($request->get('password'));

                $isUpdated = $user->save();
                if ($isUpdated) {
                    return response()->json([
                        'message' => 'Password changed successfully'
                    ], Response::HTTP_OK);
                }else {
                    return response()->json([
                        'message' => 'Something wrong happened'
                    ], Response::HTTP_BAD_REQUEST);
                }
            }else {
                return response()->json([
                    'message' => 'Validation code is not correct',
                ], Response::HTTP_BAD_REQUEST);
            }
        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    private function revokePreviosTokens($userId)
    {
        DB::table('oauth_access_tokens')
            ->where('user_id', $userId)
            ->update([
                'revoked' => true,
            ]);
    }

    private function checkForActiveTokens($userId)
    {
        return DB::table('oauth_access_tokens')
            ->where('user_id', $userId)
            ->where('revoked', false)
            ->exists();
    }

    public function logout(Request $request)
    {
        // $token = auth('api')->user()->token();
        // $isRevoked = $token->revoke();
        // return response()->json([
        //     'status' => $isRevoked
        // ]);

        $isRevoked = auth('api')->user()->token()->revoke();
        return response()->json([
            'status' => $isRevoked,
            'message' => $isRevoked ? 'Logged out successfully' : 'Faild to log out'
        ], $isRevoked ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
