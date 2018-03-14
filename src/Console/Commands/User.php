<?php

namespace ViktorMiller\LaravelUser\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

/**
 * 
 * @package  laravel-user
 * @author   Viktor Miller <phpfriq@gmail.com>
 */
class User extends Command
{
    use DetectsApplicationNamespace;
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'user:init 
                    {--views            : Only scaffold the user views}
                    {--controllers      : Only scaffold the user controllers}
                    {--notifications    : Only scaffold the user notifications}
                    {--routes           : Only scaffold the user routes}
                    {--force            : Overwrite existing files by default}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold basic user views, routes and controllers';
    
    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        __DIR__ .'/../stubs/views/data.stub' => 
            'resources/views/user/data.blade.php',
        __DIR__ .'/../stubs/views/email.stub' => 
            'resources/views/user/email.blade.php',
        __DIR__ .'/../stubs/views/password.stub' => 
            'resources/views/user/password.blade.php',
        __DIR__ .'/../stubs/views/delete.stub' => 
            'resources/views/user/delete.blade.php'
    ];
    
    /**
     * The controllers that need to be exported
     * 
     * @var array
     */
    protected $controllers = [
        __DIR__ .'/../stubs/controllers/DataController.stub' => 
            'App/Http/Controllers/User/DataController.php',
        __DIR__ .'/../stubs/controllers/EmailController.stub' => 
            'App/Http/Controllers/User/EmailController.php',
        __DIR__ .'/../stubs/controllers/PasswordController.stub' => 
            'App/Http/Controllers/User/PasswordController.php',
        __DIR__ .'/../stubs/controllers/DeleteController.stub' => 
            'App/Http/Controllers/User/DeleteController.php',
    ];
    
    /**
     * The notifications that need to be exported
     * 
     * @var array
     */
    protected $notifications = [
    ];
    
    /**
     * The routes that need to be exported
     * 
     * @var array 
     */
    protected $routes = [
        __DIR__ .'/../stubs/routes/web.stub' => 'routes/web.php'
    ];
    
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->createDirectories();
        
        if ($this->option('notifications')) {
            $this->exportNotifications();
        } elseif ($this->option('controllers')) {
            $this->exportControllers();
        } elseif ($this->option('views')) {
            $this->exportViews();
        } elseif ($this->option('routes')) {
            $this->exportRoutes();
        } else {
            $this->exportViews();
            $this->exportControllers();
            $this->exportNotifications();
            $this->exportRoutes();
        }

        $this->info('User scaffolding generated successfully.');
    }
    
    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectories()
    {
        $this->checkDirs($this->views);
        $this->checkDirs($this->controllers);
        $this->checkDirs($this->notifications);
        $this->checkDirs($this->routes);
    }
    
    /**
     * Check dirs
     * 
     * @param array $arr
     */
    protected function checkDirs(array $arr)
    {
        foreach ($arr as $file) {
            $this->makeDirIfNotExists(base_path($file));
        }
    }
    
    /**
     * Make a new dir if not exists
     * 
     * @param string $path
     */
    protected function makeDirIfNotExists($path)
    {
        $dir = dirname($path);
        
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
    
    /**
     * Export the views.
     *
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $stub => $dist) {
            $path = base_path($dist);
            
            if (file_exists($path) && ! $this->option('force')) {
                if (! $this->confirm("The [{$path}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy($stub, $path);
        }
    }
    
    /**
     * Export the controllers
     * 
     * @return void
     */
    protected function exportControllers()
    {   
        foreach ($this->controllers as $stub => $dist) {
            $path = base_path($dist);
            
            if (file_exists($path) && ! $this->option('force')) {
                if (! $this->confirm("The [{$path}] controller already exists. Do you want to replace it?")) {
                    continue;
                }
            }
            
            file_put_contents($path, $this->compileStub($stub));
        }
    }
    
    /**
     * Export the notifications
     * 
     * @return void
     */
    protected function exportNotifications()
    {
        foreach ($this->notifications as $stub => $dist) {
            $path = base_path($dist);
        
            if (file_exists($path) && ! $this->option('force')) {
                if (! $this->confirm("The [{$path}] Notification already exists. Do you want to replace it?")) {
                    return;
                }
            }
            
            file_put_contents($path, $this->compileStub($stub));
        }
    }
    
    /**
     * Export routes
     * 
     * @return void 
     */
    protected function exportRoutes()
    {
        foreach ($this->routes as $stub => $dist) {
            $path = base_path($dist);
            $content = file_get_contents($stub);
            
            if (strpos(file_get_contents($path), $content) !== false && ! $this->option('force')) {
                if (! $this->confirm("The file [{$path}] already contains confirmation route. Do you want to replace it?")) {
                    continue;
                }
                
                file_put_contents(
                    $path, str_replace($content, '', file_get_contents($path))
                );
            }
            
            file_put_contents($path, $content, FILE_APPEND);
        }
    }
    
    /**
     * Compile stub.
     *
     * @return string
     */
    protected function compileStub($stub)
    {
        return str_replace('{{namespace}}', $this->getAppNamespace(),
            file_get_contents($stub)
        );
    }
}