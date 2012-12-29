<?php

namespace TylerSommer\QuickLicense\Tests\Handler;

use TylerSommer\QuickLicense\Handler\PhpHandler;

class PhpHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testHandler()
    {
        $handler = new PhpHandler();
        $handler->setLicense('Copyright Tyler Sommer');

        $contents = <<<END
<?php

namespace Test;
END;

        $contents = $handler->process($contents);

        $this->assertEquals('<?php

/*
 * Copyright Tyler Sommer
 */

namespace Test;', $contents);

    }
}
