<?php

namespace Roiwk\FileUpload\Validator;

class Size extends AbstractValidator
{
    public function valid(int $passable): bool
    {
        if ($this->file->isValid()) {
            $size = $this->file->getSize();
            $pass = $size <= $passable;
            if (!$pass) {
                $this->error = 'The uploading file exceeds the file size limit defined in config file';
            }
            return $pass;
        } else {
            $this->error = $this->file->getErrorMessage();
            return false;
        }
    }
}