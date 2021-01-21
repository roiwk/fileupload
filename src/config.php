<?php

use Roiwk\FileUpload\Contacts\{RequestInterface, ResponseInterface, UploaderInterface};
use Roiwk\FileUpload\Core\{ProtoRequest, ProtoResponse};
use Roiwk\FileUpload\NameHash\{Md5};

return [

    /*
    |--------------------------------------------------------------------------
    | 上传检验与限制配置
    |--------------------------------------------------------------------------
    |
    | max_size                      最大文件大小
    | chunk_limit                   分片文件大小
    | forbidden_extensions          文件扩展名黑名单
    |
    */
    'max_size'        => 204800000,
    'chunk_limit'     => 2048000,
    'forbidden_extensions' => [
        'php', 'part', 'html', 'shtml', 'htm', 'shtm', 'xhtml', 'xml', 'js', 'jsp', 'asp',
        'java', 'py', 'sh', 'bat', 'exe', 'dll', 'cgi', 'htaccess', 'reg', 'aspx', 'vbs'
    ],

    /*
    |--------------------------------------------------------------------------
    | 请求与请求参数配置(不建议修改)
    |--------------------------------------------------------------------------
    |
    | 请求的请求方式, 路由, 参数设置
    | preprocess  预请求
    | uploading   上传
    | delete      删除
    |
    */
    'route'   =>  [
        'preprocess'   => [
            'method' => 'post',
            'uri'    => '/roiwk/upload/preprocess',
            // 'param_map' => [
            //     'resource_name' => 'filename',
            //     'resource_size' => 'size',
            // ],
        ],
        'uploading' => [
            'method' => 'post',
            'uri'    => '/roiwk/upload/uploading',
            // 'param_map' => [
            //     'sub_dir'        => 'sub_dir',
            //     'resource_name'  => 'filename',
            //     'resource_chunk' => 'chunk_file',
            //     'chunk_total'    => 'chunk_total',
            //     'chunk_index'    => 'chunk_index',
            // ],
        ],
        'delete'   => [
            'method' => 'post',
            'uri'    => '/roiwk/upload/delete',
            // 'param_map' => [
            //     'sub_dir'        => 'sub_dir',
            //     'resource_name'  => 'filename',
            // ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | 响应对象配置
    |--------------------------------------------------------------------------
    |
    | 响应对象的提供者, 默认返回json
    | 可实现 ResponseInterface, 并修改配置response_provider实现自定义响应
    |
    */

    'providers' => [

    ],

    'registers' => [
        RequestInterface::class => ProtoRequest::class,
        ResponseInterface::class => ProtoResponse::class,
        // UploaderInterface::class => ,
        // FilenameHashInterface::class =>
    ],


    /*
    |--------------------------------------------------------------------------
    | 存储配置
    |--------------------------------------------------------------------------
    |
    | store_dir                     文件存储的主目录
    | sub_dir                       子文件生成方式  date: Y-m-d  month: Y-m  year: Y
    | filename_algo                 上传文件的目录与文件名的散列算法
    | filename_prefix               上传文件的散列后文件名前缀
    | filename_suffix               上传文件的散列后文件名后缀
    |
    */
    'storage' => [
        'store_dir'       => __DIR__ . '/../tests/store',
        'sub_dir'         => 'date',
        'filename_algo'   => Md5::class,
        'filename_prefix' => '',
        'filename_suffix' => '',
    ],

];