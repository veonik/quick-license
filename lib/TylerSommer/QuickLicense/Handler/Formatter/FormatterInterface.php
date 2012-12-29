<?php

namespace TylerSommer\QuickLicense\Handler\Formatter;

/**
 * License Formatter Interface
 *
 * Defines the contract any license formatter must follow
 */
interface FormatterInterface
{
    /**
     * Formats the given license
     *
     * @param string $license
     *
     * @return string The formatted license
     */
    function formatLicense($license);
}
