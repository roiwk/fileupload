<?php

namespace Roiwk\FileUpload;

use League\Container\Container;
use Roiwk\FileUpload\Contacts\{RequestInterface, ResponseInterface};
use Roiwk\FileUpload\Core\Config;

class Application extends Container
{

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
        $this->register();
    }


    private function register()
    {
        $registers = $this->get(Config::class)->get('registers', []);

        foreach ($registers as $key => $value)
        {
            $this->add($key, $value);
        }
    }

    public function run()
    {
        $request = $this->get(RequestInterface::class);
        $response = $this->get(ResponseInterface::class);
    }

}