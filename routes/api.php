<?php

use App\Http\Controllers\API\Admin\AdminController;
use App\Http\Controllers\API\Admin\ChecksModerationController;
use App\Http\Controllers\API\Admin\UsersModerationController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Lk\LkController;
use App\Http\Controllers\API\Loyal\BonusesController;
use App\Http\Controllers\API\Loyal\CheckController;
use App\Http\Controllers\API\Loyal\DrawController;
use App\Http\Controllers\API\Loyal\OrderController;
use App\Http\Controllers\API\Loyal\OrderQrController;
use App\Http\Controllers\API\Products\ProductsCatalogController;
use App\Http\Controllers\API\Products\ProductsCategoriesController;
use App\Http\Controllers\API\Products\ProductsController;
use Illuminate\Http\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

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
Route::controller(LkController::class)->group(function(){
    Route::post('migrate' , 'migrate');
});
Route::controller(OrderQrController::class)->group(function(){
    Route::get('check/{hash}' , 'activate');
});
Route::controller(LkController::class)->group(function(){
    Route::get('getImage/{hash}' , 'getImage');
});
Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('verify' , 'verify');
});
Route::controller(AdminController::class)->group(function(){
    Route::post('dashboard/login', 'login');
});
Route::controller(LkController::class)->group(function(){
    Route::post('confirm' , 'confirm');
    Route::get('verifyEmail/{hash}' , 'confirmEmail');
});

Route::controller(ProductsController::class)->group(function(){
    Route::get('getRandomProducts' , 'getRandomByToken');
});

Route::controller(ProductsCategoriesController::class)->group(function(){
    Route::get('getRandomCategories' , 'getRandomByToken');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::group([
        'prefix' => 'lk',
    ], function () {
        Route::group([
            'prefix' => 'user',
        ], function () {
            Route::controller(LkController::class)->group(function(){
                Route::post('send' , 'send');
                Route::get('show', 'index');
                Route::post('update', 'update');
                Route::post('updatePhone', 'send');
                Route::post('confirmPhone', 'confirmUpdating');
            });
        });

        Route::group([
            'prefix' => 'checks',
        ], function () {
            Route::controller(CheckController::class)->group(function(){
                Route::get('show', 'index');
                Route::post('upload', 'upload');
            });
        });

        Route::group([
            'prefix' => 'bonuses',
        ], function () {
            Route::controller(BonusesController::class)->group(function(){
                Route::get('balance' , 'userBalance');
                Route::get('history', 'userHistory');
            });
        });

        Route::group([
            'prefix' => 'draw',
        ], function () {
            Route::controller(DrawController::class)->group(function () {
                Route::post('index', 'get');
                Route::get('listDraws', 'getAll');
                Route::post('join', 'joinToDraw');
            });
        });

        Route::group([
            'prefix' => 'products',
        ], function () {
            Route::controller(ProductsController::class)->group(function(){
                Route::get('index', 'index');
                Route::post('show', 'show');
                Route::get('getRandom' , 'random');
            });
        });

            Route::group([
                'prefix' => 'categories',
            ], function () {
                Route::controller(ProductsCategoriesController::class)->group(function(){
                    Route::get('index', 'index');
                });
            });

            Route::group([
                'prefix' => 'catalog',
            ], function () {
                Route::controller(ProductsCatalogController::class)->group(function(){
                    Route::post('index', 'create');
                });
            });
        Route::group([
            'prefix' => 'qrcode',
        ], function () {
            Route::controller(OrderQrController::class)->group(function(){
                Route::post('show' , 'show');
            });
        });
            Route::group([
                'prefix' => 'order',
            ], function () {
                Route::controller(OrderController::class)->group(function(){
                    Route::get('index', 'index');
                    Route::post('create', 'makeUserOrder');
                });
            });

    });
});
       Route::middleware(['auth:sanctum' , 'ability:superadmin'])->group( function () {
        Route::prefix('admin')->group( function () {
            Route::group([
                'prefix' => 'order',
            ], function () {
                Route::controller(OrderController::class)->group(function(){
                    Route::get('index', 'index');
                    Route::post('create', 'makeUserOrder');
                });
            });
            Route::group([
                'prefix' => 'checks',
            ], function () {
                Route::controller(ChecksModerationController::class)->group(function () {
                    Route::get('getChecks', 'get');
                    Route::post('confirmCheck', 'confirm');
                    Route::post('getFilteredChecks', 'getFilteredChecks');
                });
            });
            Route::group([
                'prefix' => 'users',
            ], function () {
                Route::controller(UsersModerationController::class)->group(function () {
                    Route::post('getUsers', 'getUsers');
                    Route::post('getUserHistory', 'getUserHistory');
                    Route::post('updateUser', 'updateUser');
                    Route::post('getUsersByMall' , 'getUsersByMall');
                    Route::post('getMalls' , 'getMalls');
                    Route::post('addBonuses', 'addBonuses');
                });
            });
            Route::group([
                'prefix' => 'categories',
            ], function () {
                Route::controller(ProductsCategoriesController::class)->group(function(){
                    Route::get('index', 'index');
                    Route::post('create', 'create');
                    Route::post('update', 'update');
                    Route::delete('delete', 'delete');
                });
            });
            Route::group([
                'prefix' => 'catalog',
            ], function () {
                Route::controller(ProductsCatalogController::class)->group(function(){
                    Route::post('index', 'index');
                    Route::post('create', 'create');
                    Route::post('update', 'update');
                    Route::delete('delete', 'delete');
                });
            });
            Route::group([
                'prefix' => 'products',
            ], function () {
                Route::controller(ProductsController::class)->group(function () {
                    Route::get('index', 'index');
                    Route::post('show', 'show');
                    Route::post('create', 'create');
                    Route::post('update', 'update');
                    Route::delete('delete', 'delete');
                });
            });
            Route::group([
                'prefix' => 'draw',
            ], function () {
                Route::controller(DrawController::class)->group(function () {
                    Route::post('create', 'create');
                    Route::post('update', 'update');
                    Route::post('delete' , 'delete');
                    Route::get('finish' , 'getDrawMembers');
                });
            });

        });
});
