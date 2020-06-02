<?php

namespace Roiwk\FileUpload\Storage;

interface HashInterface
{
    public function hash(string $str): string;
}