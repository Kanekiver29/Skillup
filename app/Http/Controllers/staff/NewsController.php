<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * List all news/announcements (newest first).
     */
    public function index()
    {
        $news = NewsItem::latest('published_at')->get();
        return view('staff.news.index', compact('news'));
    }

    /**
     * Store a new announcement.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|in:update,academic,event,alert',
            'audience' => 'nullable|string|max:100',
            'content'  => 'required|string',
            'photos'   => 'nullable|array|max:25',
            'photos.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'videos'   => 'nullable|array|max:3',
            'videos.*' => 'file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm,video/ogg,video/x-matroska|max:20480',
        ]);

        $newsItem = NewsItem::create([
            'title'           => $request->title,
            'category'        => $request->category,
            'target_audience' => $request->audience ?? 'all',
            'content'         => $request->content,
            'is_featured'     => $request->boolean('is_featured'),
            'published_at'    => now(),
            'view_count'      => 0,
        ]);

        $firstPhoto = null;
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('news_images', 'public');
                if ($index === 0) {
                    $firstPhoto = $path;
                }
                $newsItem->media()->create([
                    'file_path' => $path,
                    'type'      => 'image',
                ]);
            }
        }

        $firstVideo = null;
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $index => $video) {
                $path = $video->store('news_videos', 'public');
                if ($index === 0) {
                    $firstVideo = $path;
                }
                $newsItem->media()->create([
                    'file_path' => $path,
                    'type'      => 'video',
                ]);
            }
        }

        // Backfill legacy columns for backwards compatibility
        $newsItem->update([
            'featured_image' => $firstPhoto,
            'video_file'     => $firstVideo,
        ]);

        return redirect()->route('staff.news.index')
                         ->with('success', 'Announcement published successfully!');
    }

    /**
     * Update an existing announcement.
     */
    public function update(Request $request, $id)
    {
        $newsItem = NewsItem::findOrFail($id);

        $request->validate([
            'title'           => 'required|string|max:255',
            'category'        => 'required|in:update,academic,event,alert',
            'audience'        => 'nullable|string|max:100',
            'content'         => 'required|string',
            'photos'          => 'nullable|array',
            'photos.*'        => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'videos'          => 'nullable|array',
            'videos.*'        => 'file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm,video/ogg,video/x-matroska|max:20480',
            'deleted_media'   => 'nullable|array',
            'deleted_media.*' => 'integer|exists:news_media,id',
        ]);

        // 1. Delete selected media
        if ($request->has('deleted_media')) {
            $mediaToDelete = $newsItem->media()->whereIn('id', $request->deleted_media)->get();
            foreach ($mediaToDelete as $media) {
                if (Storage::disk('public')->exists($media->file_path)) {
                    Storage::disk('public')->delete($media->file_path);
                }
                $media->delete();
            }
        }

        // 2. Validate counts
        $currentPhotoCount = $newsItem->images()->count();
        $newPhotoCount = $request->hasFile('photos') ? count($request->file('photos')) : 0;
        if ($currentPhotoCount + $newPhotoCount > 25) {
            return redirect()->back()->withErrors(['photos' => 'The total number of photos cannot exceed 25.'])->withInput();
        }

        $currentVideoCount = $newsItem->videos()->count();
        $newVideoCount = $request->hasFile('videos') ? count($request->file('videos')) : 0;
        if ($currentVideoCount + $newVideoCount > 3) {
            return redirect()->back()->withErrors(['videos' => 'The total number of videos cannot exceed 3.'])->withInput();
        }

        // 3. Upload new photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('news_images', 'public');
                $newsItem->media()->create([
                    'file_path' => $path,
                    'type'      => 'image',
                ]);
            }
        }

        // 4. Upload new videos
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $path = $video->store('news_videos', 'public');
                $newsItem->media()->create([
                    'file_path' => $path,
                    'type'      => 'video',
                ]);
            }
        }

        // 5. Update legacy columns
        $firstPhoto = $newsItem->images()->first()?->file_path;
        $firstVideo = $newsItem->videos()->first()?->file_path;

        $newsItem->update([
            'title'           => $request->title,
            'category'        => $request->category,
            'target_audience' => $request->audience ?? 'all',
            'content'         => $request->content,
            'is_featured'     => $request->boolean('is_featured'),
            'featured_image'  => $firstPhoto,
            'video_file'      => $firstVideo,
        ]);

        return redirect()->route('staff.news.index')
                         ->with('success', 'Announcement updated successfully!');
    }

    /**
     * Delete an announcement.
     */
    public function destroy($id)
    {
        $newsItem = NewsItem::findOrFail($id);

        foreach ($newsItem->media as $media) {
            if (Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
            $media->delete();
        }

        // Check if legacy featured image/video existed independently
        if ($newsItem->featured_image && Storage::disk('public')->exists($newsItem->featured_image)) {
            Storage::disk('public')->delete($newsItem->featured_image);
        }
        if ($newsItem->video_file && Storage::disk('public')->exists($newsItem->video_file)) {
            Storage::disk('public')->delete($newsItem->video_file);
        }

        $newsItem->delete();

        return redirect()->route('staff.news.index')
                         ->with('success', 'Announcement deleted successfully.');
    }
}
