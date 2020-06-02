<?php

namespace Roiwk\FileUpload\Response;

use Symfony\Component\HttpFoundation\Response;

interface ResponseInterface
{
    public function sendResponse(Response $response): Response;
}