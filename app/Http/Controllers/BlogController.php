<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    // List public blogs
    public function index()
    {
        $blogs = Blog::latest()->get();

        return Inertia::render('Blogs', ['blogs' => $blogs]);
    }

    // List blogs for admin
    public function adminIndex()
    {
        $blogs = Blog::latest()->get();
        return Inertia::render('Admin/Blogs', ['blogs' => $blogs]);
        // return response()->json(['blogs' => $blogs]);
    }
    public function fetchall()
    {
        $blogs = Blog::latest()->get();

    return response()->json(['blogs' => $blogs]);
}


public function store(Request $request)
{
    // Validate the request data
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'published_at' => 'nullable|date',
        'user_id' => 'required|exists:users,id',
        'status' => 'boolean',
    ]);

    try {
        // Create the blog post
        $blog = Blog::create($validated);

        // Return the created blog and a success message
        return response()->json([
            'message' => 'Blog created successfully!',
            'blog' => $blog, // Return the created blog
        ], 201);

    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error creating blog: ' . $e->getMessage());

        // Return a generic error message
        return response()->json([
            'error' => 'An error occurred while creating the blog.',
        ], 500);
    }
}
    // Update blog
    public function update(Request $request, Blog $blog)
    {
        $this->authorize('update', $blog);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'published_at' => 'nullable|date',
            'status' => 'boolean',
        ]);

        $blog->update($validated);

        return redirect()->route('admin.blogs')->with('success', 'Blog updated successfully!');
    }

    // Delete blog
    public function destroy($blogId)
    {
        try {
            $blog = Blog::findOrFail($blogId);
            $blog->delete();

        return response()->json(['message' => 'Blog Deleted successfully!'], 201);
    } catch (\Exception $e) {
        // Return error with the message
        return response()->json(['error' => 'Blog cannot be Deleted!'], 500);
    }
    }

    public function search(Request $request)
{
    // Get the search query from the request
    $query = $request->input('query');

    // Search blogs by title or content
    $blogs = Blog::where('title', 'like', "%{$query}%")
                 ->orWhere('content', 'like', "%{$query}%")
                 ->latest()
                 ->get();

    // Return the filtered blogs
    return response()->json(['filteredBlogs' => $blogs]);
}
}
