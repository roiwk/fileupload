<?php

namespace Roiwk\FileUpload\Contacts;

interface RequestInterface
{
    public function get(): array;
    public function post(): array;
    public function file(): array;
    public function cookie(): array;
    public function request(): array;
    public function server(): array;
    public function header(): array;
}
