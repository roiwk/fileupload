<?php

namespace Roiwk\FileUpload\Contacts;

interface ConfigInterface
{
    public function get($key, $default);
    public function set($key, $value);
}
