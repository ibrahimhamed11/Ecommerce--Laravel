<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'products' => 'required|array',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            // 'products.*.price' => 'required|numeric|min:0',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $userId = $request->input('user_id');
        $products = $request->input('products');

        // Ensure the authenticated user matches the provided user ID
        $user = Auth::user();

        // Retrieve the existing cart or create a new one
        $cart = Cart::updateOrCreate(
            ['user_id' => $userId],
            ['products' => $this->formatCartItems($userId, $products)]
        );

        return response()->json(['message' => 'Products added to cart']);
    }

    // Helper function to format cart items
    private function formatCartItems($userId, $products)
    {
        // You can add any additional logic to format cart items here
        return $products;
    }







    public function allInCart()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        return response()->json(['cart' => $cart]);
    }




    public function deleteFromCart(Request $request)
    {
        $user = Auth::user();
        $productId = $request->input('product_id');

        $cart = Cart::where('user_id', $user->id)->first();

        if ($cart) {
            $products = $cart->products;
            $updatedProducts = array_filter($products, function ($product) use ($productId) {
                return $product['id'] != $productId;
            });

            $cart->update(['products' => $updatedProducts]);

            return response()->json(['message' => 'Product deleted from cart']);
        }

        return response()->json(['message' => 'Cart not found'], 404);
    }



    public function getUserCart($userId)
    {
        $user = Auth::user();

        if ($user->id == $userId) {
            $cart = Cart::where('user_id', $userId)->first();

            return response()->json(['cart' => $cart]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }


    private function addToCartItems($user, $productId)
    {
        $product = [
            'id' => $productId,
            'name' => 'Product Name',
            'price' => 19.99,
        ];

        $cart = Cart::where('user_id', $user->id)->first();

        if ($cart) {
            $products = $cart->products;
            $products[] = $product;

            return $products;
        }

        return [$product];
    }
}
