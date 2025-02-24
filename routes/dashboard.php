<?php

use App\Http\Controllers\Dashboard\CategoryController;
use Illuminate\Support\Facades\Route;

Route::resource('dashboard/categories',CategoryController::class);

Route::get('dashboard/categories/trash',[CategoryController::class, 'trash'])->name('categories.trash');
Route::put('dashboard/categories/{category}/restore',[CategoryController::class, 'restore'])->name('categories.restore');
Route::delete('dashboard/categories/{category}/force-delete',[CategoryController::class, 'forceDelete'])->name('categories.fprce-delete');
    