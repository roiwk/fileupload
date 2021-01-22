<?php

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
    | 请求的请求方式POST, 路由
    | preprocess  预请求
    | uploading   上传
    | delete      删除
    |
    */
    'route_preprocess' => '/roiwk/upload/preprocess',
    'route_uploading' => '/roiwk/upload/uploading',
    'route_delete' => '/roiwk/upload/delete',
    'route'   =>  [
        'preprocess'   => [
            'method' => 'post',
            'uri'    => '/roiwk/upload/preprocess',
        ],
        'uploading' => [
            'method' => 'post',
            'uri'    => '/roiwk/upload/uploading',
        ],
        'delete'   => [
            'method' => 'post',
            'uri'    => '/roiwk/upload/delete',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | 存储配置
    |--------------------------------------------------------------------------
    |
    | store_dir                     文件存储的主目录
    |
    */
    'store_dir' => __DIR__ . '/../tests/store',
    'buffer_dir' => __DIR__ . '/../tests/buffer',

];