<?php

namespace Roiwk\FileUpload\NameHash;

interface HashInterface
{
    public static function hash(string $str, string $prefix = '', string $suffix = ''): string;
}