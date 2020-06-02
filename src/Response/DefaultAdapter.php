<?php

namespace Roiwk\FileUpload\Response;

use Symfony\Component\HttpFoundation\Response;

class DefaultAdapter implements ResponseInterface
{
    public function sendResponse(Response $response): Response
    {
        return $response;
    }
}