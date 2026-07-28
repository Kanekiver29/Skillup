<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class LessonController extends Controller
{
    public function create(Module $module)
    {
        // basic ownership check: module->course instructor
        $userId = auth()->id();
        if (!(($module->course->instructor_id ?? null) === $userId || (($module->course->instructor_id === null) && ($module->course->instructor_name ?? '') === (auth()->user()->name ?? '')))) abort(403);

        return view('teacher.lessons.create', compact('module'));
    }

    public function store(Request $request, Module $module)
    {
        $userId = auth()->id();
        if (!(($module->course->instructor_id ?? null) === $userId || (($module->course->instructor_id === null) && ($module->course->instructor_name ?? '') === (auth()->user()->name ?? '')))) abort(403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200',
            'material' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:20480',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $lesson = new Lesson();
        $lesson->module_id = $module->id;
        $lesson->title = $data['title'];
        $lesson->description = $data['description'] ?? null;
        $lesson->content = $data['content'] ?? null;
        $lesson->duration_minutes = $data['duration_minutes'] ?? 0;
        $lesson->is_published = false;

        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('lessons/videos', 'public');
            $lesson->video_url = Storage::url($path);
        }

        if ($request->hasFile('material')) {
            $path = $request->file('material')->store('lessons/materials', 'public');
            $lesson->material_url = Storage::url($path);
        }

        $lesson->save();

        return redirect()->route('teacher.modules.edit', $module->id)->with('success', 'Lesson created.');
    }

    public function edit(Module $module, Lesson $lesson)
    {
        $userId = auth()->id();
        if (!(($module->course->instructor_id ?? null) === $userId || (($module->course->instructor_id === null) && ($module->course->instructor_name ?? '') === (auth()->user()->name ?? '')))) abort(403);

        return view('teacher.lessons.edit', compact('module','lesson'));
    }

    public function update(Request $request, Module $module, Lesson $lesson)
    {
        $userId = auth()->id();
        if (!(($module->course->instructor_id ?? null) === $userId || (($module->course->instructor_id === null) && ($module->course->instructor_name ?? '') === (auth()->user()->name ?? '')))) abort(403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200',
            'material' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:20480',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $lesson->title = $data['title'];
        $lesson->description = $data['description'] ?? null;
        $lesson->content = $data['content'] ?? null;
        $lesson->duration_minutes = $data['duration_minutes'] ?? $lesson->duration_minutes;

        if ($request->hasFile('video')) {
            // remove old video if present
            if (!empty($lesson->video_url) && str_contains($lesson->video_url, '/storage/')) {
                $relative = substr($lesson->video_url, strpos($lesson->video_url, '/storage/') + 9);
                Storage::disk('public')->delete($relative);
            }
            $path = $request->file('video')->store('lessons/videos', 'public');
            $lesson->video_url = Storage::url($path);
        }

        if ($request->hasFile('material')) {
            if (!empty($lesson->material_url) && str_contains($lesson->material_url, '/storage/')) {
                $relative = substr($lesson->material_url, strpos($lesson->material_url, '/storage/') + 9);
                Storage::disk('public')->delete($relative);
            }
            $path = $request->file('material')->store('lessons/materials', 'public');
            $lesson->material_url = Storage::url($path);
        }

        $lesson->save();

        return redirect()->route('teacher.modules.edit', $module->id)->with('success', 'Lesson updated.');
    }

    public function destroy(Module $module, Lesson $lesson)
    {
        $userId = auth()->id();
        if (!(($module->course->instructor_id ?? null) === $userId || (($module->course->instructor_id === null) && ($module->course->instructor_name ?? '') === (auth()->user()->name ?? '')))) abort(403);

        if (!empty($lesson->video_url) && str_contains($lesson->video_url, '/storage/')) {
            $relative = substr($lesson->video_url, strpos($lesson->video_url, '/storage/') + 9);
            Storage::disk('public')->delete($relative);
        }

        if (!empty($lesson->material_url) && str_contains($lesson->material_url, '/storage/')) {
            $relative = substr($lesson->material_url, strpos($lesson->material_url, '/storage/') + 9);
            Storage::disk('public')->delete($relative);
        }

        $lesson->delete();

        return redirect()->route('teacher.modules.edit', $module->id)->with('success', 'Lesson deleted.');
    }

    public function download(Module $module, Lesson $lesson)
    {
        $userId = auth()->id();
        if (!(($module->course->instructor_id ?? null) === $userId || (($module->course->instructor_id === null) && ($module->course->instructor_name ?? '') === (auth()->user()->name ?? '')))) abort(403);

        if (empty($lesson->material_url)) {
            abort(404);
        }

        // If stored on local disk via Storage::url(), return a download response
        if (str_contains($lesson->material_url, '/storage/')) {
            $relative = substr($lesson->material_url, strpos($lesson->material_url, '/storage/') + 9);
            if (Storage::disk('public')->exists($relative)) {
                return Storage::disk('public')->download($relative);
            }
        }

        // External URL or not accessible via storage: redirect
        return redirect($lesson->material_url);
    }
}
