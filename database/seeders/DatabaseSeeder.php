<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ejecutamos los roles primero
        $this->call([
            RoleSeeder::class,
        ]);

        // 2. Crear usuario Admin principal
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $admin->roles()->attach($adminRole);

        // 3. Crear 10 usuarios normales y hacer que 5 sean editores
        $users = User::factory(10)->create();
        $editorRole = Role::where('name', 'editor')->first();

        $users->random(5)->each(function ($user) use ($editorRole) {
            $user->roles()->attach($editorRole);
        });

        // 4. Crear 5 categorías y 15 etiquetas generales
        $categories = Category::factory(5)->create();
        $tags = Tag::factory(15)->create();

        // 5. Crear 50 posts asignándoles usuarios y categorías existentes
        Post::factory(50)
            ->recycle($users)
            ->recycle($categories)
            ->create()
            ->each(function ($post) use ($tags, $users) {
                // Le asignamos entre 1 y 3 etiquetas aleatorias a cada post
                $post->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );

                // Le creamos 5 comentarios a cada post
                Comment::factory(5)
                    ->recycle($users) // Usamos los usuarios que ya existen para comentar
                    ->create([
                        'post_id' => $post->id
                    ]);
            });
    }
}
