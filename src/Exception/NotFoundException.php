<?php

namespace Roiwk\FileUpload\Exception;

use Psr\Container\NotFoundExceptionInterface;
use \RuntimeException;

class NotFoundException extends RuntimeException implements NotFoundExceptionInterface
{

}