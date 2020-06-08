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
     * 文件夹名
     *
     * @var string
     */
    protected $dir;

    /**
     * 子文件夹名
     *
     * @var string
     */
    protected $subdir;

    /**
     * construct
     *
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;

        if (isset($this->app->parameter['sub_dir'])) {
            $this->subdir = $this->app->parameter['sub_dir'];
        } else {
            $this->subdir = $this->app->subdir;
        }
        $this->dir = $this->app->dir . DIRECTORY_SEPARATOR . $this->subdir;

        $algo = $this->app->config->get('storage.filename_algo');
        $this->app->pathSolver = new PathSolver(
            $this->dir, new $algo(),
            $this->app->config->get('storage.filename_prefix'), $this->app->config->get('storage.filename_suffix')
        );
        $this->folderName = $this->app->pathSolver->getFilename($this->app->file->getClientFilename());
        $this->dir .= DIRECTORY_SEPARATOR . $this->folderName;
    }

    /**
     * 校验
     *
     * @return void
     */
    protected function validate(): bool
    {
        foreach ($this->app->validator as $validate) {
            if (!$validate->valid($this->app->file)) {
                $this->error = 1;
                $this->errMsg = $validate->getErrorMsg();
                return false;
            }
        }
        return true;
    }

    abstract public function handle(): array;
}