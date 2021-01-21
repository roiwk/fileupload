<?php

namespace Roiwk\FileUpload\Core\Request;

use Roiwk\FileUpload\Contacts\RequestInterface;

class PreprocessParam
{
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function filename(): string
    {
        return $this->request->get()['filename'] ?? '';
    }

    public function size(): int
    {
        return $this->request->get()['size'] ?? 0;
    }
}