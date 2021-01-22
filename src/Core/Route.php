<?php

namespace Roiwk\FileUpload\Core;

use Roiwk\FileUpload\Application;
use Roiwk\FileUpload\Contacts\RouteInterface;

class Route implements RouteInterface
{

    public function __construct(Application $application)
    {
        $this->app = $application;
    }


    public function dispatch()
    {
        $dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $router) {
            $router->addRoute('POST', '/roiwk/upload/preprocess', []);
            $router->addRoute('POST', '/roiwk/upload/uploading', []);
            $router->addRoute('POST', '/roiwk/upload/delete', []);
        });
    }


}