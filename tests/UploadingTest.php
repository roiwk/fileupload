<?php

use PHPUnit\Framework\TestCase;
use Roiwk\FileUpload\Container as App;

class UploadingTest extends TestCase
{
    protected function setUp(): void
    {
        // uploading
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/process';
    }

    public function testCantPassSizeUploading()
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

    public function testPassUploading()
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

    public function testFinishUploading()
    {
        $_FILES = [
            'file' => [
               'name'     => 'test_3M+.png',
               'type'     => 'image/png',
               'tmp_name' => __DIR__ . '/file/test_3M+_2',
               'error'    => 0,
               'size'     => filesize(__DIR__ . '/file/test_3M+_2'),
            ]
         ];
        $_REQUEST = [
            'sub_dir'        => '20200605',
            'filename'       => 'test_3M+.png',
            'chunk_file'     => fread(fopen($_FILES['file']['tmp_name'], 'r'), filesize($_FILES['file']['tmp_name'])),
            'chunk_total'    => 2,
            'chunk_index'    => 2,
        ];

        $uploading = new App();
        $handle = $uploading->handle();

        $this->assertSame(0, $handle['error'], json_encode($handle));
    }

}