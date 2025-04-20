<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {


        $routes = collect(Route::getRoutes())
            ->map(function ($route) {
                $folder = explode('/', $route->uri())[0];
                return [
                    'url' => $route->uri(),
                    'name' => $route->getName(),
                    'folder' => $folder,
                ];
            })
            ->groupBy('folder');

        $excludedRoutes = [
            'login',
            'forgot-password',
            'reset-password',
            'verify-email',
            'verify-email/{id}/{hash}',
            'storage/{path}',
            'up',
            'registration',
            '/validate-user',
            '/submit-form',
            '/',
            'register',
            'reset-password/{token}',
            'confirm-password',
        ];
        foreach ($routes as $folder => $folderRoutes) {
            foreach ($folderRoutes as $route) {
                if (in_array($route['url'], $excludedRoutes) || !$route['name']) {
                    continue;
                }
                Permission::firstOrCreate([
                    'name' => $route['name'],
                    'url' => $route['url'],
                    'group' => $folder,
                    'slug' => Str::slug(str_replace('.', ' ', $route['name'])),
                ]);
            }
        }
    }
}
