<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        // Fetch all categories with pagination
        $categories = Category::paginate(10); // Adjust pagination as needed
        return view('pages.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('pages.categories.add');
    }

    public function show(Request $request, Category $category)
    {
        // Récupère les posts associés à la catégorie
        $query = $category->posts();
    
        // Applique une pagination avec 10 posts par page (vous pouvez ajuster ce nombre si nécessaire)
        $posts = $query->paginate(10);
    
        // Retourne la vue avec les données nécessaires
        return view('pages.categories.view', [
            'category' => $category,
            'posts' => $posts
        ]);
    }
    


    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new category
        Category::create($validatedData);

        // Redirect to the categories list with a success message
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(string $id)
    {
        // Fetch the category by its ID
        $category = Category::findOrFail($id);
        return view('pages.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, string $id)
    {
        // Fetch the category by its ID
        $category = Category::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the category with validated data
        $category->update($validatedData);

        // Redirect to the categories list with a success message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(string $id)
    {
        // Fetch the category by its ID
        $category = Category::findOrFail($id);

        // Delete the category
        $category->delete();

        // Redirect to the categories list with a success message
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
