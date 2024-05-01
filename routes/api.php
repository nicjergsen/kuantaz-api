<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KuantazController;

Route::get('/beneficios-por-anio', [KuantazController::class, 'getBenefitsPerYear']);