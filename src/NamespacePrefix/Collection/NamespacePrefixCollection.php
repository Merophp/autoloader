<?php
namespace Merophp\Autoloader\NamespacePrefix\Collection;

use Merophp\Autoloader\NamespacePrefix\NamespacePrefix;

use IteratorAggregate;
use ArrayIterator;

class NamespacePrefixCollection implements IteratorAggregate
{
    /**
     * @var array
     */
    protected array $namespacePrefixes = [];

    /**
     * @param NamespacePrefix $namespacePrefix
     */
    public function add(NamespacePrefix $namespacePrefix)
    {
        $this->namespacePrefixes[] = $namespacePrefix;
    }

    /**
     * @param NamespacePrefix[] $namespacePrefixes
     */
    public function addMultiple(array $namespacePrefixes)
    {
        foreach($namespacePrefixes as $namespacePrefix){
            $this->add($namespacePrefix);
        }
    }

    /**
     * @param NamespacePrefix $namespacePrefix
     * @return bool
     */
    public function has(NamespacePrefix $namespacePrefix): bool
    {
        return in_array($namespacePrefix, $this->namespacePrefixes);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->namespacePrefixes);
    }
}
