<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Dotenv\Validator;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $data = Category::where('user_id', auth('api')->user()->id)->get();

        // ANOTHER QUERY
        $data = auth('api')->user()->categories;
        return response()->json([
            'status' => true,
            'data' => $data,
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
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'active' => 'required|boolean'
        ]);

        if (!$validator->fails()) {
            $category = new Category();

            $category->name = $request->get('name');
            $category->active = $request->get('active');
            $category->user_id = auth('api')->user()->id;
            $category->position = 'user';

            $isSaved = $category->save();

            return response()->json([
                'message' => $isSaved ? 'Category created successfully' : 'Faild to create category',
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'active' => 'required|boolean'
        ]);

        if (!$validator->fails()) {
            $category = Category::find($id);

            if (!is_null($category)) {

                $exists = Category::where('id', $id)
                ->where('user_id', auth('api')->user()->id)
                ->exists();

                if ($exists) {
                    $category = Category::where('id', $id)
                    ->where('user_id', auth('api')->user()->id)
                    ->first();

                    $category->name = $request->get('name');
                    $category->active = $request->get('active');
                    $category->user_id = auth('api')->user()->id;
                    $category->position = 'user';

                    $isSaved = $category->save();

                    return response()->json([
                        'message' => $isSaved ? 'Category updated successfully' : 'Faild to update category',
                    ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
                }else {
                    return response()->json([
                        'message' => 'Unothrized access'
                    ], Response::HTTP_BAD_REQUEST);
                }

            }else {
                return response()->json([
                    'message' => 'Faild to find item'
                ], Response::HTTP_BAD_REQUEST);
            }
        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
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
        //

        $category = Category::find($id);
        if (!is_null($category)) {
            $exists = Category::where('id', $category->id)
            ->where('user_id', auth('api')->user()->id)
            ->exists();

            if ($exists) {
                if ($category->delete()) {
                    return response()->json([
                        'message' => 'Category deleted successfully'
                    ], Response::HTTP_OK);
                }else {
                    return response()->json([
                        'message' => 'Faild to delete category'
                    ], Response::HTTP_BAD_REQUEST);
                }
            }else {
                return response()->json([
                    'message' => 'Something wrong happened',
                ], Response::HTTP_BAD_REQUEST);
            }
        }else {
            return response()->json([
                'message' => 'Fiald to find item',
            ], Response::HTTP_BAD_REQUEST);
        }

    }
}
