<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TaskController extends Controller
{
    public function index() {
        $tasks = Task::latest()->get();
        return view('tasks', compact('tasks'));
    }

    public function store(Request $request) {
        $request->validate(['title' => 'required|string|max:255']);
        Task::create(['title' => $request->title]);
        return redirect()->back();
    }

    public function toggle(Task $task) {
        $task->update(['is_completed' => !$task->is_completed]);
        return response()->json(['success' => true, 'status' => $task->is_completed]);
    }

    public function destroy(Task $task) {
        $task->delete();
        return redirect()->back();
    }
}
