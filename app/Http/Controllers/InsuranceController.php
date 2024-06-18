<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    public function index()
    {
        $insurance = Insurance::all();
        return response()->json($insurance, 201);
    }
    public function store(Request $request)
    {
        try {


            $validated = $request->validate([
                'type' => 'required|string|max:255',
                'fee' => 'required|numeric',
            ]);

            $insurance = new Insurance();
            $insurance->type = $validated['type'];
            $insurance->fee = $validated['fee'];

            // Save the branch
            $insurance->save();

            return response()->json($insurance, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
    {

        $insurance = Insurance::findOrFail($id);
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'fee' => 'required|numeric',
        ]);

        $insurance->type = $validated['type'];
        $insurance->fee = $validated['fee'];
        $insurance->save();

        return response()->json($insurance, 201);
    }
    public function delete($id)
    {
        $insurance = Insurance::findOrFail($id);
        $insurance->delete();
        return response()->json(['message' => 'Insuance deleted successfully'], 200);
    }
}
