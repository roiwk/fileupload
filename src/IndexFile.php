<?php

namespace Roiwk\FileUpload;


class IndexFile
{
    /**
     * @var string
     */
    public $dir;

    /**
     * @var string
     */
    public $filename;

    /**
     * @var int
     */
    public $total;

    /**
     * @var int
     */
    public $current;

    /**
     * @var bool
     */
    public $isFinish = false;

    /**
     * @var array
     */
    public $indexArray = [];

    /**
     * new IndexFile('path/to/save')
     *
     * @param string $dir
     */
    public function __construct(string $dir)
    {
        $this->dir = $dir;
        $this->filename = $dir . DIRECTORY_SEPARATOR . 'index';
        if (file_exists($this->filename)) {
            $serialized = unserialize(file_get_contents($this->filename));
            $this->dir        = $serialized->dir;
            $this->filename   = $serialized->filename;
            $this->setChunk($serialized->current, $serialized->total);
            $this->indexArray = $serialized->indexArray;
        }
    }

    public function setChunk(int $current, int $total): self
    {
        $this->total = $total;
        $this->current = $current;
        return $this;
    }

    public function append(string $chunkFilename): self
    {
        $this->indexArray[$this->current] = $chunkFilename;
        if ($this->total == count($this->indexArray)) {
            $this->isFinish = true;
        }
        return $this;
    }

    public function __destruct()
    {
        if (!$this->isFinish) {
            file_put_contents($this->filename, serialize($this), LOCK_EX);
        } else {
            @unlink($this->filename);
        }
    }
}