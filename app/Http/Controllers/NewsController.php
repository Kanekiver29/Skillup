<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    protected function fallbackNews(): Collection
    {
        return collect([
            [
                'id' => 1,
                'title' => 'Career Track enrollment is now open',
                'category' => 'announcement',
                'content' => 'Applications for the next cohort are now open.',
                'is_featured' => true,
                'published_at' => now()->subDay(),
            ],
            [
                'id' => 2,
                'title' => 'Mentor application intake is now open',
                'category' => 'announcement',
                'content' => 'We are accepting mentor applications for the next cycle.',
                'is_featured' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'id' => 3,
                'title' => 'SkillUp Job Readiness Day',
                'category' => 'event',
                'content' => 'Join our community career bootcamp event.',
                'is_featured' => false,
                'published_at' => now()->subDays(3),
            ],
        ])->map(fn ($item) => (object) $item);
    }

    public function index()
    {
        $featured = NewsItem::published()->where('is_featured', true)->latest('published_at')->take(3)->get();
        if ($featured->isEmpty()) {
            $featured = $this->fallbackNews()->filter(fn ($item) => (bool) ($item->is_featured ?? false));
        }

        $news = NewsItem::published()->latest('published_at')->take(9)->get();
        if ($news->isEmpty()) {
            $news = $this->fallbackNews();
        }

        return view('Userpage.news.news', compact('featured', 'news'));
    }

    public function adminIndex()
    {
        $news = NewsItem::published()->latest('published_at')->get();

        if ($news->isEmpty()) {
            $news = $this->fallbackNews();
        }

        return view('Admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function adminCreate()
    {
        return view('Admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:5120',
            'video_file' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:20480',
            'published_at' => 'nullable|date',
        ]);

        $featuredImagePath = $request->hasFile('featured_image')
            ? $this->storeUploadedImage($request->file('featured_image'))
            : null;

        $videoFilePath = $request->hasFile('video_file')
            ? $this->storeUploadedVideo($request->file('video_file'))
            : null;

        NewsItem::create([
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
            'featured_image' => $featuredImagePath,
            'video_file' => $videoFilePath,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->published_at ?? now(),
        ]);

        return redirect()->route('news')->with('success', 'News item created successfully.');
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:5120',
            'video_file' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:20480',
            'published_at' => 'nullable|date',
        ]);

        $featuredImagePath = $request->hasFile('featured_image')
            ? $this->storeUploadedImage($request->file('featured_image'))
            : null;

        $videoFilePath = $request->hasFile('video_file')
            ? $this->storeUploadedVideo($request->file('video_file'))
            : null;

        NewsItem::create([
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
            'featured_image' => $featuredImagePath,
            'video_file' => $videoFilePath,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->published_at ?? now(),
        ]);

        return redirect()->route('admin.news.index')->with('success', 'News item created successfully.');
    }

    public function show(string $id)
    {
        $newsItem = NewsItem::published()->findOrFail($id);

        // Increment view count on each visit
        $newsItem->increment('view_count');

        // Related posts — same category, excluding current, latest 3
        $related = NewsItem::published()
            ->where('id', '!=', $newsItem->id)
            ->where('category', $newsItem->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('Userpage.news.show', compact('newsItem', 'related'));
    }

    public function adminShow(string $id)
    {
        $item = NewsItem::findOrFail($id);

        return view('Admin.news.view', compact('item'));
    }

    public function edit(string $id)
    {
        $newsItem = NewsItem::findOrFail($id);

        return view('news.edit', compact('newsItem'));
    }

    public function adminEdit(string $id)
    {
        $item = NewsItem::findOrFail($id);

        return view('Admin.news.edit', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:5120',
            'video_file' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:20480',
            'published_at' => 'nullable|date',
        ]);

        $newsItem = NewsItem::findOrFail($id);

        $featuredImagePath = $newsItem->featured_image;
        if ($request->hasFile('featured_image')) {
            if ($featuredImagePath && Storage::disk('public')->exists($featuredImagePath)) {
                Storage::disk('public')->delete($featuredImagePath);
            }
            $featuredImagePath = $this->storeUploadedImage($request->file('featured_image'));
        }

        $videoFilePath = $newsItem->video_file;
        if ($request->hasFile('video_file')) {
            if ($videoFilePath && Storage::disk('public')->exists($videoFilePath)) {
                Storage::disk('public')->delete($videoFilePath);
            }
            $videoFilePath = $this->storeUploadedVideo($request->file('video_file'));
        }

        $newsItem->update([
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
            'featured_image' => $featuredImagePath,
            'video_file' => $videoFilePath,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->published_at ?? $newsItem->published_at ?? now(),
        ]);

        return redirect()->route('news')->with('success', 'News item updated successfully.');
    }

    public function adminUpdate(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:5120',
            'video_file' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:20480',
            'published_at' => 'nullable|date',
        ]);

        $newsItem = NewsItem::findOrFail($id);

        $featuredImagePath = $newsItem->featured_image;
        if ($request->hasFile('featured_image')) {
            if ($featuredImagePath && Storage::disk('public')->exists($featuredImagePath)) {
                Storage::disk('public')->delete($featuredImagePath);
            }
            $featuredImagePath = $this->storeUploadedImage($request->file('featured_image'));
        }

        $videoFilePath = $newsItem->video_file;
        if ($request->hasFile('video_file')) {
            if ($videoFilePath && Storage::disk('public')->exists($videoFilePath)) {
                Storage::disk('public')->delete($videoFilePath);
            }
            $videoFilePath = $this->storeUploadedVideo($request->file('video_file'));
        }

        $newsItem->update([
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
            'featured_image' => $featuredImagePath,
            'video_file' => $videoFilePath,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->published_at ?? $newsItem->published_at ?? now(),
        ]);

        return redirect()->route('admin.news.index')->with('success', 'News item updated successfully.');
    }

    public function destroy(string $id)
    {
        $newsItem = NewsItem::findOrFail($id);
        $newsItem->delete();

        return redirect()->route('news')->with('success', 'News item deleted successfully.');
    }

    public function adminDestroy(string $id)
    {
        $newsItem = NewsItem::findOrFail($id);
        $newsItem->delete();

        return redirect()->route('admin.news.index')->with('success', 'News item deleted successfully.');
    }

    protected function storeUploadedImage($file)
    {
        return $file->store('news_images', 'public');
    }

    protected function storeUploadedVideo($file)
    {
        return $file->store('news_videos', 'public');
    }

    public function react(Request $request, string $id)
    {
        $request->validate([
            'type' => 'required|in:like,heart,care,sad',
        ]);

        $newsItem = NewsItem::findOrFail($id);
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $existingReaction = $newsItem->reactions()->where('user_id', $user->id)->first();

        if ($existingReaction) {
            if ($existingReaction->type === $request->type) {
                // Toggle off
                $existingReaction->delete();
                $action = 'removed';
            } else {
                // Change reaction
                $existingReaction->update(['type' => $request->type]);
                $action = 'updated';
            }
        } else {
            // New reaction
            $newsItem->reactions()->create([
                'user_id' => $user->id,
                'type' => $request->type,
            ]);
            $action = 'added';
        }

        // Return updated counts
        $counts = $newsItem->reactions()
            ->select('type', \DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type')
            ->toArray();

        return response()->json([
            'action' => $action,
            'counts' => array_merge(['like' => 0, 'heart' => 0, 'care' => 0, 'sad' => 0], $counts)
        ]);
    }

    public function storeComment(Request $request, string $id)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $newsItem = NewsItem::findOrFail($id);
        $user = $request->user();

        if (!$user) {
            return redirect()->back()->with('error', 'You must be logged in to comment.');
        }

        $newsItem->comments()->create([
            'user_id' => $user->id,
            'body' => $request->body,
        ]);

        return redirect()->back()->with('success', 'Comment posted successfully.');
    }
}
