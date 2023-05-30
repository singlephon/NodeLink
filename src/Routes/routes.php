<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Singlephon\Nodelink\Login\Authentication;
use Singlephon\Nodelink\NodelinkRegister;
use Singlephon\Nodelink\Requests\AuthRequest;
use Singlephon\Nodelink\Requests\TokenRequest;
use Singlephon\Nodelink\Service\Intentions\Common;
use Singlephon\Nodelink\Service\Performance\Ping;


Route::prefix('/nodelink')->group(function () {
    Route::post('/produce', fn (Request $request) => Common::produce($request));
    Route::post('/notify', fn (Request $request) => Common::notify($request));
    Route::post('/token', fn (TokenRequest $request) => Authentication::commonTokenRequest($request));
    Route::post('/register', fn (Request $request) => (new NodelinkRegister)->init($request));

    Route::prefix('/ping')->group(function () {
        Route::get('/pong', fn () => response()->json((new Ping)->pong()));
        Route::get('/primary', fn () => response()->json((new Ping)->primary()));
        Route::get('/complex', fn () => response()->json((new Ping)->complex()));
    });
});


Route::post('/login', fn(AuthRequest $request) => Authentication::init($request));
