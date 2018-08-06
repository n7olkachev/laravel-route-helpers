<?php

namespace N7olkachev\RouteHelpers;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class RouteHelpers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:helpers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;
    /**
     * An array of all the registered routes.
     *
     * @var \Illuminate\Routing\RouteCollection
     */
    protected $routes;

    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Router $router, Filesystem $files)
    {
        parent::__construct();

        $this->router = $router;
        $this->routes = $router->getRoutes();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $functions = collect($this->routes)
            ->map(function (Route $route) {
                $routeName = $route->getName();
                if (!$routeName) {
                    return;
                }

                $functionName = $this->generateFunctionName($route);

                return $this->compileFunction($routeName, $functionName);
            })
            ->filter();

        $result = "<?php\n\n" . $functions->implode("\n");

        $this->saveResult($result);

        $this->info('Generated ' . $functions->count() . ' helpers!');
    }

    protected function generateFunctionName(Route $route)
    {
        $functionName = str_replace(['.', '-', ':'], '_', $route->getName()) . '_url';

        if (preg_match('/\d.*/', $functionName)) {
            $functionName = '_' . $functionName; // TODO: better ideas?
        }

        return $functionName;
    }

    protected function compileFunction($routeName, $functionName)
    {
        $stub = $this->files->get(__DIR__ . '/function.stub');

        return str_replace(['{function_name}', '{route_name}'], [$functionName, $routeName], $stub);
    }

    protected function saveResult($result)
    {
        $this->files->put(config('route-helpers.path'), $result);
    }
}
