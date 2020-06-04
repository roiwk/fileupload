<?php

namespace Roiwk\FileUpload\Validator;

use Roiwk\FileUpload\UploadedFile;

abstract class AbstractValidator
{
    /**
     * @var bool
     */
    protected $error;

    /**
     * @var string
     */
    protected $errMsg;

    abstract public function valid(UploadedFile $file): bool;

    public function getErrorMsg(): string
    {
        return $this->errMsg;
    }
}