<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function store(Request $request, Forum $classRoom)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
            'attachment' => 'nullable|file|max:10240' // 10MB max
        ]);

         $forum = new Forum();
    $forum->user_id = Auth::id();
    $forum->class_room_id = $classRoom->id;
    $forum->content = $request->content;

    // Handle file upload jika ada
    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $filename = time() . '_' . $file->getClientOriginalName();
        $forum->attachment = $file->storeAs('forum_attachments', $filename, 'public');
    }

    $forum->save();

    // Redirect kembali ke halaman show dengan fragment untuk scroll ke forum
    return redirect()->route('classrooms.show', $classRoom)
                   ->with('success', 'Postingan berhasil dibuat!')
                   ->withFragment('forum-section');
}
}