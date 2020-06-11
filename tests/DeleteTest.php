<?php


use PHPUnit\Framework\TestCase;
use Roiwk\FileUpload\ConfigMapper;
use Roiwk\FileUpload\Container as App;
use Roiwk\FileUpload\Response\ResponseInterface;

class DeleteTest extends TestCase
{
    protected function setUp(): void
    {
        // delete
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $_SERVER['SCRIPT_NAME'] = '/process';
    }

    public function testPassDelete()
    {
        $_REQUEST = [
            'sub_dir'  => '20200605',
            'filename' => 'test_3M+.png',
        ];

        $delete = new App();
        $handle = $delete->handle();

        $this->assertSame(0, $handle['error'], json_encode($handle));
    }



}