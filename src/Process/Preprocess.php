<?php

namespace Roiwk\FileUpload\Process;

use Roiwk\FileUpload\UploadedFile;

class Preprocess extends AbstractProcess
{
    private function validate()
    {
        // 校验扩展名+文件大小
        $file = new UploadedFile('', '', $this->app->parameter['resource_name'], $this->app->parameter['resource_size']);
        foreach ($this->app->validator as $validate) {
            if (!$validate->valid($file)) {
                $this->error = 1;
                $this->errMsg = $validate->getErrorMsg();
                return;
            }
        }
    }

    public function handle(): array
    {
        $this->validate();
        return [
            'tmp_dir'    => $this->app->pathSolver->getFilename($this->app->parameter['resource_name']),
            'chunk_size' => $this->app->config->get('chunk_limit'),
            'error'      => $this->error,
            'err_msg'    => $this->errMsg,
        ];
    }
}