<?php

include_once __DIR__ . '/../vendor/autoload.php';

$app = new Roiwk\FileUpload\Container();

echo $app->handle(true);
