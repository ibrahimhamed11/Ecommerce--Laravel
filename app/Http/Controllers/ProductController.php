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
        $products = Product::select('id', 'name', 'quantity', 'image', 'user_id', 'created_at')->get();
        return response()->json($products);
    }


    public function show($id)
    {
        $product = Product::select('id', 'name', 'quantity', 'image', 'user_id', 'created_at', 'updated_at')
            ->with(['user' => function ($query) {

                $query->select('id', 'name', 'email', 'phone', 'role', 'created_at', 'updated_at');
            }])
            ->findOrFail($id);

        $product->makeHidden('user');

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

    // Get the current timestamp as a unique identifier
    $timestamp = now()->timestamp;

    // Combine the timestamp and the original file extension to create a unique image name
    $imageName = $timestamp . '_ product'.'.' . $image->getClientOriginalExtension();

    // Save the image in the 'images' folder within the 'public' disk with the unique name
    $imagePath = $image->storeAs('uploads', $imageName, 'public');

    $request->image->move(public_path('images'), $imageName);

    // Update the image path in the validated data
    $validatedData['image'] = $imagePath;
}


            // Create a new product
            $product = Product::create([
                'name' => $validatedData['name'],
                'quantity' => $validatedData['quantity'],
                'image' => $validatedData['image'] ?? null,
                'user_id' => 3,
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Check if the authenticated user owns the product
        if (Auth::id() !== $product->user_id) {
            return response()->json(['error' => 'You do not have permission to update this product.'], 403);
        }

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



    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // Check if the authenticated user owns the product
        if (Auth::id() !== $product->user_id) {
            return response()->json(['error' => 'You do not have permission to delete this product.'], 403);
        }

        $product->delete();

        return response()->json(null, 204);
    }

    public function create()
    {
        return view('add-product');
    }
}