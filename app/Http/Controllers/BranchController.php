<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Dotenv\Validator;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branch = Branch::all();
        return response()->json($branch, 201);
    }
    public function store(Request $request)
    {


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'alt_phone' => 'nullable|string|max:20',
            'location' => 'required|string|max:255',
        ]);

        $branch = new Branch();
        $branch->name = $validated['name'];
        $branch->phone = $validated['phone'];
        $branch->alt_phone = $validated['alt_phone'];
        $branch->location = $validated['location'];

        // Save the branch
        $branch->save();

        return response()->json($branch, 201);
    }
    public function update(Request $request, $id)
    {

        $branch = Branch::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'alt_phone' => 'nullable|string|max:20',
            'location' => 'required|string|max:255',
        ]);

        $branch->name = $validated['name'];
        $branch->phone = $validated['phone'];
        $branch->alt_phone = $validated['alt_phone'];
        $branch->location = $validated['location'];

        // Save the branch
        $branch->save();

        return response()->json($branch, 201);
    }
    public function delete($id)
    {
        $user = Branch::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
