<?php

use PHPUnit\Framework\TestCase;
use Roiwk\FileUpload\Container as App;

class UploadingTest extends TestCase
{
    protected function setUp(): void
    {
        // uploading
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['SCRIPT_NAME'] = '/process';
    }

    public function testPassUploading()
    {
        $_FILES = [
            'chunk_file' => [
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
            'chunk_file' => [
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
            'chunk_total'    => 2,
            'chunk_index'    => 2,
        ];

        $uploading = new App();
        $handle = $uploading->handle();

        $this->assertSame(0, $handle['error'], json_encode($handle));
    }

}