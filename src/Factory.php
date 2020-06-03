<?php

namespace Roiwk\FileUpload;

use Roiwk\FileUpload\ConfigMapper;
use Roiwk\FileUpload\Process\{Preprocess, Uploading, Delete};
use Roiwk\FileUpload\Validator\{ForbiddenExtension, Size};
use Roiwk\FileUpload\Response\DefaultResponse;
use Roiwk\FileUpload\Exception\MakeStorageDirException;

class Factory
{
    /**
     * 配置单例
     *
     * @var ConfigMapper
     */
    public $config;

    /**
     * 路径处理器
     *
     * @var PathSolver
     */
    public $pathSolver;

    /**
     * 文件夹路径
     *
     * @var string
     */
    private $dir;

    /**
     * 进程
     *
     * @var string
     */
    private $process;

    /**
     * 请求参数数组
     *
     * @var array
     */
    private $parameter = [];

    /**
     * 上传文件对象数组
     *
     * @var array[UploadedFile]
     */
    private $files = [];

    /**
     * 校验器
     *
     * @var array
     */
    private $validator = [];

    /**
     * 进程处理提供者
     *
     * @var array
     */
    private $processProvider = [
        'preprocess' => Preprocess::class,
        'uploading'  => Uploading::class,
        'delete'     => Delete::class,
    ];

    /**
     * 响应提供者
     *
     * @var array
     */
    public static $responseProvider = [
        'default'  => DefaultResponse::class,
    ];

    /**
     * 校验器映射(表驱动)
     *
     * @var array
     */
    private $processValidator = [
        'preprocess' => [],
        'uploading'  => [],
        'delete'     => [],
    ];


    /**
     * constructor
     *
     * @param string|array|null $config   配置文件|配置数组|默认配置
     */
    public function __construct($config = null)
    {
        $this->config = ConfigMapper::getInstance($config);
        $this->init();
    }

    /**
     * 初始化
     *
     * @return void
     */
    private function init(): void
    {
        $this->setPhpIni();
        $this->initStorage();
        $this->initValidator();
    }

    /**
     * 根据请求设置参数
     *
     * @return boolean
     */
    public function filterFromGlobal(): bool
    {
        foreach($this->config->get('route') as $route => $setting) {
            if (strtoupper($setting['method']) == $_SERVER['REQUEST_METHOD']
                && $setting['uri'] == $_SERVER['PATH_INFO'] ?? $_SERVER['REQUEST_URI'] ?? $_SERVER['REDIRECT_URL']
            ) {
                $this->process = $route;
                $this->setRequestParameter();
                $route == 'uploading' && $this->setGlobalFiles();
                $this->validator = $this->processValidator[$this->process];
                return true;
            }
        }
        return false;
    }

    /**
     * 处理请求
     *
     * @return null|response
     */
    public function handle()
    {
        if (!$this->filterFromGlobal()) {
            return null;
        }
        $responseClass = $this->config->get('response_provider');
        $processClass  = $this->processProvider[$this->process];
        $response      = new $responseClass();
        $process       = new $processClass($this->pathSolver, $this->parameter, $this->validator, $this->files);
        return $response->sendResponse($process->handle());
    }

    /**
     * 设置请求参数
     *
     * @return void
     */
    private function setRequestParameter(): void
    {
        if ($this->process == 'preprocess') {
            $this->parameter = [
                'resource_name' => $_REQUEST[$this->config->get('route.preprocess.param_map.resource_name')],
                'resource_size' => $_REQUEST[$this->config->get('route.preprocess.param_map.resource_size')],
            ];
        } else if ($this->process == 'uploading') {
            $this->parameter = [
                'tmp_dir'        => $_REQUEST[$this->config->get('route.preprocess.param_map.tmp_dir')],
                'resource_chunk' => $_REQUEST[$this->config->get('route.preprocess.param_map.resource_chunk')],
                'chunk_total'    => $_REQUEST[$this->config->get('route.preprocess.param_map.chunk_total')],
                'chunk_index'    => $_REQUEST[$this->config->get('route.preprocess.param_map.chunk_index')],
            ];
        } else if ($this->process == 'delete') {
            $this->parameter = [
                'tmp_dir' => $_REQUEST[$this->config->get('route.preprocess.param_map.tmp_dir')],
            ];
        } else {
            // null
        }
    }

    /**
     * 设置请求文件
     *
     * @return void
     */
    private function setGlobalFiles(): void
    {
        $originFiles = $_FILES[$this->config->get('file_upload_key')];
        $countFiles = count($originFiles['tmp_name']);
        for ($i=0; $i < $countFiles; $i++) {
            $this->files[$i] = new UploadedFile(
                $originFiles['name'][$i], $originFiles['type'][$i], $originFiles['tmp_name'][$i],
                $originFiles['size'][$i], $originFiles['error'][$i]
            );
        }
    }


    /**
     * php_ini
     *
     * @return void
     */
    private function setPhpIni(): void
    {
        $phpIniConfig = $this->config->get('php_ini_set');
        foreach ($phpIniConfig as $key => $value) {
            ini_set($key, $value);
        }
    }

    /**
     * 存储文件夹初始化
     *
     * @return void
     */
    private function initStorage(): void
    {
        $dir = $this->config->get('storage.store_dir');
        $subdir = $this->config->get('storage.sub_dir');
        if ($subdir == 'date') {
            $dir = $dir . '/' . date('Y-m-d');
        } else if ($subdir == 'month') {
            $dir = $dir . '/' . date('Y-m');
        } else if ($subdir == 'year') {
            $dir = $dir . '/' . date('Y');
        } else {
            $dir = $dir;
        }
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0766, true)) {
                throw new MakeStorageDirException();
            }
        }
        $this->dir = $dir;
        $algo = $this->config->get('storage.filename_algo');
        $this->pathSolver = new PathSolver(
            $this->dir, new $algo(),
            $this->config->get('storage.filename_prefix'), $this->config->get('storage.filename_suffix')
        );
    }

    /**
     * 校验器初始化
     *
     * @return void
     */
    private function initValidator(): void
    {
        $this->processValidator = [
            'preprocess' => [
                new ForbiddenExtension($this->config->get('forbidden_extensions')),
                new Size($this->config->get('max_size')),
            ],
            'uploading'  => [
                new Size($this->config->get('chunk_limit')),
            ],
            'delete'     => [],
        ];
    }

}
