<?php

namespace TylerSommer\QuickLicense\Handler;

class HandlerNotFoundException extends \RuntimeException
{
    public static function create($extension)
    {
        return new self(sprintf('Unable to locate file handler for extension "%s"', $extension));
    }
}
