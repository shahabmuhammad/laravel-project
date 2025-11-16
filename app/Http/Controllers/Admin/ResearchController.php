<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Research, Publisher, Category, Type};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class ResearchController extends Controller
{
    
    //   Display a listing of the researches.
     
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Research::with(['publisher', 'type'])->latest();

        if ($user->hasRole('User')) {
            $query->where('status', 'published');
        } elseif (!$user->hasRole('Admin')) {
            $query->where('user_id', $user->id);
        }

        // Search filter (title / category)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");

                // Match category name (JSON search)
                $categoryIds = Category::where('name', 'like', "%$search%")->pluck('id')->toArray();
                if (!empty($categoryIds)) {
                    foreach ($categoryIds as $catId) {
                        $q->orWhereJsonContains('category_ids', $catId);
                    }
                }
            });
        }

        if ($request->filled('category')) {
            $query->whereJsonContains('category_ids', (int) $request->category);
        }

        $researches = $query->paginate(10);
        $categories = Category::all();

        return view('admin.researches.index', compact('researches', 'categories', 'user'));
    }

    //  Show the form for creating a new research entry.
     
    public function create()
    {
        $publishers = Publisher::all();
        $categories = Category::all();
        $types = Type::all();

        return view('admin.researches.create', compact('publishers', 'categories', 'types'));
    }

    /**
     * Handle file upload (AJAX).
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $path = $request->file('file')->store('temp_uploads', 'public');

        return response()->json(['file_path' => $path]);
    }

    /**
     * Store a newly created research.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'keywords'     => 'nullable|string|max:255',
            'publisher_id' => 'nullable|exists:publishers,id',
            'type_id'      => 'nullable|exists:types,id',
            'category_id'  => 'nullable|array',
            'category_id.*'=> 'exists:categories,id',
            'file_path'    => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'status'       => 'required|in:draft,submitted,published,rejected',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['category_ids'] = $request->category_id ?? [];

        $research = Research::create($validated);

        if ($request->hasFile('uploaded_file')) {
            $research->addMediaFromRequest('uploaded_file')->toMediaCollection('research_files');
        }

        return redirect()
            ->route('admin.researches.index')
            ->with('success', 'Research created successfully.');
    }

    /**
     * Display a specific research.
     */
    public function show($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
    
        $research = Research::with(['user', 'publisher', 'type'])->findOrFail($id);
    
        $categories = $research->category_names;
    
        return view('admin.researches.show', compact('research', 'categories'));
    }
    
    
    //  Show the form for editing a research.
     
    public function edit($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $research = Research::findOrFail($id);
    
        $publishers = Publisher::all();
        $categories = Category::all();
        $types = Type::all();
    
        return view('admin.researches.edit', compact('research', 'publishers', 'categories', 'types'));
    }
    
    
    //  Update a specific research.
     
    public function update(Request $request, $encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $research = Research::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'keywords'     => 'nullable|string|max:255',
            'publisher_id' => 'nullable|exists:publishers,id',
            'type_id'      => 'nullable|exists:types,id',
            'category_id'  => 'nullable|array',
            'category_id.*'=> 'exists:categories,id',
            'file_path'    => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'status'       => 'required|in:draft,submitted,published,rejected',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['category_ids'] = $request->category_id ?? [];

        // Non-admins can only submit, not publish
        if (!Auth::user()->hasRole('Admin')) {
            $validated['status'] = 'submitted';
        }

        $research->update($validated);

        if ($request->hasFile('uploaded_file')) {
            $research->addMediaFromRequest('uploaded_file')->toMediaCollection('research_files');
        }

        return redirect()
            ->route('admin.researches.index')
            ->with('success', 'Research updated successfully.');
    }

    
    //  Download a research file.
     
    public function download($id)
    {
        $research = Research::findOrFail($id);
        $research->increment('downloads');

        $path = storage_path('app/public/' . $research->file_path);

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        return response()->download($path, basename($research->file_path));
    }

    
    //  Delete a research entry.
     
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $research = Research::findOrFail($id);

        if ($research->file_path) {
            Storage::disk('public')->delete($research->file_path);
        }

        $research->delete();

        return redirect()
            ->route('admin.researches.index')
            ->with('success', 'Research deleted successfully.');
    }

    
    //  Approve a research (publish).
     
    public function approve($id)
    {
        $research = Research::findOrFail($id);
        $research->update(['status' => 'published']);

        return redirect()->back()->with('success', 'Research approved successfully.');
    }

    
    // Reject a research.
     
    public function reject($id)
    {
        $research = Research::findOrFail($id);
        $research->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Research rejected successfully.');
    }
}
