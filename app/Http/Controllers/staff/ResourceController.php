<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    protected function authorizeStaff(): void
    {
        if (!auth()->check() || !method_exists(auth()->user(), 'hasStaffAccess') || !auth()->user()->hasStaffAccess()) {
            abort(403, 'Unauthorized');
        }
    }

    public function videos()
    {
        $this->authorizeStaff();
        $modules = Module::with('course')->orderBy('course_id')->orderBy('order')->get();

        return view('staff.videos.list', compact('modules'));
    }

    public function editVideo(Module $module)
    {
        $this->authorizeStaff();

        return view('staff.videos.edit', compact('module'));
    }

    public function updateVideo(Request $request, Module $module)
    {
        $this->authorizeStaff();

        $data = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:102400',
        ]);

        $module = Module::findOrFail($data['module_id']);

        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('staff/resources/video', 'public');
            $module->video_url = Storage::url($path);
        } elseif (!empty($data['video_url'])) {
            $module->video_url = $data['video_url'];
        } else {
            $module->video_url = null;
        }

        $module->save();

        return redirect()->route('staff.videos.index')->with('success', 'Video resource updated successfully.');
    }

    public function storeVideo(Request $request)
    {
        $this->authorizeStaff();

        $data = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:102400',
        ]);

        $module = Module::findOrFail($data['module_id']);

        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('staff/resources/video', 'public');
            $module->video_url = Storage::url($path);
        } elseif (!empty($data['video_url'])) {
            $module->video_url = $data['video_url'];
        } else {
            $module->video_url = null;
        }

        $module->save();

        return redirect()->route('staff.videos.index')->with('success', 'Video resource updated successfully.');
    }

    public function destroyVideo(Module $module)
    {
        $this->authorizeStaff();
        $module->video_url = null;
        $module->save();

        return redirect()->route('staff.videos.index')->with('success', 'Video resource removed.');
    }

    public function images()
    {
        $this->authorizeStaff();
        $modules = Module::with('course')->orderBy('course_id')->orderBy('order')->get();

        return view('staff.images.image', compact('modules'));
    }

    public function editImage(Module $module)
    {
        $this->authorizeStaff();

        return view('staff.images.edit', compact('module'));
    }

    public function updateImage(Request $request, Module $module)
    {
        $this->authorizeStaff();

        $data = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
        ]);

        $module = Module::findOrFail($data['module_id']);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('staff/resources/image', 'public');
            $module->image_url = Storage::url($path);
        } elseif (!empty($data['image_url'])) {
            $module->image_url = $data['image_url'];
        } else {
            $module->image_url = null;
        }

        $module->save();

        return redirect()->route('staff.images.index')->with('success', 'Image resource updated successfully.');
    }

    public function storeImage(Request $request)
    {
        $this->authorizeStaff();

        $data = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
        ]);

        $module = Module::findOrFail($data['module_id']);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('staff/resources/image', 'public');
            $module->image_url = Storage::url($path);
        } elseif (!empty($data['image_url'])) {
            $module->image_url = $data['image_url'];
        } else {
            $module->image_url = null;
        }

        $module->save();

        return redirect()->route('staff.images.index')->with('success', 'Image resource updated successfully.');
    }

    public function destroyImage(Module $module)
    {
        $this->authorizeStaff();
        $module->image_url = null;
        $module->save();

        return redirect()->route('staff.images.index')->with('success', 'Image resource removed.');
    }

    public function powerpoints()
    {
        $this->authorizeStaff();
        $modules = Module::with('course')->orderBy('course_id')->orderBy('order')->get();

        return view('staff.powerpoint.list', compact('modules'));
    }

    public function editPowerPoint(Module $module)
    {
        $this->authorizeStaff();

        return view('staff.powerpoint.edit', compact('module'));
    }

    public function updatePowerPoint(Request $request, Module $module)
    {
        $this->authorizeStaff();

        $data = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'ppt_url' => 'nullable|url',
            'ppt_file' => 'nullable|file|mimes:ppt,pptx,pdf|max:51200',
        ]);

        $module = Module::findOrFail($data['module_id']);

        if ($request->hasFile('ppt_file')) {
            $path = $request->file('ppt_file')->store('staff/resources/ppt', 'public');
            $module->ppt_url = Storage::url($path);
        } elseif (!empty($data['ppt_url'])) {
            $module->ppt_url = $data['ppt_url'];
        } else {
            $module->ppt_url = null;
        }

        $module->save();

        return redirect()->route('staff.powerpoints.index')->with('success', 'PowerPoint resource updated successfully.');
    }

    public function storePowerPoint(Request $request)
    {
        $this->authorizeStaff();

        $data = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'ppt_url' => 'nullable|url',
            'ppt_file' => 'nullable|file|mimes:ppt,pptx,pdf|max:51200',
        ]);

        $module = Module::findOrFail($data['module_id']);

        if ($request->hasFile('ppt_file')) {
            $path = $request->file('ppt_file')->store('staff/resources/ppt', 'public');
            $module->ppt_url = Storage::url($path);
        } elseif (!empty($data['ppt_url'])) {
            $module->ppt_url = $data['ppt_url'];
        } else {
            $module->ppt_url = null;
        }

        $module->save();

        return redirect()->route('staff.powerpoints.index')->with('success', 'PowerPoint resource updated successfully.');
    }

    public function destroyPowerPoint(Module $module)
    {
        $this->authorizeStaff();
        $module->ppt_url = null;
        $module->save();

        return redirect()->route('staff.powerpoints.index')->with('success', 'PowerPoint resource removed.');
    }
}
