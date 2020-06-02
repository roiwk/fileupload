<?php

namespace Roiwk\FileUpload;

final class ConfigMapper
{
    /**
     * @var static
     */
    private static $instance = null;

    /**
     * 获取实例
     *
     * @return static
     */
    public static function getInstance($config = null): ConfigMapper
    {
        if (static::$instance === null) {
            static::$instance = new static();
            $defaultConfig = require_once __DIR__ . '/config.php';
            if (is_array($config)) {
                (static::$instance)->config = array_replace_recursive($defaultConfig, $config);
            } else if (is_string($config) && is_file($config)) {
                $load = require_once $config;
                if (!is_array($load)) {
                    throw new \InvalidArgumentException('config file should be array return.');
                }
                (static::$instance)->config = array_replace_recursive($defaultConfig, $load);
            } else {
                (static::$instance)->config = $defaultConfig;
            }
        }

        return static::$instance;
    }

    public static function get($property = null, $default = null)
    {
        $value = (self::getInstance())->config;
        if ($property !== null) {
            foreach (explode('.', $property) as $segment) {
                if (isset($value[$segment])) {
                    $value = $value[$segment];
                } else {
                    return $default;
                }
            }
        }
        return $value;
    }

    public static function append($property, $value): void
    {
        $config = &(self::getInstance())->config;
        foreach (explode('.', $property) as $segment) {
            if (isset($config[$segment])) {
                $config = &$config[$segment];
            }
        }
        if (is_array($config)) {
            if (!is_array($value)) {
                array_push($config, $value);
            } else {
                $config = array_merge($config, $value);
            }
        } else {
            return ;
        }
    }

    public static function set($property, $value): void
    {
        $config = &(self::getInstance())->config;
        foreach (explode('.', $property) as $segment) {
            if (isset($config[$segment])) {
                $config = &$config[$segment];
            }
        }
        $config = $value;
    }

    private function __construct()
    {
        // private
    }
    private function __clone()
    {
        // private
    }
    private function __wakeup()
    {
        // private
    }

}