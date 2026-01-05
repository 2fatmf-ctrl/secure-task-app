<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // =========================
    // LIST TASKS (USER ONLY)
    // =========================
    public function index()
{
    $tasks = Task::where('user_id', Auth::id())->get();
    return view('tasks.index', compact('tasks'));
}



    // =========================
    // SHOW CREATE FORM
    // =========================
    public function create()
    {
        return view('tasks.create');
    }

    // =========================
    // STORE TASK + AUDIT LOG
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'user_id' => Auth::id(),
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'CREATE_TASK',
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created');
    }

    // =========================
    // SHOW TASK (IDOR PROTECTION)
    // =========================
    public function show(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        return view('tasks.show', compact('task'));
    }

    // =========================
    // EDIT TASK
    // =========================
    public function edit(Task $task)
{
    // SECURITY: ensure only owner can edit
    if ($task->user_id !== auth()->id()) {
        abort(403);
    }

    return view('tasks.edit', compact('task'));
}


    // =========================
    // UPDATE TASK + AUDIT LOG
    // =========================
 public function update(Request $request, Task $task)
{
    if ($task->user_id !== auth()->id()) {
        abort(403);
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $task->update($validated);

    // audit log
    \App\Models\AuditLog::create([
        'user_id' => auth()->id(),
        'action' => 'UPDATE_TASK',
        'ip_address' => request()->ip(),
    ]);

    return redirect()->route('tasks.index');
}


    // =========================
    // DELETE TASK + AUDIT LOG
    // =========================
    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'DELETE_TASK',
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task deleted');
    }
}
