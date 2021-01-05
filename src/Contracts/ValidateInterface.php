<?php

namespace Roiwk\FileUpload\Contacts;

use \SplFileInfo;

interface ValidateInterface
{
    public function valid(SplFileInfo $file): bool;
}
