<?php

namespace Roiwk\FileUpload\Core;

use Roiwk\FileUpload\Contacts\RequestInterface;

class ProtoRequest implements RequestInterface
{

    public function get(): array
    {
        return $_GET;
    }

    public function post(): array
    {
        return $_POST;
    }

    public function cookie(): array
    {
        return $_COOKIE;
    }

    public function request(): array
    {
        return $_REQUEST;
    }

    public function server(): array
    {
        return $_SERVER;
    }

    public function header(): array
    {
        return (array)getallheaders();
    }

    public function file(): array
    {
        return $_FILES;
    }
}