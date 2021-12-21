<?php
use PHPUnit\Framework\TestCase;

use Merophp\Autoloader\Autoloader;
use Merophp\Autoloader\Exception\AutoloaderException;
use Merophp\Autoloader\NamespacePrefix\Collection\NamespacePrefixCollection;
use Merophp\Autoloader\NamespacePrefix\NamespacePrefix;
use Merophp\Autoloader\NamespacePrefix\Provider\NamespacePrefixProvider;

/**
 * @covers \Merophp\Autoloader\Autoloader
 */
final class AutoloaderTest extends TestCase
{
    public static function setUpBeforeClass():void
    {
        $collection = new NamespacePrefixCollection();
        $collection->addMultiple([
            new NamespacePrefix('Vendor1\\Test', './tests/integration/testData/vendor1'),
            new NamespacePrefix('Vendor1', './tests/integration/testData/vendor3'),
            new NamespacePrefix('Vendor2\\Test', './tests/integration/testData/vendor2'),
        ]);
        $provider = new NamespacePrefixProvider($collection);

        $autoloader = new Autoloader($provider);
    }

    public function testLoadClass()
    {
        $testService = new Vendor1\Test\Service\TestService;
        $this->assertEquals('Foo', $testService->test());

        $this->assertTrue(class_exists(Vendor1\Test\Service\TestService::class));

        $testService2 = new Vendor1\Service\TestService;
        $this->assertEquals('Bar', $testService2->test());

        $this->assertFalse(class_exists(Vendor2\Test\Service\NonExistingClass::class));

        $this->expectException(AutoloaderException::class);

        $testService3 = new Vendor2\Test\Service\NonExistingClass;
    }
}
