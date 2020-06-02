<?php

namespace Roiwk\FileUpload\Validator;

use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class AbstractValidator
{
    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @var string
     */
    private $error;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    abstract public function valid($passable): bool;

    public function error(): string
    {
        return $this->error;
    }
}