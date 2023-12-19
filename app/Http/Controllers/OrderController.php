<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function addOrder(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'products' => 'required|array',
            'total_price' => 'required|numeric',
            'address' => 'required|string',
            'user_name' => 'required|string',
            'user_email' => 'required|email',
            'user_phone' => 'required|string',
            'status' => 'required|string',
        ]);

        $order = Order::create($validatedData);

        return response()->json(['message' => 'Order added successfully', 'data' => $order], 201);
    }




    public function getOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['data' => $order], 200);
    }






    public function deleteOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully'], 200);
    }




    public function updateOrderStatus($id, Request $request)
    {
        $validatedData = $request->validate([
            'status' => 'required|string',
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->update(['status' => $validatedData['status']]);

        return response()->json(['message' => 'Order status updated successfully', 'data' => $order], 200);
    }




    public function getAllOrders()
    {
        $orders = Order::all();

        return response()->json(['data' => $orders], 200);
    }
}
