<?php

use Merophp\Autoloader\NamespacePrefix\Collection\NamespacePrefixCollection;
use Merophp\Autoloader\NamespacePrefix\NamespacePrefix;
use Merophp\Autoloader\NamespacePrefix\Provider\NamespacePrefixProvider;
use PHPUnit\Framework\TestCase;

class NamespacePrefixProviderTest extends TestCase
{
    protected static ?NamespacePrefixProvider $providerInstance = null;

    public static function setUpBeforeClass():void
    {
        $collection = new NamespacePrefixCollection();
        $collection->addMultiple([
            new NamespacePrefix('Vendor1', './tests/integration/testData/vendor3'),
            new NamespacePrefix('Vendor2\\Test', './tests/integration/testData/vendor2'),
            new NamespacePrefix('Vendor1\\Test', './tests/integration/testData/vendor1'),
        ]);
        self::$providerInstance = new NamespacePrefixProvider($collection);
    }

    public function testGetNamespacePrefixes()
    {
        $this->assertIsIterable(self::$providerInstance->getNamespacePrefixes());
    }

    public function testGetSortedNamespacePrefixes()
    {
        $this->assertIsIterable(self::$providerInstance->getSortedNamespacePrefixes());
        $this->assertEquals('Vendor2\\Test', iterator_to_array(self::$providerInstance->getSortedNamespacePrefixes())[0]->getPrefix());
        $this->assertEquals('Vendor1\\Test', iterator_to_array(self::$providerInstance->getSortedNamespacePrefixes())[1]->getPrefix());
    }
}
