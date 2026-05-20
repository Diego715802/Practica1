<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Posts con Archivos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Mensajes de Éxito --}}
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
            @endif

            {{-- NUEVO: BLOQUE DE ERRORES (Para que veas por qué no sube) --}}
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong class="font-bold">¡Atención!</strong>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Formulario de Creación --}}
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4">Crear Nuevo Post con Adjuntos</h3>

                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Título</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Contenido</label>
                        <textarea name="content" rows="4" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('content') }}</textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Categoría</label>
                        <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Selecciona una categoría</option>
                            @isset($categories)
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            @endisset
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">Etiquetas</label>
                        @isset($tags)
                        @foreach($tags as $tag)
                        <label class="inline-flex items-center mr-4">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                            <span class="ml-2 text-sm text-gray-600">{{ $tag->name }}</span>
                        </label>
                        @endforeach
                        @endisset
                    </div>

                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                        <label class="block font-bold text-sm text-gray-700 mb-2">Archivos Adjuntos (Máx 5)</label>
                        <input type="file" name="attachments[]" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 font-medium">
                        Publicar Post
                    </button>
                </form>
            </div>

            {{-- Listado de Publicaciones --}}
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4">Publicaciones Existentes</h3>
                @if(isset($posts) && $posts->isNotEmpty())
                <div class="space-y-6">
                    @foreach($posts as $post)
                    <div class="border-b pb-6 last:border-b-0">
                        <div class="flex justify-between items-start">
                            <h4 class="text-md font-bold text-gray-900">{{ $post->title }}</h4>

                            <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                                    Eliminar Post
                                </button>
                            </form>
                        </div>

                        <p class="text-sm text-gray-600 mt-2">{{ $post->content }}</p>

                        @if($post->attachments && $post->attachments->isNotEmpty())
                        <div class="mt-3 bg-gray-50 p-3 rounded-md border border-gray-100">
                            <p class="text-xs font-bold text-gray-700 mb-1">📁 Archivos Adjuntos:</p>
                            <ul class="space-y-1">
                                @foreach($post->attachments as $file)
                                <li class="text-xs text-gray-600 flex items-center">
                                    <span class="mr-1">🔹</span>
                                    <a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                        {{ $file->original_name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="text-xs text-gray-500 mt-3 bg-gray-100 px-2 py-1 rounded inline-block">
                            <span>Autor: <strong>{{ $post->author->name ?? 'Anónimo' }}</strong></span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500">No hay posts creados todavía.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>