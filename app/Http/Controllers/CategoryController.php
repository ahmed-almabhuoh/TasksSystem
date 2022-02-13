<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Dotenv\Validator;
use Illuminate\Http\Request;
use PHPUnit\Util\Xml\FailedSchemaDetectionResult;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // echo 'WE ARE IN THE :: INDEX';
        if (auth('admin')->check()) {
            $categories = Category::all();
            return response()->view('cms.categories.index', ['categories'=>$categories]);
        }else {
            $categories = Category::where('user_id', auth('user')->user()->id)
            ->where('position', 'user')
            ->get();
            return response()->view('cms.categories.index', ['categories'=>$categories]);
        }

        // $data = Category::all();
        // return response()->view('cms.categories.index', ['categories'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.categories.create');
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
        // Mthods we can use with image request
        // guessExtension()
        //
        $validator = Validator($request->all(), [
            'name'=>'required|string|min:3|max:30',
            'status'=>'required|boolean',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:5048',
        ]);


        if (!$validator->fails()) {

            $category = new Category();
            $category->name = $request->get('name');
            $category->active = $request->get('status');

            // UPLOAD CATEGORY IMAGE
            $image = $request->file('image');
            $image_name = time() . '_category_' . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images\categories'), $image_name);
            $category->image = $image_name;

            if (auth('admin')->check()) {
                $category->user_id = auth('admin')->user()->id;
                $category->position = 'admin';
            }else{
                $category->user_id = auth('user')->user()->id;
                $category->position = 'user';
            }

            $isCreated = $category->save();

            return response()->json([
                'message'=> $isCreated ? 'Category created successfully' : 'Category created failed',
            ], $isCreated ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message'=>$validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        if (auth('admin')->check()) {
            return response()->view('cms.categories.edit', ['category'=>$category]);
        }else {
            if ($category->user_id == auth('user')->user()->id && $category->position == 'user') {
                return response()->view('cms.categories.edit', ['category'=>$category]);
            }else {
                return redirect()->route('categories.index');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $validator = Validator($request->all(), [
            'name'=>'required|string|min:3|max:30',
            'status'=>'required|boolean'
        ]);

        if (!$validator->fails()) {
            $category->name = $request->get('name');
            $category->active = $request->get('status');
            $isUpdated = $category->save();

            return response()->json([
                'message' => $isUpdated ? 'Category updated successfully' : 'Category updated failed',
            ], $isUpdated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);


        }else{
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $isDeleted = $category->delete();

        if ($isDeleted) {
            return response()->json([
                'title'=>'Deleted!',
                'text'=>'Category deleted successfully',
                'icon'=>'success'
            ], Response::HTTP_OK);
        }else{
            return response()->json([
                'title'=>'Failed!',
                'text'=>'Category deleted failed',
                'icon'=>'error'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
