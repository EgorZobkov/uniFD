<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/blog/categories', 'Dashboard/BlogCategoriesController@categories', ['name' => 'dashboard-blog-categories', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-categories']);
    
    $this->container->router->xpost('/blog/category/add', 'Dashboard/BlogCategoriesController@add', ['name' => 'dashboard-blog-category-add', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-categories']);
    $this->container->router->xpost('/blog/category/edit', 'Dashboard/BlogCategoriesController@edit', ['name' => 'dashboard-blog-category-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-categories']);
    $this->container->router->xpost('/blog/category/delete', 'Dashboard/BlogCategoriesController@delete', ['name' => 'dashboard-blog-category-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-categories']);
    $this->container->router->xpost('/blog/category/load-edit', 'Dashboard/BlogCategoriesController@loadEdit', ['name' => 'dashboard-blog-category-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-categories']);
    $this->container->router->xpost('/blog/categories/load-subcategories', 'Dashboard/BlogCategoriesController@loadSubcategories', ['name' => 'dashboard-blog-categories-load-subcategories', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-categories']);
    $this->container->router->xpost('/blog/categories/sorting', 'Dashboard/BlogCategoriesController@sorting', ['name' => 'dashboard-blog-categories-sorting', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-categories']);

}, ['dashboard'=>true]);