<?php

namespace Roiwk\FileUpload;

use Roiwk\FileUpload\ConfigMapper;
use Roiwk\FileUpload\Process\{Preprocess, Uploading, Delete};
use Roiwk\FileUpload\Validator\{ForbiddenExtension, Size};
use Roiwk\FileUpload\Exception\MakeStorageDirException;

class Container
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
    public $dir;

    /**
     * 子文件夹路径
     *
     * @var string
     */
    public $subdir = '';

    /**
     * 进程
     *
     * @var string
     */
    public $process;

    /**
     * 请求参数数组
     *
     * @var array
     */
    public $parameter = [];

    /**
     * 上传文件对象
     *
     * @var UploadedFile
     */
    public $file;

    /**
     * 校验器
     *
     * @var array
     */
    public $validator = [];

    /**
     * 处理对象
     *
     * @var AbstractProcess
     */
    public $processHandler;

    /**
     * 响应对象
     *
     * @var ResponseInterface
     */
    public $responseHandler;

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
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['PATH_INFO'] ?? $_SERVER['SCRIPT_NAME'] ?? $_SERVER['REQUEST_URI'] ?? $_SERVER['REDIRECT_URL'];
        foreach($this->config->get('route') as $route => $setting) {
            if (strtoupper($setting['method']) == $method && $setting['uri'] == $uri) {
                $this->process = $route;
                $this->setRequestParameter();
                $this->setGlobalFiles();
                $this->validator = $this->processValidator[$this->process];

                $processClass          = $this->processProvider[$this->process];
                $responseClass         = $this->config->get('response_provider');
                $this->processHandler  = new $processClass($this);
                $this->responseHandler = new $responseClass();
                return true;
            }
        }
        return false;
    }

    /**
     * 处理请求
     *
     * @return null|array|response
     */
    public function handle($withResponse = false)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
        header('Access-Control-Allow-Headers: Origin,Accept, X-Requested-With, Content-Type,X-CSRF-TOKEN');
        header('Access-Control-Allow-Credentials: true');
        // CORS -- option
        // if (strtoupper($_SERVER['REQUEST_METHOD']) == 'OPTIONS'){
        //     return null;
        // }
        if (!$this->filterFromGlobal()) {
            return null;
        }
        if ($withResponse) {
            return $this->responseHandler->sendResponse($this->processHandler->handle());
        } else {
            return $this->processHandler->handle();
        }
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
                'resource_name' => $_REQUEST[$this->config->get('route.preprocess.param_map.resource_name')] ?? '',
                'resource_size' => $_REQUEST[$this->config->get('route.preprocess.param_map.resource_size')] ?? 0,
            ];
        } else if ($this->process == 'uploading') {
            $this->parameter = [
                'sub_dir'        => $_REQUEST[$this->config->get('route.uploading.param_map.sub_dir')] ?? '',
                'resource_name'  => $_REQUEST[$this->config->get('route.uploading.param_map.resource_name')] ?? '',
                'chunk_total'    => $_REQUEST[$this->config->get('route.uploading.param_map.chunk_total')] ?? 0,
                'chunk_index'    => $_REQUEST[$this->config->get('route.uploading.param_map.chunk_index')] ?? 0,
            ];
        } else if ($this->process == 'delete') {
            $this->parameter = [
                'sub_dir'       => $_REQUEST[$this->config->get('route.delete.param_map.sub_dir')] ?? '',
                'resource_name' => $_REQUEST[$this->config->get('route.delete.param_map.resource_name')] ?? '',
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
        if ($this->process == 'preprocess') {
            $this->file = new UploadedFile($this->parameter['resource_name'], '', $this->parameter['resource_name'], $this->parameter['resource_size']);
        } else if ($this->process == 'uploading') {
            $originFiles = $_FILES[$this->config->get('route.uploading.param_map.resource_chunk')];
            $this->file = new UploadedFile(
                $this->parameter['resource_name'], $originFiles['type'], $originFiles['tmp_name'],
                $originFiles['size'], $originFiles['error']
            );
        } else if ($this->process == 'delete') {
            $this->file = new UploadedFile($this->parameter['resource_name'], '', $this->parameter['resource_name'], 0);
        } else {
            // null
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
        $subConfig = $this->config->get('storage.sub_dir');
        $sub = [
            'date'  => 'Ymd',
            'month' => 'Ym',
            'year'  => 'Y',
        ];
        if (isset($sub[$subConfig])) {
            $this->subdir = date($sub[$subConfig]);
        } else {
            $this->subdir = '';
        }

        if (!is_dir($dir)) {
            if (!mkdir($dir, 0766, true)) {
                throw new MakeStorageDirException();
            }
        }
        $this->dir = $dir;
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
