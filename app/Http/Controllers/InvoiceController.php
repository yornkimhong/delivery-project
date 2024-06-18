<?php

namespace App\Http\Controllers;

use App\Models\BranchConfirm;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\ItemDetail;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{


    public function index()
    {
        $invoices = Invoice::with([
            'paymentMethod',
            'insurance',
            'penalty',
            'itemDetail',
            'senderBranch',
            'receiverBranch',
            'branchConfirms',
            'sender',
            'receiver'
        ])->get();

        return response()->json($invoices);
    }

    // public function store(Request $request)
    // {
    //     try {
    //         // Validate request
    //         $validated = $request->validate([
    //             'payment_method' => 'required|exists:payment_method,id',
    //             'insurance_id' => 'required|exists:insurance,id',
    //             'penalty_id' => 'required|exists:penalty,id',
    //             'description' => 'string|max:255',
    //             'quantity' => 'required|integer',
    //             'sender_branch_id' => 'required|exists:branch,id',
    //             'receiver_branch_id' => 'required|exists:branch,id',
    //             'name' => 'required|string|max:255',
    //             'phone' => 'required|string|max:255',
    //             'receiver_name' => 'required|string|max:255',
    //             'receiver_phone' => 'required|string|max:255',
    //             'current_address' => 'required|string|max:255',
    //         ]);


    //         // create custimer 

    //         $customer = new Customer();
    //         $customer->name = $validated['name'];
    //         $customer->name = $validated['phone'];
    //         $customer->name = $validated['receiver_name'];
    //         $customer->name = $validated['receiver_phone'];
    //         $customer->name = $validated['current_address'];
    //         $customer->save();



    //         // Create new item detail
    //         $itemDetail = new ItemDetail();
    //         $itemDetail->description = $validated['description'];
    //         $itemDetail->quantity = $validated['quantity'];
    //         $itemDetail->save();

    //         // Create new invoice associated with item detail
    //         $invoice = new Invoice();
    //         $invoice->payment_method = $validated['payment_method'];
    //         $invoice->insurance_id = $validated['insurance_id'];
    //         $invoice->penalty_id = $validated['penalty_id'];
    //         $invoice->sender_branch_id = $validated['sender_branch_id'];
    //         $invoice->receiver_branch_id = $validated['receiver_branch_id'];
    //         $invoice->sender_id = $customer->id;
    //         $invoice->receiver_id = $customer->id;
    //         // Assign the primary key of item_detail to invoice's foreign key
    //         $invoice->item_detail_id = $itemDetail->id;
    //         $invoice->save();

    //         $invoice->load('itemDetail', 'sender', 'receiver', 'senderBranch', 'receiverBranch');


    //         // Create branch confirm
    //         $branchConfirm = new BranchConfirm();
    //         $branchConfirm->invoice_id = $invoice->id; // Correct field name
    //         $branchConfirm->branch_id = $validated['sender_branch_id'];
    //         $branchConfirm->save(); // Save the branch confirm



    //         return response()->json($invoice, 201);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }
    public function store(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'payment_method' => 'required|exists:payment_method,id',
                'insurance_id' => 'required|exists:insurance,id',
                'penalty_id' => 'required|exists:penalty,id',
                'description' => 'nullable|string|max:255',
                'quantity' => 'required|integer',
                'sender_branch_id' => 'required|exists:branch,id',
                'receiver_branch_id' => 'required|exists:branch,id',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'receiver_name' => 'required|string|max:255',
                'receiver_phone' => 'required|string|max:255',
                'current_address' => 'required|string|max:255',
                'payment_responsibiity' => 'boolean',
                'delivery_cost' => 'required|numeric|min:0',

            ]);

            // Create new item detail
            $itemDetail = new ItemDetail();
            $itemDetail->description = $validated['description'];
            $itemDetail->quantity = $validated['quantity'];
            $itemDetail->save();

            // Create new customer
            $customer = new Customer();
            $customer->name = $validated['name'];
            $customer->phone = $validated['phone'];
            $customer->receiver_name = $validated['receiver_name'];
            $customer->receiver_phone = $validated['receiver_phone'];
            $customer->current_address = $validated['current_address'];
            $customer->save();

            $paymentResponsibility = filter_var($validated['payment_responsibiity'], FILTER_VALIDATE_BOOLEAN);
            // Create new invoice associated with item detail and customer
            $invoice = new Invoice();
            $invoice->payment_method = $validated['payment_method'];
            $invoice->insurance_id = $validated['insurance_id'];
            $invoice->penalty_id = $validated['penalty_id'];
            $invoice->sender_branch_id = $validated['sender_branch_id'];
            $invoice->receiver_branch_id = $validated['receiver_branch_id'];
            $invoice->sender_id = $customer->id; // Assign sender ID
            $invoice->receiver_id = $customer->id; // Assign receiver ID
            $invoice->item_detail_id = $itemDetail->id;
            $invoice->payment_responsibiity =  $paymentResponsibility;
            $invoice->delivery_cost = $validated['delivery_cost'];
            $invoice->save();

            // Create branch confirm
            $branchConfirm = new BranchConfirm();
            $branchConfirm->invoice_id = $invoice->id;
            $branchConfirm->branch_id = $validated['sender_branch_id'];
            $branchConfirm->save();

            $invoice->load('itemDetail', 'sender', 'receiver', 'senderBranch', 'receiverBranch');

            return response()->json($invoice, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            // Validate request
            $validated = $request->validate(['payment_method' => 'required|exists:payment_method,id',
                'insurance_id' => 'required|exists:insurance,id',
                'penalty_id' => 'required|exists:penalty,id',
                'description' => 'nullable|string|max:255',
                'quantity' => 'required|integer',
                'sender_branch_id' => 'required|exists:branch,id',
                'receiver_branch_id' => 'required|exists:branch,id',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'receiver_name' => 'required|string|max:255',
                'receiver_phone' => 'required|string|max:255',
                'current_address' => 'required|string|max:255',
                'payment_responsibiity' => 'boolean',
                'delivery_cost' => 'required|numeric|min:0',
            ]);

            // Find the invoice by ID
            $invoice = Invoice::findOrFail($id);

            // Update item detail associated with the invoice
            $itemDetail = $invoice->itemDetail;
            $itemDetail->description = $validated['description'];
            $itemDetail->quantity = $validated['quantity'];
            $itemDetail->save();

            // Update customer associated with the invoice
            $customer = $invoice->sender; // Assuming sender is the customer in this case
            $customer->name = $validated['name'];
            $customer->phone = $validated['phone'];
            $customer->receiver_name = $validated['receiver_name'];
            $customer->receiver_phone = $validated['receiver_phone'];
            $customer->current_address = $validated['current_address'];
            $customer->save();

            // Update invoice itself
            $invoice->payment_method = $validated['payment_method'];
            $invoice->insurance_id = $validated['insurance_id'];
            $invoice->penalty_id = $validated['penalty_id'];
            $invoice->sender_branch_id = $validated['sender_branch_id'];
            $invoice->receiver_branch_id = $validated['receiver_branch_id'];
            $invoice->payment_responsibiity = $request->input('payment_responsibiity');
            $invoice->delivery_cost = $validated['delivery_cost'];
            $invoice->save();

            // Load relationships for the response
            $invoice->load('itemDetail', 'sender', 'receiver', 'senderBranch', 'receiverBranch');

            return response()->json($invoice, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            // Find the invoice by ID
            $invoice = Invoice::findOrFail($id);

            // Delete the invoice
            $invoice->delete();

            return response()->json(['message' => 'Invoice deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
