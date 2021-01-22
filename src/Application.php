<?php

namespace Roiwk\FileUpload;

use League\Container\Container;
use Roiwk\FileUpload\Contacts\{RequestInterface, ResponseInterface};
use Roiwk\FileUpload\Core\Config;
use Roiwk\FileUpload\Core\Handler\{Preprocess, Uploading, Delete};
use Roiwk\FileUpload\Core\Route;

class Application extends Container
{
    private $route_preprocess = '/roiwk/upload/preprocess';
    private $route_uploading = '/roiwk/upload/uploading';
    private $route_delete = '/roiwk/upload/delete';

    public function __construct($config)
    {
        $this->bootstrap($config);
    }

    private function bootstrap($config)
    {
        // 单例
        $this->share(Config::class, function () use ($config) {
            return Config::getInstance($config);
        });

        // 注册依赖注入
        foreach ($this->registers() as $key => $value) {
            $this->add($key, $value);
        }
    }

    public function run()
    {
        $this->add(Route::class)->addArguments([
            $this->get(RequestInterface::class),
            $this,
        ]);
        // $request = $this->get(RequestInterface::class);
        // $response = $this->get(ResponseInterface::class);
        // $this->router();
    }

    private function registers(): array
    {
        return [
            RequestInterface::class  => ProtoRequest::class,
            ResponseInterface::class => ProtoResponse::class,
            'handle.preprocess' => Preprocess::class,
            'handle.uploading'  => Uploading::class,
            'handle.delete'     => Delete::class,
        ];
    }



}