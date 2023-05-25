<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Singlephon\Nodelink\Login\Authentication;
use Singlephon\Nodelink\Requests\AuthRequest;
use Singlephon\Nodelink\Requests\TokenRequest;
use Singlephon\Nodelink\Service\Intentions\Common;

Route::post('/api/common/produce', fn (Request $request) => Common::produce($request));
Route::post('/api/common/notify', fn (Request $request) => Common::notify($request));
Route::post('/api/common/token', fn (TokenRequest $request) => Authentication::commonTokenRequest($request));
Route::post('/api/login', fn(AuthRequest $request) => Authentication::init($request));
Route::get('/test', fn () => 'sad');
