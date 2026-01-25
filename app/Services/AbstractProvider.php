<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Services;

use App\Systems\Container;

abstract class AbstractProvider{

    protected $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    abstract function init();

}