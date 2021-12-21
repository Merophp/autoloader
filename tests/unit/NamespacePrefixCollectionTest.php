<?php

use Merophp\Autoloader\NamespacePrefix\Collection\NamespacePrefixCollection;
use Merophp\Autoloader\NamespacePrefix\NamespacePrefix;
use PHPUnit\Framework\TestCase;

class NamespacePrefixCollectionTest extends TestCase
{
    protected static ?NamespacePrefixCollection $collectionInstance = null;

    public static function setUpBeforeClass():void
    {
        self::$collectionInstance = new NamespacePrefixCollection();
    }

    public function testMultipleAdd()
    {
        $np1 = new NamespacePrefix('Vendor1\\Test', './tests/integration/testData/vendor1');
        self::$collectionInstance->addMultiple([
            $np1,
            new NamespacePrefix('Vendor1', './tests/integration/testData/vendor3'),
            new NamespacePrefix('Vendor2\\Test', './tests/integration/testData/vendor2'),
        ]);
        $this->assertTrue(self::$collectionInstance->has($np1));

        $this->assertIsIterable(self::$collectionInstance);
        $this->assertEquals(3, iterator_count(self::$collectionInstance));
    }
}
