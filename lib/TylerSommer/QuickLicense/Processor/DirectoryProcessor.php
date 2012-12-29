<?php

namespace TylerSommer\QuickLicense\Processor;

class DirectoryProcessor extends AbstractProcessor
{
    /**
     * @param string $path
     *
     * @return void
     */
    public function processPath($path)
    {
        $processor = new FileProcessor($this->handlerFactory);

        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path)) as $file) {
            $processor->processPath($file);
        }
    }
}
