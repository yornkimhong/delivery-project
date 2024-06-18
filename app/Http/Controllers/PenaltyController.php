<?php

namespace App\Http\Controllers;

use App\Models\Penalty;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    public function index()
    {
        $penalty = Penalty::all();
        return response()->json($penalty, 201);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        $penalty = new Penalty();
        $penalty->name = $validated['name'];
        $penalty->description = $validated['description'];
        $penalty->save();
        return response()->json($penalty, 201);
        //  catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 500);
        // }
    }
    public function update(Request $request, $id)
    {

        $penalty = Penalty::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $penalty->name = $validated['name'];
        $penalty->description = $validated['description'];
        $penalty->save();

        return response()->json($penalty, 201);
    }
    public function delete($id)
    {
        $penalty = Penalty::findOrFail($id);
        $penalty->delete();
        return response()->json(['message' => 'Penalty deleted successfully'], 200);
    }
}
