<?php

namespace UWDOEM\Framework\Filter;


interface FilterInterface {

    /**
     * @param FilterInterface $filter
     */
    function combine(FilterInterface $filter);

    /**
     * @return string
     */
    function getType();

    /**
     * @return string[]
     */
    function getFeedback();

    /**
     * @return string
     */
    function getName();

    /**
     * @return FilterInterface
     */
    function getNextFilter();

}