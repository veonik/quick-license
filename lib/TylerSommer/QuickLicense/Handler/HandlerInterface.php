<?php

namespace TylerSommer\QuickLicense\Handler;

/**
 * File Extension Handler Interface
 *
 * Defines the contract any file extension handler must follow
 */
interface HandlerInterface
{
    /**
     * Sets the license body
     *
     * @param string $license
     *
     * @return void
     */
    function setLicense($license);

    /**
     * Gets the array of supported extensions
     *
     * @return array
     */
    function getSupportedExtensions();

    /**
     * Inserts the given license text into the file contents
     *
     * @param string $contents
     *
     * @return string The processed contents
     */
    function process($contents);

    /**
     * Returns true if the given file contents does not already contain license text
     *
     * @param string $contents
     *
     * @return bool
     */
    function doesFileNeedProcessing($contents);
}
