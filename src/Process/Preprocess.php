<?php

namespace Roiwk\FileUpload\Process;

class Preprocess extends AbstractProcess
{
    public function handle(): array
    {
        $this->validate();
        return [
            'sub_dir'    => $this->app->subdir,
            'chunk_size' => $this->app->config->get('chunk_limit'),
            'error'      => $this->error,
            'err_msg'    => $this->errMsg,
        ];
    }
}