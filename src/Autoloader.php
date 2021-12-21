<?php
namespace Merophp\Autoloader;

use Exception;
use Merophp\Autoloader\Exception\AutoloaderException;
use Merophp\Autoloader\NamespacePrefix\Provider\NamespacePrefixProviderInterface;

/**
 * @author Robert Becker
 */
class Autoloader{

	/**
	 * @var NamespacePrefixProviderInterface
	 */
	protected NamespacePrefixProviderInterface $namespacePrefixProvider;

    /**
     * @param NamespacePrefixProviderInterface $namespacePrefixProvider
     */
    public function __construct(NamespacePrefixProviderInterface $namespacePrefixProvider)
    {
        $this->namespacePrefixProvider = $namespacePrefixProvider;
		spl_autoload_register([$this, 'loadClass']);
    }

    /**
     *
     * @param string $className Name of the class
     * @throws Exception
     */
	public function loadClass(string $className): void
    {
        $file = $this->getClassFile($className);
		if(!$this->isLoadable($file)){
			if(debug_backtrace()[1]['function'] != 'class_exists'){
				throw new AutoloaderException(sprintf('Class "%s" in "%s" is not loadable!', $className, $file));
			}
			else{
                return;
            }
		}

		require_once($file);
	}

	/**
	 * Terminate the path of a requested class.
	 *
	 * @param string $className
	 * @return string Relative path of the given class name.
	 */
	protected function getClassFile(string $className): string
    {
		$file = '';
		$moduleKeyFound = '';
		foreach($this->namespacePrefixProvider->getSortedNamespacePrefixes() as $namespacePrefix){
			if(strpos($className, $namespacePrefix->getPrefix()) === 0){
                $file = $namespacePrefix->getPath();
				$moduleKeyFound = $namespacePrefix->getPrefix();
				break;
			}
		}


		$classParts = explode('\\',
			str_replace($moduleKeyFound, '', $className)
		);

        $file .= implode('/',$classParts).'.php';

		return $file;
	}

    /**
     * Checks if a file is loadable.
     *
     * @param string $file
     * @return bool
     */
	public function isLoadable(string $file): bool
    {
		return (!empty($file) && is_file($file));
	}
}
