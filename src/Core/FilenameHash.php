<?php

namespace Roiwk\FileUpload\Core;

use Roiwk\FileUpload\Contacts\FilenameHashInterface;

class Md5 implements FilenameHashInterface
{
    public function hash(string $str, string $prefix = '', string $suffix = ''): string
    {
        return $prefix . md5($str) . $suffix;
    }
}
