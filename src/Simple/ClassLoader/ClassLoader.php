<?php

namespace Simple\ClassLoader;

class ClassLoader
{
    private $prefixes;
    private $realPath;

    public function __construct($realPath, $prefixes)
    {
        $this->prefixes = $prefixes;
        $this->realPath = $realPath;
    }

    public function register(bool $prepend = false)
    {
        spl_autoload_register([$this, 'loadClass'], true, $prepend);
    }

    private function loadClass(string $class)
    {
        $file = $this->findFile($class);

        if ($file) {
            require $file;
            return true;
        }
    }

    private function findFile(string $className) {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if (!empty($this->prefixes)) {
            foreach ($this->prefixes as $prefix) {

                $path = $this->realPath . DIRECTORY_SEPARATOR . $prefix . DIRECTORY_SEPARATOR . $fileName;

                if (file_exists($path)) {
                    return $path;
                }
                //throw exception file not found
            }
        }
    }


}


