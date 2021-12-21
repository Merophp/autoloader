<?php
namespace Merophp\Autoloader\NamespacePrefix\Provider;

class CompoundNamespacePrefixProvider implements NamespacePrefixProviderInterface
{
    /**
     * @var NamespacePrefixProviderInterface[]
     */
    protected array $namespacePrefixProviders = [];

    /**
     * @param NamespacePrefixProviderInterface $namespacePrefixProvider
     */
    public function attach(NamespacePrefixProviderInterface $namespacePrefixProvider)
    {
        $this->namespacePrefixProviders[] = $namespacePrefixProvider;
    }

    /**
     * @return iterable
     */
    public function getNamespacePrefixes(): iterable
    {
        foreach($this->namespacePrefixProviders as $namespacePrefixProvider){
            //var_dump(iterator_to_array($namespacePrefixProvider->getNamespacePrefixes()));
            yield from $namespacePrefixProvider->getNamespacePrefixes();
        }
    }

    /**
     * @return iterable
     */
    public function getSortedNamespacePrefixes(): iterable
    {
        $namespacePrefixes = iterator_to_array($this->getNamespacePrefixes(), false);
        usort($namespacePrefixes, function($b, $a){
            return (strlen($a->getPrefix()) == strlen($b->getPrefix()) ? strcmp($a->getPrefix(), $b->getPrefix()) : strlen($a->getPrefix()) - strlen($b->getPrefix()));
        });
        yield from $namespacePrefixes;
    }
}
