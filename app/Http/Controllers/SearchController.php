<?php

namespace App\Http\Controllers;
use App\Models\{Research, Author, Publisher, Category, Type};

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
    {
        $query = $request->input('query');

        // Simple search example
        $results = Research::where('title', 'LIKE', "%{$query}%")->orWhere('slug', 'LIKE', "%{$query}%")->orWhere('description', 'LIKE', "%{$query}%")->orWhere('keywords', 'LIKE', "%{$query}%")->get();

        return view('search', compact('results'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
