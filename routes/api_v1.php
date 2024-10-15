<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TicketController;


Route::apiResource('tickets', TicketController::class);
