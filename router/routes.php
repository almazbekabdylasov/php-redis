<?php

use App\Controllers\UserController;
use App\Controllers\ArticleController;
use App\Services\Router;
use App\Controllers\Auth;

Router::page('/', 'home');
//Router::post('/admin/destroy', UserController::class, 'destroy',true);
//Router::post('/admin/update', UserController::class,'update', true);
//Router::post('/admin/create', UserController::class,'store', true);
Router::get('/api/redis', ArticleController::class,'all');
Router::delete('/api/delete', ArticleController::class,'delete', true);


 Router::enable();