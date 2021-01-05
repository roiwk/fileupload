<?php

namespace Roiwk\FileUpload\Lumen;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller;
use Roiwk\FileUpload\Uploader;

class UploadController extends Controller
{
    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * 预请求
     *
     * @param Request $request
     * @return void
     */
    public function preprocess(Request $request)
    {
        $this->validate($request, [
            $this->uploader->config->get('route.preprocess.param_map.resource_name') => 'required|string',
            $this->uploader->config->get('route.preprocess.param_map.resource_size') => 'required|integer',
        ]);

        $result = $this->uploader->preprocess($request->all());

        return Response::create(json_encode($result, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 上传
     *
     * @param Request $request
     * @return void
     */
    public function uploading(Request $request)
    {
        $this->validate($request, [
            $this->uploader->config->get('route.preprocess.param_map.resource_name') => 'required|string',
            $this->uploader->config->get('route.preprocess.param_map.resource_size') => 'required|integer',
        ]);

        $result = $this->uploader->uploading($request->all());

        return Response::create(json_encode($result, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 删除
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
            $this->uploader->config->get('route.preprocess.param_map.resource_name') => 'required|string',
            $this->uploader->config->get('route.preprocess.param_map.resource_size') => 'required|integer',
        ]);

        $result = $this->uploader->delete($request->all());

        return Response::create(json_encode($result, JSON_UNESCAPED_UNICODE));
    }
}