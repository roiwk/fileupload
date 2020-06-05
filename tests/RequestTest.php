<?php

use PHPUnit\Framework\TestCase;
use Roiwk\FileUpload\ConfigMapper;
use Roiwk\FileUpload\Container as App;
use Roiwk\FileUpload\Response\ResponseInterface;

class RequestTest extends TestCase
{
   protected function setUp(): void
   {
      $_FILES = [
         'file' => [
            'name'     => 'test.jpg',
            'type'     => 'image/jpeg',
            'tmp_name' => __DIR__ . 'file/test.jpg',
            'error'    => 0,
            'size'     => 4410,
         ]
      ];
   }

    public function testBingoProcess()
    {
        // preprocess
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/process';
        $preprocess = new App();
        $this->assertTrue(is_array($preprocess->handle()));

        // uploading
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/process';
        $uploading = new App();
        $this->assertTrue(is_array($uploading->handle()));

        // delete
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $_SERVER['REQUEST_URI'] = '/process';
        $delete = new App();
        $this->assertTrue(is_array($delete->handle()));
    }

    public function testNullProcess()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/test';
        $_SERVER['REQUEST_URI'] = '/test';

        $handler = new App();
        $this->assertSame(null, $handler->handle());
    }
}