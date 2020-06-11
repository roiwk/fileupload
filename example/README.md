# demo

## 前端

### 必需

> jquery

### 简单用法

1. 点击按钮, 实现上传

```html
    <input type="file" name="file" id="upload">
    <button id="btn">Upload</button>

    <script src="./upload.js"></script>

    <script>
        $(function(){
            var upload = new roiwkUpload({
                domain: "http://127.0.0.1"
            });
            $("#btn").on("click", function(){
                upload.upload($("#upload").prop('files')[0]);
            });
        });
    </script>
```

## 后端

1. 默认处理并返回json

```php
// index.php
include_once 'path/to/vendor/autoload.php';

$app = new Roiwk\FileUpload\Container();
echo $app->handle(true);

```

 cmd/shall 启动php的web服务(保证与前端domain配置相同即可); 或使用web服务器监听80端口

```shell
php -S 127.0.0.1:80 index.php
```
