<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;
use App\Systems\Container;

class BlogCategories
{

    public $alias = "blog_categories";
    public $categories;

    public function __construct(){

        $this->categories = $this->getCategories();

    }

    {content}

}