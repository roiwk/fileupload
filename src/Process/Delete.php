<?php

namespace Roiwk\FileUpload\Process;

class Delete extends AbstractProcess
{
    public function handle(): array
    {
        $this->clearDir($this->dir);
        @rmdir($this->dir);
        return [
            'error'    => $this->error,
            'err_msg'  => $this->errMsg,
        ];
    }

    public function clearDir($path = null)
    {
        if (is_dir($path)) {
            $p = scandir($path);
            foreach ($p as $value) {
                if ($value != '.' && $value != '..') {
                    if (is_dir($path.'/'.$value)) {
                        $this->clearDir($path.'/'.$value);
                        rmdir($path.'/'.$value);
                    } else {
                        unlink($path.'/'.$value);
                    }
                }
            }
        }
    }

}