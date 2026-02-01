<?php

use App\Http\Controllers\Api\AlchemyExperimentController;
use App\Http\Controllers\Api\FarmController;
use Illuminate\Support\Facades\Route;

/** FARM */
Route::post('/farm/{plot}/plant', [FarmController::class, 'plant']);

/** ALCHEMY */
Route::post('/alchemy/experiments', [AlchemyExperimentController::class, 'store']);
