<?php
/**
 * Created by PhpStorm.
 * User: lkboy
 * Date: 2019/6/6
 * Time: 19:54
 */

namespace Sunaloe\ApolloLaravel;


use Illuminate\Support\ServiceProvider;

class ApolloServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }


    public function register()
    {
        $this->configure();

        $this->registerServices();
    }

    protected function registerServices(){
        $this->app->singleton('apollo.laravel', function () {
            return new ApolloLaravel();
        });

        $this->app->singleton('apollo.variable', function () {
            return new ApolloVariable();
        });

        $this->app->singleton('apollo', function ($app) {
            $input = new VariableInput($app['variable']);
            $input->setData();
            return $input;
        });
    }

    protected function configure()
    {
        $this->app->configPath('apollo');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/apollo.php', 'apollo'
        );
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        $this->commands([Console\WorkCommand::class]);
    }
}