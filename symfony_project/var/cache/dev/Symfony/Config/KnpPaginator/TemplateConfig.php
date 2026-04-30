<?php

namespace Symfony\Config\KnpPaginator;

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class TemplateConfig 
{
    private $pagination;
    private $relLinks;
    private $filtration;
    private $sortable;
    private $_usedProperties = [];

    /**
     * @default '@KnpPaginator/Pagination/sliding.html.twig'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function pagination($value): static
    {
        $this->_usedProperties['pagination'] = true;
        $this->pagination = $value;

        return $this;
    }

    /**
     * @default '@KnpPaginator/Pagination/rel_links.html.twig'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function relLinks($value): static
    {
        $this->_usedProperties['relLinks'] = true;
        $this->relLinks = $value;

        return $this;
    }

    /**
     * @default '@KnpPaginator/Pagination/filtration.html.twig'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function filtration($value): static
    {
        $this->_usedProperties['filtration'] = true;
        $this->filtration = $value;

        return $this;
    }

    /**
     * @default '@KnpPaginator/Pagination/sortable_link.html.twig'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function sortable($value): static
    {
        $this->_usedProperties['sortable'] = true;
        $this->sortable = $value;

        return $this;
    }

    public function __construct(array $config = [])
    {
        if (array_key_exists('pagination', $config)) {
            $this->_usedProperties['pagination'] = true;
            $this->pagination = $config['pagination'];
            unset($config['pagination']);
        }

        if (array_key_exists('rel_links', $config)) {
            $this->_usedProperties['relLinks'] = true;
            $this->relLinks = $config['rel_links'];
            unset($config['rel_links']);
        }

        if (array_key_exists('filtration', $config)) {
            $this->_usedProperties['filtration'] = true;
            $this->filtration = $config['filtration'];
            unset($config['filtration']);
        }

        if (array_key_exists('sortable', $config)) {
            $this->_usedProperties['sortable'] = true;
            $this->sortable = $config['sortable'];
            unset($config['sortable']);
        }

        if ($config) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($config)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['pagination'])) {
            $output['pagination'] = $this->pagination;
        }
        if (isset($this->_usedProperties['relLinks'])) {
            $output['rel_links'] = $this->relLinks;
        }
        if (isset($this->_usedProperties['filtration'])) {
            $output['filtration'] = $this->filtration;
        }
        if (isset($this->_usedProperties['sortable'])) {
            $output['sortable'] = $this->sortable;
        }

        return $output;
    }

}
