<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Administrativo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Tarjetas de Estadísticas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h5 class="text-gray-500 text-sm font-bold uppercase">Total Posts</h5>
                    <p class="text-3xl font-extrabold text-indigo-600">{{ $total_posts }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h5 class="text-gray-500 text-sm font-bold uppercase">Total Usuarios</h5>
                    <p class="text-3xl font-extrabold text-green-600">{{ $total_users }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h5 class="text-gray-500 text-sm font-bold uppercase">Total Comentarios</h5>
                    <p class="text-3xl font-extrabold text-red-600">{{ $total_comments }}</p>
                </div>
            </div>

            {{-- Tablas Recientes --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Posts --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg mb-4">Posts Recientes</h3>
                    <ul class="divide-y divide-gray-200">
                        @forelse($recent_posts as $post)
                        <li class="py-3 flex justify-between">
                            <span class="text-sm font-medium">{{ $post->title }}</span>
                            <span class="text-xs text-gray-500">{{ $post->created_at->format('d/m/Y') }}</span>
                        </li>
                        @empty
                        <p class="text-gray-500 text-sm">Sin posts</p>
                        @endforelse
                    </ul>
                </div>

                {{-- Auditoría --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg">Auditoría Reciente</h3>
                        <a href="{{ route('admin.audits.index') }}" class="text-sm text-blue-600 hover:underline">Ver todo</a>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        @forelse($recent_audits as $audit)
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <span class="text-xs font-bold uppercase px-2 py-1 rounded bg-gray-100 text-gray-600">{{ $audit->action }}</span>
                                <span class="text-sm font-medium ml-2">{{ $audit->model_type }} #{{ $audit->model_id }}</span>
                            </div>
                            <span class="text-xs text-gray-500">{{ $audit->user_name }}</span>
                        </li>
                        @empty
                        <p class="text-gray-500 text-sm">Sin cambios registrados</p>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>