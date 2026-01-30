<?php

use App\Http\Controllers\Api\FarmController;
use Illuminate\Support\Facades\Route;

Route::post('/farm/{plot}/plant', [FarmController::class, 'plant']);
