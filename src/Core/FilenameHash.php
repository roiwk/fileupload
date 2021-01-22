<?php

namespace Roiwk\FileUpload\Core;

use Roiwk\FileUpload\Contacts\FilenameHashInterface;

class Md5 implements FilenameHashInterface
{
    public function hash(string $str): string
    {
        return md5($str);
    }
}
