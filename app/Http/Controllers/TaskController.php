<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('id', 'desc')->get();
        return view('tasks', compact('tasks'));
    }

    public function addTasks()
    {
        return view('add-tasks');
    }

    public function storeTasks(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);


        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'emsg' => $validator->errors()->all()
                ]
            );
        }

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->save();

        return response()->json([
            'success' => true,
            'msg' => 'Task saved successfully'
        ]);
    }

    public function editTask(Request $request)
    {
        $task = Task::find($request->id);
        return view('edit-tasks', compact('task'));
    }

    public function updateTasks(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);


        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'emsg' => $validator->errors()->all()
                ]
            );
        }

        $task = Task::find($request->task_id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->update();

        return response()->json([
            'success' => true,
            'msg' => 'Task update successfully'
        ]);
    }

    public function deleteTask(Request $request)
    {
        // Find the task by its ID
        $task = Task::find($request->id);

        // Check if the task exists
        if ($task) {
            // Delete the task
            $task->delete();

            // Return a success response
            return response()->json(['success' => true, 'msg' => 'Task deleted successfully'], 200);
        } else {
            // If the task does not exist, return a not found response
            return response()->json(['emsg' => 'Task not found'], 404);
        }
    }
}
