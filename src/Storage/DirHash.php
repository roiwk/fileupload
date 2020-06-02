<?php

namespace Roiwk\FileUpload\Storage;

use Roiwk\FileUpload\Exception\HashAlgoNotFundException;

class DirHash
{
    public function md5($str): string
    {
        return md5($str);
    }

    public function sha1($str): string
    {
        return sha1($str);
    }

    /**
     * 扩展散列算法
     * [
     *      'test_hash' => $HashClassObj,
     * ]
     *
     * @var array
     */
    public static $extend;

    public static function extend(string $key, HashInterface $obj)
    {
        self::$extend[$key] = $obj;
    }

    public function __callStatic($name, $arguments)
    {
        if (method_exists($this, $name)) {
            $callObj = $this;
        } else if (isset(self::$extend[$name])) {
            $callObj = self::$extend[$name];
        } else {
            throw new HashAlgoNotFundException();
        }
        return call_user_func_array([$callObj, $name], $arguments);
    }
}
