<?php

namespace Roiwk\FileUpload\Response;

interface ResponseInterface
{
    public function sendResponse(?array $content);
}