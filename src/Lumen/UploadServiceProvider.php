<?php

namespace Roiwk\FileUpload\Lumen;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Roiwk\FileUpload\Uploader;

class UploadServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * 注册绑定到容器中
     *
     * @return void
     */
    public function register()
    {
        $configFilename = $this->app->getConfigurationPath('fileupload');
        if (!file_exists($configFilename)) {
            copy(__DIR__.'/../config.example', $configFilename) || $this->mergeConfigFrom(__DIR__.'/../config.example','fileupload');
        }

        $this->app->configure('fileupload');

        $this->app->singleton(Uploader::class, function ($app) {
            return new Uploader(config('fileupload'));
        });

        $this->app->alias('fileupload', 'Roiwk\FileUpload\Uploader');


    }

    /**
     * 启动所有的应用服务。
     *
     * @return void
     */
    public function boot()
    {

        $this->app->loadRoutesFrom(__DIR__ . '/routes.php');

    }

    /**
     * 获取由提供者提供的服务。
     *
     * @return array
     */
    public function provides()
    {
        return [Uploader::class];
    }

}

