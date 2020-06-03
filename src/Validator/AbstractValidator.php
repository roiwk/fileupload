<?php

namespace Roiwk\FileUpload\Validator;

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

    abstract public function valid($needle): bool;

    public function getErrorMsg(): string
    {
        return $this->errMsg;
    }
}