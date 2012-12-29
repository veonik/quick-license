<?php

namespace TylerSommer\QuickLicense\Handler;

/**
 * Processes PHP files
 */
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
    public function processFile($contents)
    {
        return str_replace("<?php\n", "<?php\n\n" . $this->formattedLicense, $contents);
    }

    /**
     * Format the given license
     *
     * @param string $license
     *
     * @return string
     */
    protected function formatLicense($license)
    {
        $formattedLicense = "/**\n";

        do {
            $license = ' * ' . $license;
            $pos = strlen($license) - 1;

            if ($pos > 79) {
                $pos = 79;
            }

            do {
                if (' ' === $license{$pos}) {
                    break;
                }

                $pos--;
            } while ($pos > 0);

            $formattedLicense .= substr($license, 0, $pos) . "\n";
            $license = substr($license, $pos + 1);
        } while (strlen($license) > 0);

        return $formattedLicense;
    }
}
