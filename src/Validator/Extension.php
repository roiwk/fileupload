<?php

namespace Roiwk\FileUpload\Validator;

class Extension extends AbstractValidator
{
    public function valid(array $passable): bool
    {
        if ($this->file->isValid()) {
            $extension = $this->file->getClientOriginalExtension();
            $pass = in_array($extension, $passable);
            if (!$pass) {
                $this->error = 'Not allowed file extension in config file.';
            }
            return $pass;
        } else {
            $this->error = $this->file->getErrorMessage();
            return false;
        }
    }
}