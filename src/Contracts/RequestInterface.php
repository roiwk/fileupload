<?php

namespace Roiwk\FileUpload\Contacts;

interface RequestInterface
{
    public function get(): array;
    public function post(): array;
    public function file(): array;
}
