<?php

namespace Roiwk\FileUpload\Core\Handler;

use Roiwk\FileUpload\Core\Config;
use Roiwk\FileUpload\Core\Request\PreprocessParam;

class Preprocess
{
    private $chunkLimit;
    private $param;

    public function __construct(Config $config, PreprocessParam $param)
    {
        $this->chunkLimit = $config->get('chunk_limit');
        $this->param = $param;
    }


    public function handle(): array
    {
        return [
            // 'sub_dir'    => $this->app->subdir, //todo
            'chunk_size' => $this->chunkLimit,
            'error'      => 0,
            'err_msg'    => '',
        ];
    }

}