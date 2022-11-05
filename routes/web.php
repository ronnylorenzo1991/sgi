<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\SpaController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\EventController;
use \App\Http\Controllers\SubcategoryController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\DefaultController;
use \App\Http\Controllers\RoleController;
use \App\Http\Controllers\AuditController;
use \App\Http\Controllers\AvailabilityController;
use \App\Http\Controllers\SiteController;
use \App\Http\Controllers\NewsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', SpaController::class)->name('dashboard');
    Route::get('/events', SpaController::class)->name('events');
    Route::get('/settings', SpaController::class)->name('settings');
    Route::get('/users', SpaController::class)->name('users');
    Route::get('/roles', SpaController::class)->name('roles');
    Route::get('/audits', SpaController::class)->name('audits');
    Route::get('/availabilities', SpaController::class)->name('availabilities');
    Route::get('/news', SpaController::class)->name('news');
});

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

// Argon pages routes
Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::get('upgrade', function () {
        return view('pages.upgrade');
    })->name('upgrade');
    Route::get('map', function () {
        return view('pages.maps');
    })->name('map');
    Route::get('icons', function () {
        return view('pages.icons');
    })->name('icons');
    Route::get('table-list', function () {
        return view('pages.tables');
    })->name('table');
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
//
//    Route::resource('category', CategoryController::class)
//        ->names('category');
//
//    Route::resource('subcategory', SubcategoryController::class)
//        ->names('subcategory');
});

Route::group(['middleware' => 'auth', 'prefix' => 'users'], function () {
        Route::middleware(['auth:sanctum', 'verified'])
            ->get('/', SpaController::class)->name('users');
        Route::get('/all', [UserController::class, 'getAll'])
            ->name('users.all');
        Route::post('/create', [UserController::class, 'store'])
            ->name('users.create');
        Route::post('{id}/edit', [UserController::class, 'update'])
            ->name('users.edit');
        Route::delete('{id}/remove', [UserController::class, 'delete'])
            ->name('users.remove');
    });

Route::group(['middleware' => 'auth', 'prefix' => 'roles'], function () {
        Route::middleware(['auth:sanctum', 'verified'])
            ->get('/', SpaController::class)->name('roles');
        Route::get('/all', [RoleController::class, 'getAll'])
            ->name('roles.all');
        Route::post('/create', [RoleController::class, 'store'])
            ->name('roles.create');
        Route::post('{id}/edit', [RoleController::class, 'update'])
            ->name('roles.edit');
        Route::delete('{id}/remove', [RoleController::class, 'delete'])
            ->name('roles.remove');
        Route::post('{id}/addPermission', [RoleController::class, 'addPermission'])
            ->name('roles.add_permission');
    });

Route::group(['middleware' => 'auth', 'prefix' => 'events'], function () {
    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/', SpaController::class)->name('events');
    Route::get('/all', [EventController::class, 'getAll'])
        ->name('events.all');
    Route::post('/create', [EventController::class, 'store'])
        ->name('events.create');
    Route::post('{id}/edit', [EventController::class, 'update'])
        ->name('events.edit');
    Route::delete('{id}/remove', [EventController::class, 'delete'])
        ->name('events.remove');
    Route::post('{id}/addPermission', [EventController::class, 'addPermission'])
        ->name('events.add_permission');
    Route::get('/total-by-month', [EventController::class, 'totalByMonth'])
        ->name('events.total_by_month');
    Route::get('/total-by-entity', [EventController::class, 'totalsByEntities'])
        ->name('events.totals_by_entities');
    Route::get('/total-by-categories', [EventController::class, 'totalByCategories'])
        ->name('events.totals_by_categories');
    Route::get('events/export/', [EventController::class, 'export'])->name('events.export');
    Route::get('/total-by-subcategories', [EventController::class, 'totalBySubcategories'])
        ->name('events.totals_by_subcategories');
    Route::get('/total-by-detected-by', [EventController::class, 'totalByDetectedBy'])
        ->name('events.totals_by_detected_by');
    Route::get('/total-by-ministries', [EventController::class, 'totalByMinistries'])
        ->name('events.totals_by_ministries');
    Route::get('/total-by-entities-nationals', [EventController::class, 'totalByEntitiesNationals'])
        ->name('events.totals_by_entities_nationals');
    Route::get('/total-by-countries-involved', [EventController::class, 'totalByCountriesInvolved'])
        ->name('events.totals_by_countries_involved');
    Route::get('/total-by-foreign-entities-involved', [EventController::class, 'totalByForeignEntitiesInvolved'])
        ->name('events.totals_by_foreign_entities_involved');
    Route::get('/total-by-foreign-contribute', [EventController::class, 'totalByContribute'])
        ->name('events.totals_by_contribute');
    Route::get('/total-by-source-target', [EventController::class, 'totalsBySourceTarget'])
        ->name('events.totals_by_source_target');
});

Route::group(['middleware' => 'auth', 'prefix' => 'defaults'], function () {
        Route::get('/lists', [DefaultController::class, 'getLists'])
            ->name('defaults.lists');
    });

Route::group(['middleware' => 'auth', 'prefix' => 'categories'], function () {
    Route::get('/all', [CategoryController::class, 'getAll'])
        ->name('categories.all');
    Route::post('/create', [CategoryController::class, 'store'])
        ->name('categories.create');
    Route::post('{id}/edit', [CategoryController::class, 'update'])
        ->name('categories.edit');
    Route::delete('{id}/remove', [CategoryController::class, 'delete'])
        ->name('categories.remove');
});

Route::group(['middleware' => 'auth', 'prefix' => 'subcategories'], function () {
    Route::get('/all', [SubcategoryController::class, 'getAll'])
        ->name('subcategories.all');
    Route::post('/create', [SubcategoryController::class, 'store'])
        ->name('subcategories.create');
    Route::post('{id}/edit', [SubcategoryController::class, 'update'])
        ->name('subcategories.edit');
    Route::delete('{id}/remove', [SubcategoryController::class, 'delete'])
        ->name('subcategories.remove');
});

Route::group(['middleware' => 'auth', 'prefix' => 'availabilities'], function () {
    Route::get('/all', [AvailabilityController::class, 'getAll'])
        ->name('availabilities.all');
    Route::post('/create', [AvailabilityController::class, 'store'])
        ->name('availabilities.create');
    Route::post('{id}/edit', [AvailabilityController::class, 'update'])
        ->name('availabilities.edit');
    Route::delete('{id}/remove', [AvailabilityController::class, 'delete'])
        ->name('availabilities.remove');
});

Route::group(['middleware' => 'auth', 'prefix' => 'sites'], function () {
    Route::get('/all', [SiteController::class, 'getAll'])
        ->name('sites.all');
    Route::post('/create', [SiteController::class, 'store'])
        ->name('sites.create');
    Route::post('{id}/edit', [SiteController::class, 'update'])
        ->name('sites.edit');
    Route::delete('{id}/remove', [SiteController::class, 'delete'])
        ->name('sites.remove');
});

Route::group(['middleware' => 'auth', 'prefix' => 'news'], function () {
    Route::get('/all', [NewsController::class, 'getAll'])
        ->name('news.all');
    Route::post('/create', [NewsController::class, 'store'])
        ->name('news.create');
    Route::post('{id}/edit', [NewsController::class, 'update'])
        ->name('news.edit');
    Route::delete('{id}/remove', [NewsController::class, 'delete'])
        ->name('news.remove');
});

Route::group(['middleware' => 'auth', 'prefix' => 'logs'], function () {
    Route::get('/all', [AuditController::class, 'getAll'])
        ->name('audits.all');
});
//Auth::routes();
