<?php

// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function all()
    {
        $products = Product::select('id', 'name', 'quantity', 'image', 'user_id', 'created_at')->get();
        return response()->json($products);
    }


    public function get($id)
    {
        $product = Product::select('id', 'name', 'quantity', 'image', 'user_id', 'created_at', 'updated_at')
            ->with(['user' => function ($query) {

                $query->select('id', 'name', 'email', 'phone', 'role', 'created_at', 'updated_at');
            }])
            ->findOrFail($id);

        $product->makeHidden('user');

        return response()->json($product);
    }




    public function add(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'quantity' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

// Handle file upload if an image is provided
if ($request->hasFile('image')) {
    $image = $request->file('image');

    $timestamp = now()->timestamp;

    $imageName = $timestamp . '_ product'.'.' . $image->getClientOriginalExtension();
    $imagePath = $image->storeAs('uploads', $imageName, 'public');
    $request->image->move(public_path('images'), $imageName);
    $validatedData['image'] = $imagePath;
}

$userId = Auth::id();

            // Create a new product
            $product = Product::create([
                'name' => $validatedData['name'],
                'quantity' => $validatedData['quantity'],
                'image' => $validatedData['image'] ?? null,
                'user_id' => $userId,
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

        return response()->json(['message' => 'Product deleted successfully.'], 200);
    }


    public function create()
    {
        return view('add-product');
    }
}
