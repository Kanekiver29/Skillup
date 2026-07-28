<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Profile endpoints (authenticated via session)
Route::post('/profile/update', [ProfileController::class, 'updateCareerProfile'])->middleware('auth')->name('profile.update');
Route::get('/profile/career', [ProfileController::class, 'getCareerProfile'])->middleware('auth')->name('profile.get');

