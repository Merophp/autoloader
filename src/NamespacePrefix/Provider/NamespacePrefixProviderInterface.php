<?php

namespace Merophp\Autoloader\NamespacePrefix\Provider;

interface NamespacePrefixProviderInterface
{
    public function getNamespacePrefixes(): iterable;
    public function getSortedNamespacePrefixes(): iterable;
}
