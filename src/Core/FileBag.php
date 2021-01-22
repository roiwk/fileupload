<?php

namespace Roiwk\FileUpload\Core;

use Roiwk\FileUpload\Core\FileBag\IndexFile;

class FileBag
{
    private $indexFile;
    private $chunkFileArray;

    public function __construct(string $filePath)
    {
        $this->indexFile = new IndexFile($filePath);
        $this->chunkFileArray;
    }


    public function saveTo(string $filename)
    {
        
    }
}