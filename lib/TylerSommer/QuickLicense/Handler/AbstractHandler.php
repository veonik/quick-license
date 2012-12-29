<?php

namespace TylerSommer\QuickLicense\Handler;

/**
 * Base class for any language handler
 */
abstract class AbstractHandler implements HandlerInterface
{
    /**
     * @var string The body of the license
     */
    protected $license;

    /**
     * @var string The formatted, ready-to-be-inserted license
     */
    protected $formattedLicense;

    /**
     * @var Formatter\FormatterInterface
     */
    protected $formatter;

    /**
     * Constructor
     *
     * @param string $license The body of the license
     */
    public function __construct($license = null)
    {
        if (null !== $license) {
            $this->setLicense($license);
        }
    }

    /**
     * Gets the associated formatter
     *
     * @return Formatter\FormatterInterface
     */
    abstract protected function getFormatter();

    /**
     * Gets the formatted license
     *
     * @return string
     */
    public function getFormattedLicense()
    {
        return $this->formattedLicense;
    }

    /**
     * Returns true if the given file contents does not already contain license text
     *
     * @param string $contents
     *
     * @return bool
     */
    public function doesFileNeedProcessing($contents)
    {
        return false !== strpos($contents, $this->license);
    }

    /**
     * Sets the license
     *
     * @param string $license
     */
    public function setLicense($license)
    {
        $this->license = $license;
        $this->formattedLicense = $this->getFormatter()->formatLicense($license);
    }
}

