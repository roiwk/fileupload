<?php

namespace Roiwk\FileUpload\Process;

use Roiwk\FileUpload\Exception\MakeStorageDirException;
use Roiwk\FileUpload\Exception\MoveUploadedFileException;
use Roiwk\FileUpload\IndexFile;

class Uploading extends AbstractProcess
{

    const FINISHED = 1;
    const UPLOADING = 0;

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
     * 索引文件
     *
     * @var IndexFile
     */
    private $indexFile;

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
            'sub_dir'  => $this->app->parameter['sub_dir'],
            'path'     => '/' . $this->app->parameter['sub_dir'] .
                          '/' . $this->app->pathSolver->getFilename($this->app->parameter['resource_name']),
            'finish'   => $this->finish,
            'error'    => $this->error,
            'err_msg'  => $this->errMsg,
        ];
    }

    /**
     * 创建存储文件夹
     *
     * @return self
     */
    private function createStoreFolder(): self
    {
        if (!is_dir($this->dir)) {
            if (!mkdir($this->dir, 0766, true)) {
                throw new MakeStorageDirException();
            }
        }
        return $this;
    }

    /**
     * 移动上传的文件到文件夹
     *
     * @return self
     */
    private function moveTmpFile(): self
    {
        $from = $this->app->file->getPathname();
        $this->chunkFilename  = $this->dir . DIRECTORY_SEPARATOR
                            . $this->folderName . '_' . $this->app->parameter['chunk_index'];
        if (!move_uploaded_file($from, $this->chunkFilename)) {
            if (!copy($from, $this->chunkFilename)) {
                throw new MoveUploadedFileException();
            }
        }
        return $this;
    }

    /**
     * 生成索引文件
     *
     * @return self
     */
    private function generateIndexFile(): self
    {
        $indexFile = new IndexFile($this->dir);
        $indexFile->setChunk($this->app->parameter['chunk_index'], $this->app->parameter['chunk_total'])
                ->append($this->chunkFilename);
        $this->indexFile = clone $indexFile;
        return $this;
    }

    /**
     * 检查上传是否完成,完成并删除临时文件与索引文件
     *
     * @return self
     */
    private function checkFinish(): self
    {
        if ($this->indexFile->isFinish) {
            // 合并文件
            $filename = $this->dir . DIRECTORY_SEPARATOR . $this->app->parameter['resource_name'];
            $merge_handle = fopen($filename, 'wb');
            foreach ($this->indexFile->indexArray as $chunk_file) {
                $open_chunk = fopen($chunk_file, 'rb');
                fwrite($merge_handle, fread($open_chunk, filesize($chunk_file)));
                fclose($open_chunk);
                unlink($chunk_file);
            }
            fclose($merge_handle);
            $this->finish = static::FINISHED;
        }
        return $this;
    }


}