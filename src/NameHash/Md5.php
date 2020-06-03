<?php

namespace Roiwk\FileUpload\NameHash;

class Md5 implements HashInterface
{
    public static function hash(string $str, string $prefix = '', string $suffix = ''): string
    {
        return $prefix . md5($str) . $suffix;
    }
}