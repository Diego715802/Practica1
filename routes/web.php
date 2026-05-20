<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $categories = \App\Models\Category::all();
        $tags = \App\Models\Tag::all();

        // AQUÍ ESTÁ EL CAMBIO: Agregamos 'attachments' para que cargue los archivos eficientemente
        $posts = \App\Models\Post::with(['category', 'author', 'tags', 'attachments'])->latest()->get();

        return view('dashboard', compact('categories', 'tags', 'posts'));
    })->name('dashboard');

    // Habilita todo el CRUD (crear, editar, borrar)
    Route::resource('posts', PostController::class);

    // Ruta temporal para la captura de la Policy (Error 403)
    Route::get('/probar-policy', function () {
        $post = \App\Models\Post::first();
        \Illuminate\Support\Facades\Gate::authorize('update', $post);
        return "Tienes permiso de editar";
    });

    // Ruta de prueba exclusiva para administradores (Práctica anterior)
    Route::get('/admin-panel', function () {
        return 'Panel exclusivo de Administrador.';
    })->middleware('role:admin');

    // --- NUEVO BLOQUE PRÁCTICA 5: DASHBOARD Y AUDITORÍA ---
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/audits', [\App\Http\Controllers\Admin\AuditController::class, 'index'])->name('audits.index');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
