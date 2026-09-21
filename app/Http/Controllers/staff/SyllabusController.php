<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use App\Models\SyllabusSection;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class SyllabusController extends Controller
{
    public function __construct()
    {
        // Ensure only staff (and admins) can access
        $this->middleware(['auth', \App\Http\Middleware\EnsureStaff::class]);
    }

    /**
     * Display a listing of the syllabi.
     */
    public function index()
    {
        $syllabi = Syllabus::with('course')->orderBy('created_at', 'desc')->paginate(15);
        return view('staff.sysllabus.index', compact('syllabi'));
    }

    /**
     * Show the form for creating a new syllabus.
     */
    public function create()
    {
        $courses = Course::orderBy('title')->get();
        return view('staff.sysllabus.create', compact('courses'));
    }

    /**
     * Store a newly created syllabus in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'               => 'required|exists:courses,id',
            'title'                   => 'required|string|max:255',
            'description'             => 'nullable|string',
            'effective_start'         => 'nullable|date',
            'effective_end'           => 'nullable|date|after_or_equal:effective_start',
            'is_published'            => 'sometimes|boolean',
            'sections'                => 'required|array|max:10',
            'sections.*.section_title'=> 'required|string|max:255',
            'sections.*.content'      => 'nullable|string',
            'photos'                  => 'nullable|array|max:25',
            'photos.*'                => 'image|max:5120',
            'videos'                  => 'nullable|array|max:3',
            'videos.*'                => 'mimetypes:video/mp4,video/webm,video/ogg|max:20480',
        ]);

        $syllabus = new Syllabus();
        $syllabus->course_id     = $validated['course_id'];
        $syllabus->title         = $validated['title'];
        $syllabus->description   = $validated['description'] ?? null;
        $syllabus->effective_start = $validated['effective_start'] ?? null;
        $syllabus->effective_end   = $validated['effective_end'] ?? null;
        $syllabus->is_published  = $validated['is_published'] ?? false;
        $syllabus->created_by    = Auth::id();
        $syllabus->updated_by    = Auth::id();
        $syllabus->save();

        // Store photos
        if ($request->hasFile('photos')) {
            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $photoPaths[] = $photo->store("syllabi/{$syllabus->id}/photos", 'public');
            }
            $syllabus->photos = $photoPaths;
        }

        // Store videos
        if ($request->hasFile('videos')) {
            $videoPaths = [];
            foreach ($request->file('videos') as $video) {
                $videoPaths[] = $video->store("syllabi/{$syllabus->id}/videos", 'public');
            }
            $syllabus->videos = $videoPaths;
        }

        $syllabus->save();

        // Persist sections with ordering
        foreach ($validated['sections'] as $index => $sectionData) {
            $syllabus->sections()->create([
                'section_title' => $sectionData['section_title'],
                'content'       => $sectionData['content'] ?? null,
                'order'         => $index,
            ]);
        }

        return Redirect::route('staff.syllabi.index')->with('success', 'Syllabus created successfully.');
    }

    /**
     * Show the form for editing the specified syllabus.
     */
    public function edit(Syllabus $syllabus)
    {
        $courses = Course::orderBy('title')->get();
        $syllabus->load('sections');
        return view('staff.sysllabus.edit', compact('syllabus', 'courses'));
    }

    /**
     * Update the specified syllabus in storage.
     */
    public function update(Request $request, Syllabus $syllabus)
    {
        $validated = $request->validate([
            'course_id'                => 'required|exists:courses,id',
            'title'                    => 'required|string|max:255',
            'description'              => 'nullable|string',
            'effective_start'          => 'nullable|date',
            'effective_end'            => 'nullable|date|after_or_equal:effective_start',
            'is_published'             => 'sometimes|boolean',
            'sections'                 => 'required|array|max:10',
            'sections.*.id'            => 'nullable|exists:syllabus_sections,id',
            'sections.*.section_title' => 'required|string|max:255',
            'sections.*.content'       => 'nullable|string',
            'photos'                   => 'nullable|array|max:25',
            'photos.*'                 => 'image|max:5120',
            'videos'                   => 'nullable|array|max:3',
            'videos.*'                 => 'mimetypes:video/mp4,video/webm,video/ogg|max:20480',
        ]);

        $syllabus->course_id      = $validated['course_id'];
        $syllabus->title          = $validated['title'];
        $syllabus->description    = $validated['description'] ?? null;
        $syllabus->effective_start= $validated['effective_start'] ?? null;
        $syllabus->effective_end  = $validated['effective_end'] ?? null;
        $syllabus->is_published   = $validated['is_published'] ?? false;
        $syllabus->updated_by     = Auth::id();

        // Handle existing photos (kept from form) + new uploads
        $keptPhotos = [];
        if ($request->filled('existing_photos')) {
            $decoded = json_decode($request->input('existing_photos'), true);
            if (is_array($decoded)) {
                $keptPhotos = $decoded;
            }
        }

        if ($request->hasFile('photos')) {
            $limit = 25 - count($keptPhotos);
            $uploaded = 0;
            foreach ($request->file('photos') as $photo) {
                if ($uploaded >= $limit) break;
                $keptPhotos[] = $photo->store("syllabi/{$syllabus->id}/photos", 'public');
                $uploaded++;
            }
        }

        $syllabus->photos = !empty($keptPhotos) ? $keptPhotos : null;

        // Handle existing videos (kept from form) + new uploads
        $keptVideos = [];
        if ($request->filled('existing_videos')) {
            $decoded = json_decode($request->input('existing_videos'), true);
            if (is_array($decoded)) {
                $keptVideos = $decoded;
            }
        }

        if ($request->hasFile('videos')) {
            $limit = 3 - count($keptVideos);
            $uploaded = 0;
            foreach ($request->file('videos') as $video) {
                if ($uploaded >= $limit) break;
                $keptVideos[] = $video->store("syllabi/{$syllabus->id}/videos", 'public');
                $uploaded++;
            }
        }

        $syllabus->videos = !empty($keptVideos) ? $keptVideos : null;

        $syllabus->save();

        // Sync sections
        $existingIds  = $syllabus->sections()->pluck('id')->toArray();
        $submittedIds = [];
        foreach ($validated['sections'] as $index => $sectionData) {
            if (!empty($sectionData['id'])) {
                $section = SyllabusSection::find($sectionData['id']);
                $section->update([
                    'section_title' => $sectionData['section_title'],
                    'content'       => $sectionData['content'] ?? null,
                    'order'         => $index,
                ]);
                $submittedIds[] = $section->id;
            } else {
                $new = $syllabus->sections()->create([
                    'section_title' => $sectionData['section_title'],
                    'content'       => $sectionData['content'] ?? null,
                    'order'         => $index,
                ]);
                $submittedIds[] = $new->id;
            }
        }

        // Delete removed sections
        $toDelete = array_diff($existingIds, $submittedIds);
        if (!empty($toDelete)) {
            SyllabusSection::whereIn('id', $toDelete)->delete();
        }

        return Redirect::route('staff.syllabi.index')->with('success', 'Syllabus updated successfully.');
    }

    /**
     * Remove the specified syllabus from storage.
     */
    public function destroy(Syllabus $syllabus)
    {
        $syllabus->delete(); // soft delete
        return Redirect::route('staff.syllabi.index')->with('success', 'Syllabus deleted.');
    }

    /**
     * Toggle publication status.
     */
    public function publish(Syllabus $syllabus)
    {
        $syllabus->togglePublish();
        return Redirect::back()->with('success', 'Publication status updated.');
    }
}
?>
