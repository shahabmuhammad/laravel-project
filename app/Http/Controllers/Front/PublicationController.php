<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Research;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PublicationController extends Controller
{
    public function show(Research $research)
    {
        // Load related models
        $research->load('user', 'publisher', 'type');

        // Increment views
        $research->increment('views');

        // Track view in session for authenticated users
        if (auth()->check()) {
            $views = session()->get('viewed_papers', []);
            if (!isset($views[$research->id])) {
                $views[$research->id] = ['count' => 0, 'last_viewed' => null];
            }
            $views[$research->id]['count']++;
            $views[$research->id]['last_viewed'] = now()->toDateTimeString();
            session()->put('viewed_papers', $views);
        }

        return view('front.publication', compact('research'));
    }

    public function category(Category $category)
    {
        $researches = Research::where('status', 'published')
            ->whereJsonContains('category_ids', $category->id)
            ->with('user')
            ->latest()
            ->paginate(12);

        return view('front.publications', compact('researches', 'category'));
    }

    public function download(Request $request, Research $research)
    {
        $media = $research->getFirstMedia('research_files');

        if (!($media instanceof Media)) {
            return back()->with('error', 'No file available for download.');
        }

        $research->increment('downloads');

        // Track download in session for authenticated users
        if (auth()->check()) {
            $downloads = session()->get('downloaded_papers', []);
            if (!isset($downloads[$research->id])) {
                $downloads[$research->id] = ['count' => 0, 'last_downloaded' => null];
            }
            $downloads[$research->id]['count']++;
            $downloads[$research->id]['last_downloaded'] = now()->toDateTimeString();
            session()->put('downloaded_papers', $downloads);
        }

        $localPath = $media->getPath();
        if (!empty($localPath) && file_exists($localPath)) {
            return response()->download($localPath, $media->file_name ?: basename($localPath));
        }

        $disk = $media->disk;
        $relative = $media->getPathRelativeToRoot();

        if ($relative && Storage::disk($disk)->exists($relative)) {
            return Storage::disk($disk)->download($relative, $media->file_name ?: basename($relative));
        }

        return redirect($media->getFullUrl());
    }
}
