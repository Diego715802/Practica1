<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostWithAttachmentsRequest;
use App\Services\FileService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'author', 'tags', 'attachments'])->latest()->get();
        return view('posts.index', compact('posts'));
    }

    // Le inyectamos la validación nueva y el FileService
    public function store(StorePostWithAttachmentsRequest $request, FileService $fileService)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $post = $user->posts()->create([
            'title'       => $request->validated('title'),
            'content'     => $request->validated('content'),
            'category_id' => $request->validated('category_id'),
        ]);

        if ($request->has('tags')) {
            $post->tags()->attach($request->validated('tags'));
        }

        // --- NUEVO: GUARDAR ARCHIVOS ---
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileService->storeAttachment($file, $post->id);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Post creado exitosamente con archivos');
    }

    public function destroy(Post $post, FileService $fileService)
    {
        Gate::authorize('delete', $post);

        // Borramos los archivos físicos primero
        foreach ($post->attachments as $attachment) {
            $fileService->deleteAttachment($attachment);
        }

        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post y archivos eliminados correctamente');
    }
}
