<?php

namespace Roiwk\FileUpload\Validator;

class Mimetype extends AbstractValidator
{
    /**
     * @var array
     */
    protected $passable;

    public function __construct(array $passable)
    {
        $this->passable = $passable;
    }

    public function valid($mime): bool
    {
        $this->error = $pass = in_array($mime, $this->passable);
        if (!$pass) {
            $this->errMsg = 'Not allowed file mime type in config file.';
        }
        return $pass;
    }
}