<?php

namespace App\Http\Controllers;

use App\Models\ItemDetail;
use Illuminate\Http\Request;

class ItemDetailController extends Controller
{
    public function index()
    {
        $itemDtail = ItemDetail::all();
        return response()->json($itemDtail, 200);
    }
}
