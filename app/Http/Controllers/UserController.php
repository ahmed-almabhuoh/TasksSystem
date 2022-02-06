<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return response()->view('cms.user.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::select(['id', 'name'])->get();
        return response()->view('cms.user.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|string|min:5|max:50',
        ]);
        //
        if (!$validator->fails()) {
            $user = new User();
            $role = Role::findById($request->input('role_id'), 'user');

            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = Hash::make('password');

            $isCreated = $user->save();

            if($isCreated) {
                $user->assignRole($role);
                return response()->json([
                    'message' => $isCreated ? 'User created successfully' : 'Failed to create user'
                ], $isCreated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
            }
        }else{
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
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
    public function destroy(User $user)
    {
        //
        if ($user->delete()) {
            return response()->json([
                'icon' => 'success',
                'title' => 'Deleted',
                'User deleted successfully',
            ], Response::HTTP_OK);
        }else {
            return response()->json([
                'icon' => 'error',
                'title' => 'Faild',
                'Faild to delete user',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
