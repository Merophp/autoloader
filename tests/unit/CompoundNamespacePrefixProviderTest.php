<?php
use PHPUnit\Framework\TestCase;

use Merophp\Autoloader\NamespacePrefix\Collection\NamespacePrefixCollection;
use Merophp\Autoloader\NamespacePrefix\NamespacePrefix;
use Merophp\Autoloader\NamespacePrefix\Provider\CompoundNamespacePrefixProvider;
use Merophp\Autoloader\NamespacePrefix\Provider\NamespacePrefixProvider;

class CompoundNamespacePrefixProviderTest extends TestCase
{
    protected static ?CompoundNamespacePrefixProvider $providerInstance = null;

    public static function setUpBeforeClass():void
    {
        $collectionA = new NamespacePrefixCollection();
        $collectionA->addMultiple([
            new NamespacePrefix('Vendor1', 'foo'),
            new NamespacePrefix('Vendor2\\Test', 'bar'),
        ]);
        $providerA = new NamespacePrefixProvider($collectionA);

        $collectionB = new NamespacePrefixCollection();
        $collectionB->addMultiple([
            new NamespacePrefix('Vendor2', 'foo'),
            new NamespacePrefix('Vendor1\\Test', 'bar'),
        ]);
        $providerB = new NamespacePrefixProvider($collectionB);

        self::$providerInstance = new CompoundNamespacePrefixProvider();
        self::$providerInstance->attach($providerA);
        self::$providerInstance->attach($providerB);
    }

    public function testGetNamespacePrefixes()
    {
        $this->assertIsIterable(self::$providerInstance->getNamespacePrefixes());
    }

    public function testGetSortedNamespacePrefixes()
    {
        $namespacePrefixes = iterator_to_array(self::$providerInstance->getSortedNamespacePrefixes());
        $this->assertEquals('Vendor2\\Test', $namespacePrefixes[0]->getPrefix());
        $this->assertEquals('Vendor1\\Test', $namespacePrefixes[1]->getPrefix());
        $this->assertEquals('Vendor2', $namespacePrefixes[2]->getPrefix());
        $this->assertEquals('Vendor1', $namespacePrefixes[3]->getPrefix());
    }
}
