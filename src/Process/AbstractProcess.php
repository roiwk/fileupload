<?php

namespace Roiwk\FileUpload\Process;

use Roiwk\FileUpload\PathSolver;

abstract class AbstractProcess
{

    /**
     * @var array
     */
    protected $parameter;

    /**
     * @var array[AbstractValidator]
     */
    protected $validator;

    /**
     * @var array[UploadedFile]
     */
    protected $files;

    /**
     * @var array[PathSolver]
     */
    protected $pathSolver;

    /**
     * construct
     *
     * @param array $parameter   请求参数
     * @param array $validator   检验
     * @param array $files       文件
     */
    public function __construct(PathSolver $pathSolver, array $parameter, array $validator = [], array $files = [])
    {
        $this->pathSolver = $pathSolver;
        $this->parameter  = $parameter;
        $this->validator  = $validator;
        $this->files      = $files;
    }

    abstract public function handle(): ?array;
}