<?php namespace Teepluss\Console;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;


class ConsoleServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $middlewareMethod = method_exists($router, 'aliasMiddleware') ? 'aliasMiddleware' : 'middleware';
        $router->$middlewareMethod('console_protect', Http\Middlewares\Console::class);

        // Publish config.
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('console.php'),
            __DIR__.'/../resources/assets' => base_path('public/vendor/console'),
        ], 'public');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app['request']->is('console') and $this->app['request']->getMethod() == 'POST') {
            $this->app->bind(
                'Illuminate\Contracts\Debug\ExceptionHandler',
                'Teepluss\Console\Handler'
            );
        }

        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'console'
        );

        $this->loadViewsFrom(
            __DIR__.'/../resources/views', 'console'
        );

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/console'),
        ], 'view');

        if (! $this->app->routesAreCached()) {
            $group = [
                'namespace' => 'Teepluss\Console',
                'middleware' => $this->app['config']['console']['middleware']
            ];

            \Route::group($group, function ($router) {
                require __DIR__ . '/routes.php';
            });
        }

        // Attach Console events
        Console::attach();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
