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

        // Handle file download request
        if (request()->query('download')) {
            $media = $research->getFirstMedia('research_files');
            if ($media instanceof Media) {
                $research->increment('downloads');
                $research->increment('views');

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

            return back()->with('error', 'No file available for download.');
        }

        // Increment views
        $research->increment('views');

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
