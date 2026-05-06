<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LanguageController;

// ── Public ──────────────────────────────────────────────────────────────────
Route::get('/',        fn() => view('index'))->name('home');
Route::get('/about',   [AboutController::class, 'show'])->name('about');
Route::get('/books',             [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}',      [BookController::class, 'show'])->name('books.show');

// ── Language ─────────────────────────────────────────────────────────────────
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// ── Auth ─────────────────────────────────────────────────────────────────────
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ── Profile (all logged-in roles) ────────────────────────────────────────────
Route::get('/profile',  [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

// ── Books CRUD ────────────────────────────────────────────────────────────────
Route::post('/books',            [BookController::class, 'store'])->name('books.store');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::put('/books/{book}',      [BookController::class, 'update'])->name('books.update');
Route::delete('/books/{book}',   [BookController::class, 'destroy'])->name('books.destroy');
Route::post('/books/{book}/buy', [BookController::class, 'buy'])->name('books.buy');

// ── Admin ─────────────────────────────────────────────────────────────────────
Route::get('/admin', [RoleController::class, 'adminDashboard'])->name('admin.dashboard');
Route::post('/admin/users/{user}/role', [RoleController::class, 'assignRole'])->name('admin.assign-role');
Route::post('/admin/users/{user}/ban',  [RoleController::class, 'adminToggleBan'])->name('admin.toggle-ban');

// ── Manager ───────────────────────────────────────────────────────────────────
Route::get('/manager', [RoleController::class, 'managerDashboard'])->name('manager.dashboard');
Route::get('/manager/orders', [RoleController::class, 'managerOrders'])->name('manager.orders');

// ── Moderator ─────────────────────────────────────────────────────────────────
Route::get('/moderator',           [RoleController::class, 'moderatorDashboard'])->name('moderator.dashboard');
Route::get('/moderator/customers', [RoleController::class, 'moderatorCustomers'])->name('moderator.customers');
Route::get('/moderator/books',     [RoleController::class, 'moderatorBooks'])->name('moderator.books');
Route::get('/moderator/managers',  [RoleController::class, 'moderatorManagers'])->name('moderator.managers');
Route::post('/moderator/users/{user}/ban',  [RoleController::class, 'moderatorToggleBan'])->name('moderator.toggle-ban');
Route::post('/moderator/users/{user}/role', [RoleController::class, 'moderatorAssignRole'])->name('moderator.assign-role');

// ── Customer ──────────────────────────────────────────────────────────────────
Route::get('/customer', [RoleController::class, 'customerDashboard'])->name('customer.dashboard');