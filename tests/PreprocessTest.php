<?php

use PHPUnit\Framework\TestCase;
use Roiwk\FileUpload\ConfigMapper;
use Roiwk\FileUpload\App;
use Roiwk\FileUpload\Response\ResponseInterface;

class PreprocessTest extends TestCase
{
    protected function setUp(): void
    {
        // preprocess
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/process';
    }

    public function testPassPreprocess()
    {
        $_REQUEST = [
            'filename' => 'test.jpg',
            'size'     => 1024000,
        ];

        $preprocess = new App();
        $preprocess->filterFromGlobal();
        $handle = $preprocess->processHandler->handle();

        $this->assertSame(0, $handle['error']);
        $this->assertSame($preprocess->pathSolver->getFilename($_REQUEST['filename']), $handle['tmp_dir'], json_encode($handle));
    }

    public function testCantPassExtensionPreprocess()
    {
        $_REQUEST = [
            'filename' => 'test.php',
            'size'     => 2048000,
        ];

        $preprocess = new App();
        $preprocess->filterFromGlobal();
        $handle = $preprocess->processHandler->handle();

        $this->assertSame(1, $handle['error']);
        $this->assertSame('Not allowed file extension in config file.', $handle['err_msg'], json_encode($handle));
    }

    public function testCantPassSizePreprocess()
    {
        $_REQUEST = [
            'filename' => 'test.jpg',
            'size'     => 2048000011,
        ];

        $preprocess = new App();
        $preprocess->filterFromGlobal();
        $handle = $preprocess->processHandler->handle();

        $this->assertSame(1, $handle['error']);
        $this->assertSame('The uploading file exceeds the file size limit defined in config file.', $handle['err_msg'], json_encode($handle));
    }
}