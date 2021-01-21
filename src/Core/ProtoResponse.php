<?php

namespace Roiwk\FileUpload\Core;

use Roiwk\FileUpload\Contacts\ResponseInterface;

class ProtoResponse implements ResponseInterface
{
    public function response(?string $content)
    {
        header('Content-type: application/json');
        return $content;
    }
}