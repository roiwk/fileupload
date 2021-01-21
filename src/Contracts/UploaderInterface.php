<?php

namespace Roiwk\FileUpload\Contacts;


interface UploaderInterface
{
    public function preprocess(RequestInterface $request): ResponseInterface;
    public function uploading(RequestInterface $request): ResponseInterface;
    public function delete(RequestInterface $request): ResponseInterface;
}
