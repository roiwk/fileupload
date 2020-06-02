<?php

return [
    'test_mode'           => true,
    'php_ini_set'         => [      // ini_set
        'max_execution_time'  => 300,
        'memory_limit'        => '500M',
        'memory_limit'        => '500M',
        'post_max_size'       => '40M',
        'upload_max_filesize' => '40M',
        'max_file_uploads'    => 20,
    ],
    'file_upload_key' => 'file',     // 文件字段名
    'max_size'        => 20480000,   // 文件最大大小  20M
    'chunk_limit'     => 2048000,    // 分块限制      2M
    'response'        => 'default',  // defalut, jquery-file-upload
    'route'   =>  [
        'preprocess'   => [
            'method' => 'get',
            'uri'    => '/process',
            'param_map' => [
                'resource_name' => 'filename',
                'resource_size' => 'size',
                'group'         => 'group',
            ],
        ],
        'uploading' => [
            'method' => 'post',
            'uri'    => '/process',
            'param_map' => [
                'tmp_dir'        => 'tmp_dir',
                'resource_chunk' => 'chunk_file',
                'chunk_total'    => 'chunk_total',
                'chunk_index'    => 'chunk_index',
                'group'          => 'group',
            ],
        ],
        'delete'   => [
            'method' => 'delete',
            'uri'    => '/process',
            'param_map' => [
                'tmp_dir' => 'tmp_dir',
                'group'   => 'group',
            ],
        ],
    ],
    'storage' => [
        'store_dir' => '/path/to/store',
        'filename_hash' => [
            'algo'   => 'md5',   // md5, sha1
            'prefix' => '',      // 散列之后的前缀
            'suffix' => '',      // 散列之后的后缀
        ],
    ],
    'forbidden_extensions' => [
        'php', 'part', 'html', 'shtml', 'htm', 'shtm', 'xhtml', 'xml', 'js', 'jsp', 'asp',
        'java', 'py', 'sh', 'bat', 'exe', 'dll', 'cgi', 'htaccess', 'reg', 'aspx', 'vbs'
    ],

];