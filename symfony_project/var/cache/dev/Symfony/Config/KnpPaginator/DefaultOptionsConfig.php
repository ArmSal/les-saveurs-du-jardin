<?php

namespace Symfony\Config\KnpPaginator;

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class DefaultOptionsConfig 
{
    private $sortFieldName;
    private $sortDirectionName;
    private $filterFieldName;
    private $filterValueName;
    private $pageName;
    private $distinct;
    private $pageOutOfRange;
    private $defaultLimit;
    private $_usedProperties = [];

    /**
     * @default 'sort'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function sortFieldName($value): static
    {
        $this->_usedProperties['sortFieldName'] = true;
        $this->sortFieldName = $value;

        return $this;
    }

    /**
     * @default 'direction'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function sortDirectionName($value): static
    {
        $this->_usedProperties['sortDirectionName'] = true;
        $this->sortDirectionName = $value;

        return $this;
    }

    /**
     * @default 'filterField'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function filterFieldName($value): static
    {
        $this->_usedProperties['filterFieldName'] = true;
        $this->filterFieldName = $value;

        return $this;
    }

    /**
     * @default 'filterValue'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function filterValueName($value): static
    {
        $this->_usedProperties['filterValueName'] = true;
        $this->filterValueName = $value;

        return $this;
    }

    /**
     * @default 'page'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function pageName($value): static
    {
        $this->_usedProperties['pageName'] = true;
        $this->pageName = $value;

        return $this;
    }

    /**
     * @default true
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function distinct($value): static
    {
        $this->_usedProperties['distinct'] = true;
        $this->distinct = $value;

        return $this;
    }

    /**
     * @default 'ignore'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function pageOutOfRange($value): static
    {
        $this->_usedProperties['pageOutOfRange'] = true;
        $this->pageOutOfRange = $value;

        return $this;
    }

    /**
     * @default 10
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function defaultLimit($value): static
    {
        $this->_usedProperties['defaultLimit'] = true;
        $this->defaultLimit = $value;

        return $this;
    }

    public function __construct(array $config = [])
    {
        if (array_key_exists('sort_field_name', $config)) {
            $this->_usedProperties['sortFieldName'] = true;
            $this->sortFieldName = $config['sort_field_name'];
            unset($config['sort_field_name']);
        }

        if (array_key_exists('sort_direction_name', $config)) {
            $this->_usedProperties['sortDirectionName'] = true;
            $this->sortDirectionName = $config['sort_direction_name'];
            unset($config['sort_direction_name']);
        }

        if (array_key_exists('filter_field_name', $config)) {
            $this->_usedProperties['filterFieldName'] = true;
            $this->filterFieldName = $config['filter_field_name'];
            unset($config['filter_field_name']);
        }

        if (array_key_exists('filter_value_name', $config)) {
            $this->_usedProperties['filterValueName'] = true;
            $this->filterValueName = $config['filter_value_name'];
            unset($config['filter_value_name']);
        }

        if (array_key_exists('page_name', $config)) {
            $this->_usedProperties['pageName'] = true;
            $this->pageName = $config['page_name'];
            unset($config['page_name']);
        }

        if (array_key_exists('distinct', $config)) {
            $this->_usedProperties['distinct'] = true;
            $this->distinct = $config['distinct'];
            unset($config['distinct']);
        }

        if (array_key_exists('page_out_of_range', $config)) {
            $this->_usedProperties['pageOutOfRange'] = true;
            $this->pageOutOfRange = $config['page_out_of_range'];
            unset($config['page_out_of_range']);
        }

        if (array_key_exists('default_limit', $config)) {
            $this->_usedProperties['defaultLimit'] = true;
            $this->defaultLimit = $config['default_limit'];
            unset($config['default_limit']);
        }

        if ($config) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($config)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['sortFieldName'])) {
            $output['sort_field_name'] = $this->sortFieldName;
        }
        if (isset($this->_usedProperties['sortDirectionName'])) {
            $output['sort_direction_name'] = $this->sortDirectionName;
        }
        if (isset($this->_usedProperties['filterFieldName'])) {
            $output['filter_field_name'] = $this->filterFieldName;
        }
        if (isset($this->_usedProperties['filterValueName'])) {
            $output['filter_value_name'] = $this->filterValueName;
        }
        if (isset($this->_usedProperties['pageName'])) {
            $output['page_name'] = $this->pageName;
        }
        if (isset($this->_usedProperties['distinct'])) {
            $output['distinct'] = $this->distinct;
        }
        if (isset($this->_usedProperties['pageOutOfRange'])) {
            $output['page_out_of_range'] = $this->pageOutOfRange;
        }
        if (isset($this->_usedProperties['defaultLimit'])) {
            $output['default_limit'] = $this->defaultLimit;
        }

        return $output;
    }

}
