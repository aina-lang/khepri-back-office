<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all posts with pagination
        $posts = Post::paginate(10); // Adjust pagination as needed
        return view('pages.posts.index', compact('posts')); // Ensure you have a view named 'posts.index'
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch categories for the select dropdown
        $categories = Category::all();

        // Return the view for creating a post
        return view('pages.posts.add', compact('categories')); // Ensure you have a view named 'posts.create'
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
            ]);

            // Handle file upload
            if ($request->hasFile('cover_photo')) {
                $file = $request->file('cover_photo');
                $filePath = $file->store('cover_photos', 'public');
                $validatedData['cover_photo'] = $filePath;
            }

            // Create a new post
            Post::create($validatedData);

            // Redirect to the posts list with a success message
            return redirect()->route('posts.index')->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            // Log the error message
            echo ('Failed to create post: ' . $e->getMessage());
            
            // Redirect back to the form with an error message
            return redirect()->back()->with('error', 'Failed to create post. Please try again.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the post by its ID
        $post = Post::findOrFail($id);

        // var_dump($post);return;
        // Return the view with the post data
        return view('pages.posts.show', compact('post')); // Ensure you have a view named 'posts.show'
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch the post by its ID
        $post = Post::findOrFail($id);

        // Fetch categories for the select dropdown
        $categories = Category::all();

        // Return the view for editing the post
        return view('pages.posts.edit', compact('post', 'categories')); // Ensure you have a view named 'posts.edit'
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

        $data = $request->only('title', 'description', 'category_id');

        // Gestion de la photo de couverture
        if ($request->hasFile('cover_photo')) {
            // Supprimer l'ancienne photo de couverture si elle existe
            if ($post->cover_photo) {
                Storage::disk('public')->delete($post->cover_photo);
            }

            // Stocker la nouvelle photo de couverture
            $data['cover_photo'] = $request->file('cover_photo')->store('cover_photos', 'public');
        }

        // Mettre à jour le post avec les nouvelles données
        $post->update($data);

        return redirect()->route('posts.edit', $post)->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        // Fetch the post by its ID
        $post = Post::findOrFail($id);

        // Delete the cover photo if it exists
        if ($post->cover_photo) {
            // Construct the path to the file
            $filePath = 'public/' . $post->cover_photo;

            // Check if the file exists before attempting to delete it
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }

        // Delete the post
        $post->delete();

        // Redirect to the posts list with a success message
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }


    public function updateArchive(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->archived = $request->input('archived');
        $post->save();

        return response()->json(['success' => true]);
    }

    public function archive()
    {
        // Récupérer les posts archivés
        $archivedPosts = Post::where('archived', 1)->paginate(10);

        // Retourner la vue avec les posts archivés
        return view('pages.posts.archive', compact('archivedPosts'));
    }

    public function activePosts()
    {
        $posts = Post::where('archived', 0)
            ->with('category')
            ->get();

        return response()->json($posts, 200);
    }

    public function showFromFront(string $id)
    {
        // Fetch the post with its category
        $post = Post::with('category')->findOrFail($id);

        // Return the post data as a JSON response
        return response()->json($post, 200);
    }
}
