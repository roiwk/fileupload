<?php

namespace Roiwk\FileUpload\Response;

class DefaultResponse implements ResponseInterface
{

    public function sendResponse(?array $content)
    {
        header('Content-type: application/json');
        return json_encode($content);
    }

}