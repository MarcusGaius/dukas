<?php

namespace MarcusGaius\YTData\Helpers;

use RecursiveArrayIterator;

class Helpers
{
    protected $file = PATH . 'config/yt.php';
    protected $temp_config;

    public function getConfig(string $key = '')
    {
        $config = include $this->file;
        if (!empty($key)) {
            return $this->parseDotArray($config, $key);
        }
        return $config;
    }

    protected function parseDotArray($arr, $index)
    {
        if (false !== stripos($index, '.')) {
            $iterator = new RecursiveArrayIterator($arr);
            $keys = explode('.', $index);
            while (count($keys) > 0) {
                $arr = $arr[array_shift($keys)];
            }
            return $arr;
        }
        return $arr[$index];
    }

    public function parseJSONFile($fileUri)
    {
        return json_decode(file_get_contents($fileUri), true);
    }

    protected function updateConfig()
    {
    }

    public function setConfig($key, $value)
    {
    }

    public function url($key = '')
    {
        return URI . ( !empty($key) ? $key : '' );
    }
}
