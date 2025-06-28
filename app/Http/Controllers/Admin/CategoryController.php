<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->paginate(2);
        return view('admin.category.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
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

        Category::query()->create($validated);
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully');
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
        $category = Category::query()->findOrFail($id);
        return view('admin.category.edit', ['category' =>$category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::query()->findOrFail($id);
        $validated = $request->validate([
            'title'     => ['required', 'max:255'],
            'meta_desc' => ['max:255']
        ]);
        $category->update($validated);
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::query()->findOrFail($id);
        $categoryName = $category->title;
        
        if ($category->posts->count() != 0) {
            return redirect()
            ->route('admin.categories.index')
            ->with('error', 'Category ' . $categoryName . ' has posts');
        }
       
        $category->delete();
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category ' . $categoryName . ' deleted successfully');
    }
}



