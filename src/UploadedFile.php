<?php

namespace Roiwk\FileUpload;

class UploadedFile extends \SplFileInfo
{
    /**
     * @var string
     */
    private $clientFilename;

    /**
     * @var string
     */
    private $clientMime;

    /**
     * @var string
     */
    private $clientExtension;

    /**
     * @var int
     */
    private $clientSize;

    /**
     * 0 为成功
     * 详情见  文件上传->错误信息常量说明
     *
     * @var int
     */
    private $error;

    public function __construct(string $name, string $type, string $tmp_name, int $size, int $error = 0)
    {
        $this->clientFilename  = $name;
        $this->clientMime      = $type;
        $this->clientExtension = pathinfo($name, PATHINFO_EXTENSION);
        $this->clientSize      = $size;
        $this->error           = $error;
        return parent::__construct($tmp_name);
    }

    public function getClientFilename(): string
    {
        return $this->clientFilename;
    }

    public function getClientExtension(): string
    {
        return $this->clientExtension;
    }

    public function getClientMime(): string
    {
        return $this->clientMime;
    }

    public function getClientSize(): int
    {
        return $this->clientSize;
    }

    public function getErrorMsg(): string
    {
        $upload_errors = [
            UPLOAD_ERR_OK         => 'There is no error, the file uploaded with success.',
            UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
            UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Cannot write to target directory. Please fix CHMOD.',
            UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
        ];
        return $upload_errors[$this->error];
    }

}