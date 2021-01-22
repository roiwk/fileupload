<?php

namespace Roiwk\FileUpload\Core\Handler;

use Roiwk\FileUpload\Core\Config;
use Roiwk\FileUpload\Core\PathSolver;
use Roiwk\FileUpload\Core\Request\PreprocessParam;

class Preprocess
{
    private $config;
    private $param;

    public function __construct(Config $config, PreprocessParam $param, PathSolver $pathSolver)
    {
        $this->config = $config;
        $this->param = $param;
        $this->pathSolver = $pathSolver;
    }


    public function handle(): array
    {
        return [
            'sub_dir'    => $this->pathSolver->subDir($this->param->filename()),
            'chunk_size' => $this->config->get('chunk_limit'),
            'error'      => 0,
            'err_msg'    => '',
        ];
    }

}