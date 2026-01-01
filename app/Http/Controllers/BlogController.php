<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('author')->paginate(10);
        $users = User::all();
        return view('blogs.index', compact('blogs', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        $slug = Str::slug($validated['title']);
        $base = $slug;
        $i = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }
        $validated['slug'] = $slug;

        // ensure the blog author is the currently authenticated user
        $validated['user_id'] = auth()->id();

        Blog::create($validated);

        return redirect()->route('blogs.index')->with('success', 'Blog created.');
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        if ($validated['title'] !== $blog->title) {
            $slug = Str::slug($validated['title']);
            $base = $slug;
            $i = 1;
            while (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                $slug = $base.'-'.$i++;
            }
            $validated['slug'] = $slug;
        }

        $blog->update($validated);
        return redirect()->route('blogs.index')->with('success', 'Blog updated.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted.');
    }
}
