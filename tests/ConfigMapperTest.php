<?php

use PHPUnit\Framework\TestCase;
use Roiwk\FileUpload\ConfigMapper;

class ConfigMapperTest extends TestCase
{
    public function testInitConfig()
    {
        $config = ConfigMapper::getInstance([
            'storage' => [
                'store_dir' => '/test/path/to/store'
            ]
        ]);

        $this->assertSame('/test/path/to/store', $config::get('storage.store_dir'));
    }

    public function testUniqueness()
    {
        $firstCall = ConfigMapper::getInstance();
        $secondCall = ConfigMapper::getInstance();

        $this->assertInstanceOf(ConfigMapper::class, $firstCall);
        $this->assertSame($firstCall, $secondCall);
    }

    public function testGetConfig()
    {
        $this->assertSame('file', ConfigMapper::get('file_upload_key'));
        $this->assertSame('md5_file', ConfigMapper::get('storage.filename_hash.algo'));
    }


    public function testSetConfig()
    {
        ConfigMapper::set('storage.store_dir', '/test');

        $this->assertSame('/test', ConfigMapper::get('storage.store_dir'));
    }

    public function testAppendConfig()
    {
        ConfigMapper::append('storage', ['test' => 1]);
        ConfigMapper::append('forbidden_extensions', 'txt');

        $this->assertEquals(1, ConfigMapper::get('storage.test'));
        $this->assertTrue(in_array('txt', ConfigMapper::get('forbidden_extensions')));

    }
}