<?php

namespace Roiwk\FileUpload\Core\Parameter;

use Roiwk\FileUpload\Contacts\RequestInterface;

class DeleteParam
{
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function filename(): string
    {
        return $this->request->get()['filename'] ?? '';
    }

    public function subDir(): string
    {
        return $this->request->post()['sub_dir'];
    }
}
