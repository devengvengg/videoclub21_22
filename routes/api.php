<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MovieController;
use App\Http\Resources\MovieResource;
// Uses de Autenticacion Sactum:
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Autenticacion Sanctum
Route::group( ['middleware' => 'auth:sanctum'],function () {
    // Rutas:
    Route::apiResource('peliculas', MovieController::class)
    ->parameters([
        'peliculas' => 'movie'
    ]);
    Route::get('/peliculas/search/{search}', [MovieController::class, 'search']);
});
// Autenticacion Sanctum:
Route::post('/tokens/create', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return response()->json([
        'token_type' => 'Bearer',
        'access_token' => $user->createToken('token_name')->plainTextToken // token name you can choose for your self or leave blank if you like to
    ]);
});
// Proteccion de RUTA:
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
