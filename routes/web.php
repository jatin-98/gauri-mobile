<?php

use App\Core\Session;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\DatatableController;
use App\Http\controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SettingController;


// ==============================
// Public Routes
// ==============================
Route::get('/login', [AuthController::class, 'loginView']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerView']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', function () {
    Session::destroy();
    redirect('/login');
});

Route::get('/', [HomeController::class, 'index']);

// ==============================
// Admin Routes (Grouped with prefix + middleware)
// ==============================
Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/', [HomeController::class, 'admin']);

    Route::get('/products', fn() => view('admin.products.index'));
    Route::get('/products/add', fn() =>  view('admin.products.add'));
    Route::post('/products/add', [ProductController::class, 'insert']);
    Route::get('/products/edit/{id}', [ProductController::class, 'edit']);
    Route::post('/products/edit/', [ProductController::class, 'update']);

    Route::get('/invoices', fn() => view('admin.invoices.index'));
    Route::get('/invoices/add', fn() => view('admin.invoices.add'));
    Route::post('/invoices/add', [InvoiceController::class, 'insert']);
    Route::get('/invoices/view/{id}', [InvoiceController::class, 'viewInvoice']);
    Route::get('/invoices/edit/{id}', [InvoiceController::class, 'edit']);
    Route::post('/invoices/update', [InvoiceController::class, 'update']);

    Route::get('/sales', fn() => view('admin.sales.index'));
    Route::get('/sales/add', fn() => view('admin.sales.add'));
    Route::post('/sales/add', [SalesController::class, 'insert']);
    Route::get('/sales/edit/{id}', [SalesController::class, 'edit']);
    Route::post('/sales/update', [SalesController::class, 'update']);

    Route::get('/settings', [SettingController::class, 'settings']);
    Route::post('/settings/insert', [SettingController::class, 'insert']);

    Route::get('/create-backup', [BackupController::class, 'createBackup']);
    Route::get('/backups', [BackupController::class, 'index']);
    Route::get('/delete-backup/{filename}', [BackupController::class, 'delete']);

    Route::post('/datatable', [DatatableController::class, 'index']);

    Route::post('/delete-record', [HomeController::class, 'deleteRecord']);

    Route::post('/send-invoice-to-customer', [InvoiceController::class, 'sendEmail']);
});


Route::fallback(function () {
    return view('default.404');
});


// ==============================
// Testing Routes
// ==============================
// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard', function () {
//         return 'Welcome to the secure dashboard!';
//     });
// });


// Route::get('/user/{id}', fn($id) => "User ID: $id");

// Route::get('/users/{name}', function ($name) {
//     return view('welcome', ['name' => ucfirst($name)]);
// });
