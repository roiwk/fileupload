<?php

use PHPUnit\Framework\TestCase;
use Roiwk\FileUpload\ConfigMapper;
use Roiwk\FileUpload\Factory;

class RequestTest extends TestCase
{
    protected function setUp(): void
    {
        $_FILES = [
            'file' => [
                'name' => [
                   'test.jpg',
                ],
                'type' => [
                   'image/jpeg',
                ],
                'tmp_name' => [
                   __DIR__ . '/test.jpg',
                ],
                'error' => [
                   0,
                ],
                'size' => [
                   4410,
                ],
             ]
        ];
    }

    public function testPreprocessHandler()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/process';

        $handler = new Factory();
        $handler->config->set('test_mode', true);

        // $this->assertSame('preprocess', $handler->handle());
    }

    public function testUploadingHandler()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['PATH_INFO'] = '/process';

        $handler = new Factory();
        $handler->config->set('test_mode', true);

        // $this->assertSame('uploading', $handler->handle());
    }

    public function testDeleteHandler()
    {
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $_SERVER['PATH_INFO'] = '/process';

        $handler = new Factory();
        $handler->config->set('test_mode', true);

        // $this->assertSame('delete', $handler->handle());
    }

    public function testErrorHandler()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/test';
        $_SERVER['REQUEST_URI'] = '/test';

        $handler = new Factory();
        $handler->config->set('test_mode', true);

        // $this->assertSame(null, $handler->handle());
    }
}