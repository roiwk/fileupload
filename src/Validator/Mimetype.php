<?php

namespace Roiwk\FileUpload\Validator;

class Mimetype extends AbstractValidator
{
    public function valid(array $passable): bool
    {
        if ($this->file->isValid()) {
            $mime = $this->file->getClientMimeType();
            $pass = in_array($mime, $passable);
            if (!$pass) {
                $this->error = 'Not allowed file mime type in config file.';
            }
            return $pass;
        } else {
            $this->error = $this->file->getErrorMessage();
            return false;
        }
    }
}