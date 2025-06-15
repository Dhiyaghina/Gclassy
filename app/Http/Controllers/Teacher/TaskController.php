<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(ClassRoom $classRoom)
    {
        $tasks = $classRoom->tasks()->latest()->get();
        // dd($classRoom->id);
        return view('teacher.classes.Materi', compact('classRoom', 'tasks'));

    }

    public function store(Request $request, ClassRoom $classRoom)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'attachment' => 'nullable|file|max:2048'
        ]);

        $attachment = $request->file('attachment')?->store('attachments', 'public');

        $classRoom->tasks()->create([
            'title' => $request->title,
            'content' => $request->content,
            'attachment' => $attachment,
        ]);

        return back()->with('success', 'Materi berhasil ditambahkan.');
    }

    public function update(Request $request, ClassRoom $classRoom, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'attachment' => 'nullable|file|max:2048'
        ]);

        if ($request->hasFile('attachment')) {
            if ($task->attachment) {
                Storage::disk('public')->delete($task->attachment);
            }
            $task->attachment = $request->file('attachment')->store('attachments', 'public');
        }

        $task->update([
            'title' => $request->title,
            'content' => $request->content,
            'attachment' => $task->attachment,
        ]);

        return back()->with('success', 'Materi berhasil diupdate.');
    }

    public function destroy(ClassRoom $classRoom, Task $task)
    {
        // if ($task->attachment) {
        //     Storage::disk('public')->delete($task->attachment);
        // }
        $task->delete();

        return back()->with('success', 'Materi berhasil dihapus.');
    }

}
