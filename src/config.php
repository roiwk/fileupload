<?php

use Roiwk\FileUpload\NameHash\{Md5};
use Roiwk\FileUpload\Response\DefaultResponse;

return [
    'test_mode'           => true,

    'php_ini_set'         => [
        'max_execution_time'  => 300,
        'memory_limit'        => '500M',
        'post_max_size'       => '40M',
        'upload_max_filesize' => '40M',
        'max_file_uploads'    => 20,
    ],

    'max_size'        => 20480000,   // 文件最大大小  20M
    'chunk_limit'     => 2048000,    // 分块限制      2M
    'forbidden_extensions' => [      // 文件扩展名黑名单
        'php', 'part', 'html', 'shtml', 'htm', 'shtm', 'xhtml', 'xml', 'js', 'jsp', 'asp',
        'java', 'py', 'sh', 'bat', 'exe', 'dll', 'cgi', 'htaccess', 'reg', 'aspx', 'vbs'
    ],

    'file_upload_key' => 'file',     // 文件字段名

    'route'   =>  [   // 请求
        'preprocess'   => [
            'method' => 'get',
            'uri'    => '/process',
            'param_map' => [
                'resource_name' => 'filename',
                'resource_size' => 'size',
            ],
        ],
        'uploading' => [
            'method' => 'post',
            'uri'    => '/process',
            'param_map' => [
                'sub_dir'        => 'sub_dir',
                'resource_name'  => 'filename',
                'resource_chunk' => 'chunk_file',
                'chunk_total'    => 'chunk_total',
                'chunk_index'    => 'chunk_index',
            ],
        ],
        'delete'   => [
            'method' => 'delete',
            'uri'    => '/process',
            'param_map' => [
                'sub_dir'        => 'sub_dir',
                'resource_name'  => 'filename',
            ],
        ],
    ],

    'response_provider' => DefaultResponse::class,  // defalut

    'storage' => [
        'store_dir'       => __DIR__ . '/../tests/store',
        'sub_dir'         => 'date',            //date, month, year
        'filename_algo'   => Md5::class,
        'filename_prefix' => '',                 // 散列之后的前缀
        'filename_suffix' => '',                 // 散列之后的后缀
    ],

];