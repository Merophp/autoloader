<?php
namespace Merophp\Autoloader\NamespacePrefix;

class NamespacePrefix
{
    protected string $prefix;

    protected string $path;

    /**
     * @param string $prefix
     * @param string $path
     */
    public function __construct(string $prefix, string $path)
    {
        $this->prefix = $prefix;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
