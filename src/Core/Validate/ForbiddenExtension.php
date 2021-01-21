<?php

namespace Roiwk\FileUpload\Validator;

use Roiwk\FileUpload\Contacts\ValidateInterface;
use Roiwk\FileUpload\UploadedFile;

class ForbiddenExtension implements ValidateInterface
{
    /**
     * @var array
     */
    protected $passable;

    public function __construct(array $passable)
    {
        $this->passable = $passable;
    }

    public function valid(ChunkFileInterface $file): bool
    {
        $pass = !in_array($file->getExtension(), $this->passable);
        $this->error = $pass;
        if (!$pass) {
            $this->errMsg = 'Not allowed file extension in config file.';
        }
        return $pass;
    }
}