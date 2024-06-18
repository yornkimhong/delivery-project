<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        try {
            $invoices = Invoice::count();
            $users = User::count();
            $customers = Customer::count();
            $branchs = Branch::count();

            $data = [
                'invoices_count' => $invoices,
                'users_count' => $users,
                'customers_count' => $customers,
                'branchs_count' => $branchs,
            ];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
