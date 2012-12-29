<?php

namespace TylerSommer\QuickLicense\Handler;

/**
 * Processes PHP files
 */
use TylerSommer\QuickLicense\Handler\Formatter\CStyleFormatter;

class PhpHandler extends AbstractHandler
{
    /**
     * Gets the array of supported extensions
     *
     * @return array
     */
    public function getSupportedExtensions()
    {
        return array('php');
    }

    /**
     * Inserts the given license text into the file contents
     *
     * @param string $contents
     *
     * @return string The processed contents
     */
    public function process($contents)
    {
        return str_replace("<?php\n", "<?php\n\n" . $this->formattedLicense, $contents);
    }

    /**
     * Gets the associated formatter
     *
     * @return string
     */
    protected function getFormatter()
    {
        if (!$this->formatter) {
            $this->formatter = new CStyleFormatter();
        }

        return $this->formatter;
    }
}
