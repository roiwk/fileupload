<?php

namespace Roiwk\FileUpload;

use Roiwk\FileUpload\ConfigMapper;
use Symfony\Component\HttpFoundation\Request;

class UploadHandler
{
    /**
     * constructor
     *
     * @param string|array|null $config   配置文件|配置数组|默认配置
     */
    public function __construct($config = null)
    {
        $this->config = ConfigMapper::getInstance($config);
        $this->request = Request::createFromGlobals();
    }

    public function handle()
    {

    }

}
