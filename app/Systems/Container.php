<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

class Container{

    private $container = [];

    public function __get(string $key): object {
        return $this->get($key);
    }

    public function __set(string $key, object $value): void {
        $this->set($key, $value);
    }

    public function get(string $key): object|null {
        return isset($this->container[$key]) ? $this->container[$key] : null;
    }

    public function set(string $key, object $value): void {
        $this->container[$key] = $value;
    }

    public function has(string $key): bool {
        return isset($this->container[$key]);
    }

    public function unset(string $key): void {
        if (isset($this->container[$key])) {
            unset($this->container[$key]);
        }
    }

 }