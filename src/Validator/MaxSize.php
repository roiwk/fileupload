<?php

namespace Roiwk\FileUpload\Validator;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class MaxSize extends AbstractValidator
{
    /**
     * @var int
     */
    private $filesize;

    public function __construct(UploadedFile $file, int $size)
    {
        $this->filesize = $size;
        return parent::__construct($file);
    }

    public function setSize(int $size): void
    {
        $this->filesize = $size;
    }

    public function getSize(): int
    {
        return $this->filesize;
    }

    public function valid(int $passable): bool
    {
        if ($this->file->isValid()) {
            $pass = ($this->getSize() <= $passable);
            if (!$pass) {
                $this->error = 'The file exceeds the upload limit defined in config file';
            }
            return $pass;
        } else {
            $this->error = $this->file->getErrorMessage();
            return false;
        }
    }
}