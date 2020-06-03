<?php

namespace Roiwk\FileUpload\Validator;

class Size extends AbstractValidator
{
    /**
     * @var int
     */
    protected $passable;

    public function __construct(int $passable)
    {
        $this->passable = $passable;
    }

    public function valid($size): bool
    {
        $this->error = $pass = $size <= $this->passable;
        if (!$pass) {
            $this->errMsg = 'The uploading file exceeds the file size limit defined in config file';
        }
        return $pass;
    }
}