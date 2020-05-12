<?php

namespace RM\Component\Client\Security\Resolver;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser as YamlParser;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlConfigLoader
 *
 * @package RM\Component\Client\Security\Resolver
 * @author  Oleg Kozlov <h1karo@outlook.com>
 */
class YamlConfigLoader extends FileLoader
{
    private const VALID_EXTENSIONS = ['yml', 'yaml'];

    private YamlParser $yamlParser;

    public function __construct(FileLocatorInterface $locator)
    {
        parent::__construct($locator);
        $this->yamlParser = new YamlParser();
    }

    /**
     * @inheritDoc
     */
    public function load($file, string $type = null): Collection
    {
        $path = $this->locator->locate($file);

        if (!stream_is_local($path)) {
            throw new InvalidArgumentException(sprintf('This is not a local file "%s".', $path));
        }

        if (!file_exists($path)) {
            throw new InvalidArgumentException(sprintf('File "%s" not found.', $path));
        }

        try {
            $parsedConfig = $this->yamlParser->parseFile($path, Yaml::PARSE_CONSTANT);
        } catch (ParseException $e) {
            $message = sprintf('The file "%s" does not contain valid YAML.', $path);
            throw new InvalidArgumentException($message, 0, $e);
        }

        if (null === $parsedConfig) {
            $message = sprintf('The file "%s" is empty.', $path);
            throw new InvalidArgumentException($message);
        }

        if (!is_array($parsedConfig)) {
            $message = sprintf('The file "%s" must contain a YAML array.', $path);
            throw new InvalidArgumentException($message);
        }

        $config = new ArrayCollection();
        foreach ($parsedConfig as $action => $c) {
            $config->set($action, ActionConfig::createFromArray($c));
        }

        return $config;
    }

    /**
     * @inheritDoc
     */
    public function supports($resource, string $type = null): bool
    {
        if (!is_string($resource)) {
            return false;
        }

        $extension = pathinfo($resource, PATHINFO_EXTENSION);
        if (!in_array($extension, self::VALID_EXTENSIONS, true)) {
            return false;
        }

        return !$type || 'yaml' === $type;
    }
}
