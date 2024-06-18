<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethod = PaymentMethod::all();
        return response()->json($paymentMethod, 201);
    }
    public function store(Request $request)
    {


        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $paymentMethod = new PaymentMethod();
        $paymentMethod->name = $validated['name'];

        // Save the branch
        $paymentMethod->save();

        return response()->json($paymentMethod, 201);
    }
    public function update(Request $request, $id)
    {

        $paymentMethod = PaymentMethod::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $paymentMethod->name = $validated['name'];
        // Save the paymentMethod
        $paymentMethod->save();

        return response()->json($paymentMethod, 201);
    }
    public function delete($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->delete();
        return response()->json(['message' => 'Payment Method deleted successfully'], 200);
    }
}
