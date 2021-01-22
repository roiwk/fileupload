<?php

namespace Roiwk\FileUpload\Core\Parameter;

use Roiwk\FileUpload\Contacts\RequestInterface;

class PreprocessParam
{
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function filename(): string
    {
        return $this->request->post()['filename'] ?? '';
    }

    public function size(): int
    {
        return $this->request->post()['size'] ?? 0;
    }
}