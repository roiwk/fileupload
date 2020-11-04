<?php

include_once __DIR__ . '/../vendor/autoload.php';

$app = new Roiwk\FileUpload\Uploader();

echo $app->handle(true);
