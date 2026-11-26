<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RevenueStatusController;
use App\Http\Controllers\ExpenseStatusController;
use App\Http\Controllers\TypePieceController;
use App\Http\Controllers\TvaController;
use App\Http\Controllers\ExcelExportController;
use App\Http\Controllers\ModePaiementController;
use App\Http\Controllers\Auth\PasswordResetLinkController;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
});

Route::resource('revenus', RevenueController::class);


Route::resource('expenses', ExpenseController::class);

Route::get('/projets', function () {
    return view('projets.index');
})->name('projets');


Route::get('/rapports', function () {
    return view('rapports.index');
})->name('rapports');


Route::get('/parametres', [ParametreController::class, 'index'])
    ->name('parametres.index');


Route::resource('fournisseurs', FournisseurController::class);


Route::get('/dashboard', [DashboardController::class,'index'])
    ->middleware(['auth','verified'])
    ->name('dashboard');

    



Route::get('/rapports', [RapportController::class, 'index'])
    ->name('rapports.index');

Route::post('/rapports/generer', [RapportController::class, 'generer'])
    ->name('rapports.generer');

Route::get('/rapports/modifier', [RapportController::class, 'modifier'])
    ->name('rapports.modifier');

Route::post('/rapports/pdf', [RapportController::class, 'pdf'])
    ->name('rapports.pdf');

Route::get('/rapports/excel', [ExcelExportController::class, 'export'])
    ->name('rapports.excel');

    
Route::resource('modes-paiement', ModePaiementController::class);

Route::redirect('/', '/login');


Route::resource('users', UserController::class);


Route::resource('labels', LabelController::class);

Route::resource('clients', ClientController::class);

Route::resource('revenue-status', RevenueStatusController::class);

Route::resource('expense-status', ExpenseStatusController::class);

Route::resource('type-pieces', TypePieceController::class);

Route::resource('categories', CategoryController::class);

Route::resource('tva', TvaController::class);
require __DIR__.'/auth.php';