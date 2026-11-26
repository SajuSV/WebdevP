<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\AdminOnly;
use App\Http\Middleware\RequireSiteAccess;
use Illuminate\Support\Facades\Route;

/*
 | Every URL of the website is listed here.
 | (This file replaces Angular's app.routes.ts)
 */

// ---------- Public pages ----------
Route::middleware(RequireSiteAccess::class)->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/projects', [PageController::class, 'projects'])->name('projects.index');
    Route::get('/projects/{project:slug}', [PageController::class, 'project'])->name('projects.show');
});

// ---------- Login / Logout ----------
// "throttle:5,1" = maximum 5 tries per minute (stops password guessing)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::get('/admin-login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin-login', [AuthController::class, 'adminLogin'])->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------- Admin panel (admins only) ----------
Route::prefix('admin')->name('admin.')->middleware(AdminOnly::class)->group(function () {
    Route::redirect('/', '/admin/site');

    Route::get('/site', [SiteController::class, 'edit'])->name('site.edit');
    Route::put('/site', [SiteController::class, 'update'])->name('site.update');
    Route::put('/user-access', [SiteController::class, 'userAccess'])->name('user-access.update');

    Route::get('/services', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services', [ServiceController::class, 'update'])->name('services.update');

    Route::get('/about', [AboutController::class, 'edit'])->name('about.edit');
    Route::put('/about', [AboutController::class, 'update'])->name('about.update');

    // Creates: index, create, store, edit, update, destroy
    Route::resource('projects', AdminProjectController::class)->except('show');
});
