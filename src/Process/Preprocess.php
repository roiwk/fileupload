<?php

namespace Roiwk\FileUpload\Process;

class Preprocess extends AbstractProcess
{
    public function handle(): ?array
    {
        $result = [];
        foreach($this->files as $file){

        }

        return $result;
    }

    private function createContent(string $tmp_dir, int $max_size): array
    {
        return [
            'tmp_dir' => $this->pathSolver->getFilename(''),
            // ''
        ];
    }
}