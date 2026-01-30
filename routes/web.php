<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MaterialRequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TemplateController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ReportController::class, 'dashboard'])->name('dashboard');
    
    // Items Management
    Route::resource('items', ItemController::class);
    
    // Material Requests
    Route::resource('requests', MaterialRequestController::class)->except(['edit', 'update'])->parameter('requests', 'materialRequest');
    Route::post('/requests/{materialRequest}/checkout', [MaterialRequestController::class, 'checkout'])->name('requests.checkout');
    Route::get('/requests/{materialRequest}/checkin', [MaterialRequestController::class, 'checkinForm'])->name('requests.checkin.form');
    Route::post('/requests/{materialRequest}/checkin', [MaterialRequestController::class, 'checkin'])->name('requests.checkin');
    
    // Templates
    Route::resource('templates', TemplateController::class);
    Route::get('/api/templates/{template}/items', [MaterialRequestController::class, 'getTemplateItems'])->name('api.template.items');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::name('reports.')->group(function () {
        Route::get('/loss-damage', [ReportController::class, 'lossAndDamage'])->name('loss-damage');
        Route::get('/pdf/unified', [ReportController::class, 'exportUnifiedPdf'])->name('pdf.unified');
         
        Route::get('/stock-movement', [ReportController::class, 'stockMovement'])->name('stock-movement');
        Route::get('/stock-movement/pdf', [ReportController::class, 'exportStockMovementPdf'])->name('stock-movement.pdf');
        
        Route::get('/tool-utilization', [ReportController::class, 'toolUtilization'])->name('tool-utilization');
    });
});

