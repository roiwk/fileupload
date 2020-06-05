<?php

use PHPUnit\Framework\TestCase;
use Roiwk\FileUpload\ConfigMapper;
use Roiwk\FileUpload\Container as App;
use Roiwk\FileUpload\Response\ResponseInterface;

class UploadingTest extends TestCase
{
    protected function setUp(): void
    {
        // uploading
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/process';
    }

    public function testCantPassSizePreprocess()
    {
        $_FILES = [
            'file' => [
               'name'     => 'test_3M+.png',
               'type'     => 'image/png',
               'tmp_name' => __DIR__ . '/file/test_3M+.png',
               'error'    => 0,
               'size'     => 3991629,
            ]
        ];
        $_REQUEST = [
            'filename'       => 'test_3M+.png',
            'resource_chunk' => fread(fopen(__DIR__ . '/file/test_3M+.png', 'r'), 2048001),
            'chunk_total'    => 2,
            'chunk_index'    => 1,
        ];

        $uploading = new App();
        $handle = $uploading->handle();

        $this->assertSame(1, $handle['error'], json_encode($handle));
    }

    public function testPassPreprocess()
    {
        $_FILES = [
            'file' => [
               'name'     => 'test_3M+.png',
               'type'     => 'image/png',
               'tmp_name' => __DIR__ . '/file/test_3M+_1',
               'error'    => 0,
               'size'     => filesize(__DIR__ . '/file/test_3M+_1'),
            ]
         ];
        $_REQUEST = [
            'sub_dir'        => '20200605',
            'filename'       => 'test_3M+.png',
            'chunk_file'     => fread(fopen($_FILES['file']['tmp_name'], 'r'), filesize($_FILES['file']['tmp_name'])),
            'chunk_total'    => 2,
            'chunk_index'    => 1,
        ];

        $uploading = new App();
        $handle = $uploading->handle();

        $this->assertSame(0, $handle['error'], json_encode($handle));
    }

    // public function testCantPassSizePreprocess()
    // {
    //     $_REQUEST = [
    //         'filename' => 'test.jpg',
    //         'size'     => 2048000011,
    //     ];

    //     $uploading = new App();
    //     $handle = $uploading->handle();

    //     $this->assertSame(1, $handle['error']);
    //     $this->assertSame('The uploading file exceeds the file size limit defined in config file.', $handle['err_msg'], json_encode($handle));
    // }
}