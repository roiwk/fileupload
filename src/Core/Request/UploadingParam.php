<?php

namespace Roiwk\FileUpload\Core\Request;

use Roiwk\FileUpload\Contacts\RequestInterface;

class UploadingParam
{
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function filename(): string
    {
        return $this->request->post()['filename'];
    }

    public function subDir(): string
    {
        return $this->request->post()['sub_dir'];
    }

    public function chunkFile(): array
    {
        return $this->request->file()['chunk_file'];
    }

    public function chunkTotal(): int
    {
        return $this->request->post()['chunk_total'];
    }

    public function chunkIndex(): int
    {
        return $this->request->post()['chunk_index'];
    }
}
