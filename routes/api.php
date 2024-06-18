<?php

use App\Http\Controllers\BranchConfirmController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemDetailController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// route for users table

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'delete']);

// route for branch table
Route::get('/branchs', [BranchController::class, 'index']);
Route::post('/branchs', [BranchController::class, 'store']);
Route::put('/branchs/{branch}', [BranchController::class, 'update']);
Route::delete('/branchs/{branch}', [BranchController::class, 'delete']);

// route for paymentMethod table
Route::get('/paymentMethods', [PaymentMethodController::class, 'index']);
Route::post('/paymentMethods', [PaymentMethodController::class, 'store']);
Route::put('/paymentMethods/{paymentMethod}', [PaymentMethodController::class, 'update']);
Route::delete('/paymentMethods/{paymentMethod}', [PaymentMethodController::class, 'delete']);

// route for insurance table
Route::get('/insurances', [InsuranceController::class, 'index']);
Route::post('/insurances', [InsuranceController::class, 'store']);
Route::put('/insurances/{insurance}', [InsuranceController::class, 'update']);
Route::delete('/insurances/{insurance}', [InsuranceController::class, 'delete']);


// route for penaltys table
Route::get('/penaltys', [PenaltyController::class, 'index']);
Route::post('/penaltys', [PenaltyController::class, 'store']);
Route::put('/penaltys/{penalty}', [PenaltyController::class, 'update']);
Route::delete('/penaltys/{penalty}', [PenaltyController::class, 'delete']);

// Route for invoice page
Route::get('/invoices', [InvoiceController::class, 'index']);
Route::post('/invoices', [InvoiceController::class, 'store']);
Route::put('/invoices/{invoice}', [InvoiceController::class, 'update']);
Route::delete('/invoices/{invoice}', [InvoiceController::class, 'delete']);

// Route get customer and ItemDetail 
Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/item-details', [ItemDetailController::class, 'index']);
Route::get('/branch-confirms', [BranchConfirmController::class, 'index']);
Route::put('/branch-confirms/{id}', [BranchConfirmController::class, 'updateStatus']);

// route to get DashBoard
Route::get('/dashboards', [DashboardController::class, 'dashboard']);
