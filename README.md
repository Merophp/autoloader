# Introduction

Simple PSR-4 autoloader for the merophp framework.

## Installation

Via composer:

<code>
composer require merophp/autoloader
</code>

## Basic Usage

<pre><code>require_once 'vendor/autoload.php';

use Merophp\Autoloader\NamespacePrefix\NamespacePrefix;
use Merophp\Autoloader\NamespacePrefix\Collection\NamespacePrefixCollection;
use Merophp\Autoloader\NamespacePrefix\Provider\NamespacePrefixProvider;
use Merophp\Autoloader\Autoloader;

$collection = new NamespacePrefixCollection();
$collection->addMultiple([
     new NamespacePrefix('Vendor1\\Test', './tests/integration/testData/vendor1'),
     new NamespacePrefix('Vendor2\\Test', './tests/integration/testData/vendor2'),
]);
$provider = new NamespacePrefixProvider($collection);

$autoloader = new Autoloader($provider);

//Now you can call your classes
$serviceA = new Vendor1\Test\Service\ServiceA();
//Expect class in ./tests/integration/testData/vendor1/Service/ServiceA.php
</code></pre>

