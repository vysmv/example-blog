<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::query()->paginate(2);
        return view('admin.tag.index', [
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => ['required', 'max:255'],
            'meta_desc' => ['max:255']
        ]);

        Tag::query()->create($validated);
        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag created successfully');
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
        $tag = Tag::query()->findOrFail($id);
        return view('admin.tag.edit', ['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tag = Tag::query()->findOrFail($id);
        $validated = $request->validate([
            'title'     => ['required', 'max:255'],
            'meta_desc' => ['max:255']
        ]);
        $tag->update($validated);
        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = Tag::query()->findOrFail($id);
        $tagName = $tag->title;
        
        if ($tag->posts->count() != 0) {
            return redirect()
            ->route('admin.tags.index')
            ->with('error', 'Tags ' . $tagName . ' has posts');
        }
       
        $tag->delete();
        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag ' . $tagName . ' deleted successfully');
    }
}



