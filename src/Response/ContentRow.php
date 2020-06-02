<?php

namespace Roiwk\FileUpload\Response;

class ContentRow
{
    public $chunkSize;
    public $tmpDir;
    public $err;
    public $errMsg;

    public function __construct(int $chunkSize, string $tmpDir, int $err, string $errMsg = '')
    {
        $this->chunkSize = $chunkSize;
        $this->tmpDir    = $tmpDir;
        $this->err       = $err;
        $this->errMsg    = $errMsg;
    }
}