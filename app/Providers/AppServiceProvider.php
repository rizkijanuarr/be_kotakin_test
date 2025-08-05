<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindRepositories();
    }

    public function boot(): void
    {
        //
    }

    protected function bindRepositories(): void
    {
        $interfacePath = app_path('Repositories/Interfaces');

        if (!is_dir($interfacePath)) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($interfacePath));

        foreach ($iterator as $file) {
            if ($file->isDir() || $file->getExtension() !== 'php') {
                continue;
            }

            $interface = 'App\\' . Str::of($file->getPathname())
                ->after(app_path() . '/')
                ->replace('/', '\\')
                ->beforeLast('.php');

            // Derive the implementation class name from the interface name.
            // Example: App\Repositories\Interfaces\Admin\V1\DashboardInterfaceV1
            // Becomes: App\Repositories\Eloquent\Admin\V1\DashboardV1
            $implementation = Str::of($interface)
                ->replace('\\Interfaces\\', '\\Eloquent\\')
                ->replaceLast('Interface', '');

            if (interface_exists($interface) && class_exists($implementation->toString())) {
                $this->app->bind($interface, $implementation->toString());
            }
        }
    }
}
