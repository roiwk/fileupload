<?php

return [
    'file_upload_key' => 'file',     // 文件字段名
    'max_size'        => 2048000,    // 文件最大大小  2M
    'chunk_limit'     => 2048000,    // 分块限制      2M
    'upload_limit'    => 2048000,    // 上传限制      2M
    'response'        => 'default',  // defalut, jquery-file-upload
    'route'   =>  [
        'process'   => [
            'method' => 'get',
            'uri'    => '/process',
        ],
        'uploading' => [
            'method' => 'post',
            'uri'    => '/process',
        ],
        'delete'   => [
            'method' => 'delete',
            'uri'    => '/process',
        ],
    ],
    'validator'       => [
        \Roiwk\FileUpload\Validator\Size::class,        // 检测上传文件大小
        \Roiwk\FileUpload\Validator\MaxSize::class,     // 分片上传用, 检测原文件大小
        \Roiwk\FileUpload\Validator\Extension::class,   // 检测文件扩展名
    ],
    'storage' => [
        'filename_hash' => [
            'algo' => 'md5_file', //md5, sha1, md5_file, sha1_file
            'salt' => '',
        ],
        'store_dir' => '/path/to/store',
    ],
    'forbidden_extensions' => [
        'php', 'part', 'html', 'shtml', 'htm', 'shtm', 'xhtml', 'xml', 'js', 'jsp', 'asp',
        'java', 'py', 'sh', 'bat', 'exe', 'dll', 'cgi', 'htaccess', 'reg', 'aspx', 'vbs'
    ],

];