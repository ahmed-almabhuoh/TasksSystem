<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (auth('admin')->check()) {
            $tasks = Task::all();
            return response()->view('cms.task.index', [
                'tasks' => $tasks
            ]);
        }else {
            $tasks = Task::where('user_id', auth('user')->user()->id)
            ->where('position', 'user')
            ->get();
            return response()->view('cms.task.index', [
                'tasks' => $tasks
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (auth('admin')->check()) {
            $categories = Category::where('user_id', auth('admin')->user()->id)->get();
        }else {
            $categories = Category::where('user_id', auth('user')->user()->id)->get();
        }
        // return response()->json($categories);
        return response()->view('cms.task.create', [
            'categories' => $categories
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
            'title' => 'required|string|min:3|max:50',
            'desc' => 'required|string|min:10|max:100',
            'status' => 'required|boolean',
            'category_id' => 'required|integer|exists:categories,id'
        ]);
        //

        if (!$validator->fails()) {
            $task = new Task();

            $task->title = $request->get('title');
            $task->desc = $request->get('desc');
            $task->status = $request->get('status');
            $task->category_id = $request->get('category_id');
            if (auth('admin')->check()) {
                $task->user_id = auth('admin')->user()->id;
                $task->position = 'admin';
            }else {
                $task->user_id = auth('user')->user()->id;
                $task->position = 'user';
            }

            $isCreated = $task->save();
            return response()->json([
                'message' => $isCreated ? 'Task created successfully' : 'Faild to create task',
            ], $isCreated ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
        if (auth('admin')->check()) {
            $categories = Category::all();
            $category = $task->category;
            return response()->view('cms.task.edit', [
                'its_category' => $category,
                'task' => $task,
                'categories' => $categories
            ]);
        }else{
            if ($task->user_id == auth('user')->user()->id) {
                $categories = Category::where('user_id', auth('user')->user()->id)->get();
                $category = $task->category;
                return response()->view('cms.task.edit', [
                    'its_category' => $category,
                    'task' => $task,
                    'categories' => $categories
                ]);
            }else {
                return redirect()->route('task.index');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validator = Validator($request->all(), [
            'title' => 'required|string',
            'desc' => 'required|string|min:10|max:100',
            'status' => 'required|boolean',
            'category_id' => 'required|integer|exists:categories,id'
        ]);


        if (!$validator->fails()) {

            $task->title = $request->get('title');
            $task->desc = $request->get('desc');
            $task->status = $request->get('status');
            $task->category_id = $request->get('category_id');
            if (auth('admin')->check()) {
                $task->user_id = auth('admin')->user()->id;
            }else {
                $task->user_id = auth('user')->user()->id;
            }

            $isUpdated = $task->save();
            return response()->json([
                'message' => $isUpdated ? 'Task updated successfully' : 'Faild to update task',
            ], $isUpdated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
        if ($task->delete()) {
            return response()->json([
                'title'=>'Deleted!',
                'text'=>'Task deleted successfully',
                'icon'=>'success'
            ], Response::HTTP_OK);
        }else {
            return response()->json([
                'title'=>'Deleted!',
                'text'=>'Faild to delete tasks',
                'icon'=>'success'
            ], Response::HTTP_OK);
        }


    }
}
