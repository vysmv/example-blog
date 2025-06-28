<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::query()->with('category')->paginate(2);
        $trash_cnt = Post::onlyTrashed()->count();
        return view('admin.post.index', ['posts' => $posts, 'trash_cnt' => $trash_cnt]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::query()->pluck('title', 'id');
        return view('admin.post.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'max:255'],
            'meta_desc'   => ['max:255'],
            'content'     => ['required'],
            'category_id' => ['required', 'exists:categories,id'],
            'thumb'       => ['max:255']
        ]);

        Post::query()->create($validated);
        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $post = Post::query()->findOrFail($post->id);
        $categories = Category::query()->pluck('title', 'id')->all();
        return view('admin.post.edit', [
            'categories' => $categories,
            'post' => $post
         ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post = Post::query()->findOrFail($post->id);
        $validated = $request->validate([
            'title'       => ['required', 'max:255'],
            'meta_desc'   => ['max:255'],
            'content'     => ['required'],
            'category_id' => ['required', 'exists:categories,id'],
            'thumb'       => ['max:255']
        ]);

        $post->update($validated);
        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post = Post::query()->findOrFail($post->id);
        $post->delete();
        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post deleted successfully');
    }

    public function trashIndex()
    {
        $posts = Post::onlyTrashed()->with('category')->paginate(2);
        return view('admin.post.trash', ['posts' => $posts]);
    }

    public function trashRestore(string $id) 
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        return redirect()
            ->route('admin.posts.trash')
            ->with('success', 'Post restore successfully');

    }

    public function trashRemove(string $id) 
    {
       $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete();
        return redirect()
            ->route('admin.posts.trash')
            ->with('success', 'Post delete successfully');
    }
}
