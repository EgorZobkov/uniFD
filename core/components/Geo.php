<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Geo
{

    public $alias = "geo";
    public $defaultCountry = [];

    public function __construct(){
        global $app;
        $this->defaultCountry = $this->getDefaultCountry();
        $this->setMapVendor();
    }

    {content}

}