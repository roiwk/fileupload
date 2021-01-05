<?php

namespace Roiwk\FileUpload\Contacts;

interface FilenameHashInterface
{
    public function hash(string $str, string $prefix = '', string $suffix = ''): string;
}
