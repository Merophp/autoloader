<?php
namespace Merophp\Autoloader\NamespacePrefix\Provider;

use Merophp\Autoloader\NamespacePrefix\Collection\NamespacePrefixCollection;

class NamespacePrefixProvider implements NamespacePrefixProviderInterface
{
    protected NamespacePrefixCollection $namespacePrefixCollection;

    /**
     * @param NamespacePrefixCollection $namespacePrefixCollection
     */
    public function __construct(NamespacePrefixCollection $namespacePrefixCollection)
    {
        $this->namespacePrefixCollection = $namespacePrefixCollection;
    }

    /**
     * @return iterable
     */
    public function getNamespacePrefixes(): iterable
    {
        yield from $this->namespacePrefixCollection;
    }

    /**
     * @return iterable
     */
    public function getSortedNamespacePrefixes(): iterable
    {
        $namespacePrefixes = iterator_to_array($this->namespacePrefixCollection);
        usort($namespacePrefixes, function($b, $a){
            return (strlen($a->getPrefix()) == strlen($b->getPrefix()) ? strcmp($a->getPrefix(), $b->getPrefix()) : strlen($a->getPrefix()) - strlen($b->getPrefix()));
        });
        yield from $namespacePrefixes;
    }
}
