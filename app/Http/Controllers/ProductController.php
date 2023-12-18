<?php

// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        // Retrieve all products with associated user information
        $products = Product::with('user')->get();
        return response()->json($products);
    }


    public function show($id)
    {
        // Retrieve a specific product with associated user information
        $product = Product::with('user')->findOrFail($id);
        return response()->json($product);
    }
    public function store(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'name' => 'required|string',
                'quantity' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Handle file upload if an image is provided
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Save the image in the 'images' folder within the 'public' disk
                $imagePath = $image->store('images', 'public');

                // Update the image path in the validated data
                $validatedData['image'] = $imagePath;
            }

            // Create a new product
            $product = Product::create([
                'name' => $validatedData['name'],
                'quantity' => $validatedData['quantity'],
                'image' => $validatedData['image'] ?? null,
                'user_id' => 1,
            ]);

            return response()->json($product, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }
    }








    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => ['required', 'exists:users,id', Rule::unique('products')->ignore($id)],
        ]);

        $product = Product::findOrFail($id);

        // Handle file upload for the update
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        }

        $product->update($validatedData);

        return response()->json($product, 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(null, 204);
    }






    // app/Http/Controllers/ProductController.php

public function create()
{
    return view('add-product');
}



}