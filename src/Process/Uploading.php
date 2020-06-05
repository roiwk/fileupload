<?php

namespace Roiwk\FileUpload\Process;

use Roiwk\FileUpload\Exception\MakeStorageDirException;
use Roiwk\FileUpload\Exception\MoveUploadedFileException;

class Uploading extends AbstractProcess
{

    /**
     * 是否上传完成
     *
     * @var int  0|1
     */
    private $finish = 0;

    /**
     * 分片文件名
     *
     * @var string
     */
    private $chunkFilename = '';


    /**
     * 校验
     *
     * @return void
     */
    private function validate(): bool
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

    public function handle(): array
    {
        if ($this->validate()) {
            $this->createStoreFolder()
                ->moveTmpFile()
                ->generateIndexFile()
                ->checkFinish();
        }
        return [
            'filename' => $this->app->parameter['resource_name'],
            'path'     => $this->app->pathSolver->getFilename($this->app->parameter['resource_name']),
            'finish'   => $this->finish,
            'error'    => $this->error,
            'err_msg'  => $this->errMsg,
        ];
    }

    private function createStoreFolder(): self
    {
        if (!is_dir($this->app->dir)) {
            if (!mkdir($this->app->dir, 0766, true)) {
                throw new MakeStorageDirException();
            }
        }
        return $this;
    }

    private function moveTmpFile(): self
    {
        $from = $this->app->file->getPathname();
        $this->chunkFilename  = $this->app->dir . DIRECTORY_SEPARATOR
                            . $this->folderName . '_' . $this->app->parameter['chunk_index'];
        if (!move_uploaded_file($from, $this->chunkFilename)) {
            if (!copy($from, $this->chunkFilename)) {
                throw new MoveUploadedFileException();
            }
        }
        return $this;
    }

    private function generateIndexFile(): self
    {
        return $this;
    }

    private function checkFinish(): self
    {
        return $this;
    }


}