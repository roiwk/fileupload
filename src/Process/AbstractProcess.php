<?php

namespace Roiwk\FileUpload\Process;

use Roiwk\FileUpload\Container;
use Roiwk\FileUpload\PathSolver;

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
     * @var Container
     */
    public $app;

    /**
     * 分片文件夹名
     *
     * @var string
     */
    protected $folderName;

    /**
     * construct
     *
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;

        $algo = $this->app->config->get('storage.filename_algo');
        $this->app->pathSolver = new PathSolver(
            $this->app->dir, new $algo(),
            $this->app->config->get('storage.filename_prefix'), $this->app->config->get('storage.filename_suffix')
        );
        $this->folderName = $this->app->pathSolver->getFilename($this->app->file->getClientFilename());
        if (isset($this->app->parameter['sub_dir'])) {
            $this->app->dir .= DIRECTORY_SEPARATOR . $this->app->parameter['sub_dir']
                                . DIRECTORY_SEPARATOR . $this->folderName;
        }
    }

    abstract public function handle(): array;
}