# demo

## 1.前端

### 1.1必需

> jquery

jquery用于实现ajax

### 1.2简单用法

点击按钮, 实现上传

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

## 2.后端

```php
// index.php
include_once 'path/to/vendor/autoload.php';

$app = new Roiwk\FileUpload\Container();
echo $app->handle(true);

```

启动php的web服务或使用web服务器(保证前后端domain配置相同即可)

```shell
php -S 127.0.0.1:80 index.php
```
