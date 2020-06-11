# 大文件分片上传

php实现的大文件分片上传, 单文件上传.

请求:

--|前端|后端
:--:|:--|:--
1|预请求|返回分片配置信息,与预校验(文件大小,扩展名验证)|
2|分片上传文件|返回上传状态,为最后一个分片时,进行文件合并操作|
3|删除请求|删除服务器文件|

## 前置需求

1. php.ini 支持文件上传

    ```ini
    file_uploads = On
    ```

2. [按需配置] php.ini
    > max_execution_time = 300
    >
    > memory_limit = 500M
    >
    > post_max_size = 4G
    >
    > upload_max_filesize = 4G
    >
    > max_file_uploads = 50

3. [按需配置] nginx
    > sendfile       on;
    >
    > sendfile_max_chunk 2M;
    >
    > client_body_timeout 120;
    >
    > client_body_buffer_size 64k;
    >
    > client_max_body_size 300m;

## 安装

> composer install roiwk/fileupload

## TODO

- [x] 上传服务端
- [x] 上传客户端
- [ ] Lumen ServerProvider

## 开源许可协议

MIT 详见[LICENSE](./LICENSE)
