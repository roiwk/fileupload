<?php

namespace Roiwk\FileUpload\Core\Handler;

use Roiwk\FileUpload\Core\Config;
use Roiwk\FileUpload\Core\Parameter\DeleteParam;
use Roiwk\FileUpload\Core\PathSolver;

class Delete
{
    private $param;

    public function __construct(DeleteParam $param, PathSolver $pathSolver)
    {
        $this->param = $param;
        $this->pathSolver = $pathSolver;
    }

    public function handle(): array
    {
        $dir = $this->pathSolver->bufferPath($this->param->filename());
        $this->clearDir($dir) && @rmdir($dir);
        return [
            'error'      => 0,
            'err_msg'    => '',
        ];
    }

    public function clearDir($path = null)
    {
        if (is_dir($path)) {
            $p = scandir($path);
            foreach ($p as $value) {
                if ($value != '.' && $value != '..') {
                    if (is_dir($path . '/' . $value)) {
                        $this->clearDir($path . '/' . $value);
                        rmdir($path . '/' . $value);
                    } else {
                        unlink($path . '/' . $value);
                    }
                }
            }
        }
    }
}
