<?php

namespace Roiwk\FileUpload;

use Roiwk\FileUpload\ConfigMapper;
use Symfony\Component\HttpFoundation\Request;

class UploadHandler
{
    public $config;
    public $request;

    /**
     * @var array
     */
    public $files;

    /**
     * constructor
     *
     * @param string|array|null $config   配置文件|配置数组|默认配置
     */
    public function __construct(Request $request, $config = null)
    {
        $this->request = $request;
        $this->config = ConfigMapper::getInstance($config);
        $this->files = $this->request->files->get($this->config->get('file_upload_key'));
        $this->init();
    }

    /**
     * 初始化
     *
     * @return void
     */
    private function init(): void
    {
        // php_ini
        $phpIniConfig = $this->config->get('php_ini_set');
        foreach ($phpIniConfig as $key => $value) {
            ini_set($key, $value);
        }
    }

    /**
     * 处理请求
     *
     * @return string|null
     */
    public function handle(): ?string
    {
        foreach($this->config->get('route') as $route => $setting) {
            if (strtoupper($setting['method']) == $this->request->getMethod() && $setting['uri'] == $this->request->getPathInfo()) {
                return $this->$route();
            }
        }
        return null;
    }

    public function preprocess(): ?string
    {
        if ($this->config->get('test_mode')) {
            return 'preprocess';
        }
    }

    public function uploading(): ?string
    {
        if ($this->config->get('test_mode')) {
            return 'uploading';
        }
    }

    public function delete(): ?string
    {
        if ($this->config->get('test_mode')) {
            return 'delete';
        }
    }

}
