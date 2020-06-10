<?php

include_once __DIR__ . '/../vendor/autoload.php';

$app = new Roiwk\FileUpload\Container();

echo json_encode($app->handle());
