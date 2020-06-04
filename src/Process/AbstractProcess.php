<?php

namespace Roiwk\FileUpload\Process;

use Roiwk\FileUpload\App;

abstract class AbstractProcess
{
    /**
     * 0 成功
     *
     * @var integer
     */
    public $error = 0;

    /**
     * @var string
     */
    public $errMsg = '';

    /**
     * @var App
     */
    public $app;

    /**
     * construct
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    abstract public function handle(): array;
}