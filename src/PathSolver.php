<?php

namespace Roiwk\FileUpload;

use Roiwk\FileUpload\NameHash\HashInterface;

class PathSolver
{
    /**
     * @var HashInterface
     */
    private $hash;

    /**
     * @var string
     */
    private $dir;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $suffix;

    public function __construct(string $dir, HashInterface $hash, string $prefix, string $suffix)
    {
        $this->dir    = $dir;
        $this->hash   = $hash;
        $this->prefix = $prefix;
        $this->suffix = $suffix;
    }

    public function getFilename(string $clientFilename, bool $withDir = false): string
    {
        $filenameHash = call_user_func_array([$this->hash, 'hash'], [$clientFilename, $this->prefix, $this->suffix]);
        return $withDir ? $this->dir . $filenameHash : $filenameHash;
    }
}