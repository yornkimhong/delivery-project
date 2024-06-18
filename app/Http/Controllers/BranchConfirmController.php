<?php

namespace App\Http\Controllers;

use App\Models\BranchConfirm;
use Illuminate\Http\Request;

class BranchConfirmController extends Controller
{
    public function index()
    {
        $branchConfirms = BranchConfirm::all();
        return response()->json($branchConfirms);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $confirm = BranchConfirm::findOrFail($id);
            $confirm->confirm_status = $request->input('confirm_status');
            $confirm->save();

            return response()->json($confirm, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
