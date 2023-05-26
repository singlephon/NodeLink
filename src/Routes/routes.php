<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Singlephon\Nodelink\Login\Authentication;
use Singlephon\Nodelink\NodelinkRegister;
use Singlephon\Nodelink\Requests\AuthRequest;
use Singlephon\Nodelink\Requests\TokenRequest;
use Singlephon\Nodelink\Service\Intentions\Common;

Route::post('/nodelink/produce', fn (Request $request) => Common::produce($request));
Route::post('/nodelink/notify', fn (Request $request) => Common::notify($request));
Route::post('/nodelink/token', fn (TokenRequest $request) => Authentication::commonTokenRequest($request));
Route::post('/nodelink/register', fn (Request $request) => NodelinkRegister::init($request));

Route::post('/login', fn(AuthRequest $request) => Authentication::init($request));
Route::get('/test', fn () => 'sad');
