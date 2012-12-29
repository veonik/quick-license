<?php

namespace TylerSommer\QuickLicense\Processor;

/**
 * File Processor Interface
 *
 * Defines the contract any file processor must follow
 */
interface ProcessorInterface
{
    /**
     * @param string $path
     *
     * @return void
     */
    function processPath($path);
}
