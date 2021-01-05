<?php

$uploadRoute = \Roiwk\FileUpload\ConfigMapper::get('route');

$router->$uploadRoute['preprocess']['method']($uploadRoute['preprocess']['uri'], '\Roiwk\FileUpload\Lumen\UploadController@preprocess');
$router->$uploadRoute['uploading']['method']($uploadRoute['uploading']['uri'], '\Roiwk\FileUpload\Lumen\UploadController@uploading');
$router->$uploadRoute['delete']['method']($uploadRoute['delete']['uri'], '\Roiwk\FileUpload\Lumen\UploadController@delete');

