<?php

namespace Roiwk\FileUpload\Validator;

class ForbiddenExtension extends AbstractValidator
{
    /**
     * @var array
     */
    protected $passable;

    public function __construct(array $passable)
    {
        $this->passable = $passable;
    }

    public function valid($extension): bool
    {
        $pass = !in_array($extension, $this->passable);
        $this->error = $pass;
        if (!$pass) {
            $this->errMsg = 'Not allowed file extension in config file.';
        }
        return $pass;
    }
}