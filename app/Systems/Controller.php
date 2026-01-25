<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

use App\Systems\Container;

class Controller
{
    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function __get(string $key): object {
        return $this->container->get($key);
    }

    public function __set(string $key, object $value): void {
        $this->container->set($key, $value);
    }
}