<?php

namespace Roiwk\FileUpload\Validator;

use Roiwk\FileUpload\UploadedFile;

class Size extends AbstractValidator
{
    /**
     * @var int
     */
    protected $passable;

    /**
     * @var int
     */
    protected $size = 0;

    public function __construct(int $passable)
    {
        $this->passable = $passable;
    }

    public function setPassable(int $passable)
    {
        $this->passable = $passable;
        return $this;
    }

    public function valid(UploadedFile $file): bool
    {
        $this->error = $pass = $file->getClientSize() <= $this->passable;
        if (!$pass) {
            $this->errMsg = 'The uploading file exceeds the file size limit defined in config file.';
        }
        return $pass;
    }
}