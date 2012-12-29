<?php

namespace TylerSommer\QuickLicense\Handler;

/**
 * Defines the contract any HandlerFactory must follow
 */
interface HandlerFactoryInterface
{
    /**
     * @param HandlerInterface $handler
     *
     * @return HandlerFactoryInterface The current instance
     */
    function addHandler(HandlerInterface $handler);

    /**
     * @param string $extension
     *
     * @throws HandlerNotFoundException if unable to locate the necessary handler
     * @return HandlerInterface
     */
    function getExtensionHandler($extension);

    /**
     * @return array
     */
    function getSupportedExtensions();

    /**
     * @param array $extensions
     *
     * @return void
     */
    function setEnabledExtensions(array $extensions);
}
