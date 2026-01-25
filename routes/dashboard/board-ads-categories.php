<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/ads/categories', 'Dashboard/AdsCategoriesController@main', ['name' => 'dashboard-ads-categories', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-categories']);
    
    $this->container->router->xpost('/ads/category/add', 'Dashboard/AdsCategoriesController@add', ['name' => 'dashboard-ads-category-add', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-categories']);
    $this->container->router->xpost('/ads/category/edit', 'Dashboard/AdsCategoriesController@edit', ['name' => 'dashboard-ads-category-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-categories']);
    $this->container->router->xpost('/ads/category/delete', 'Dashboard/AdsCategoriesController@delete', ['name' => 'dashboard-ads-category-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-categories']);
    $this->container->router->xpost('/ads/category/load-edit', 'Dashboard/AdsCategoriesController@loadEdit', ['name' => 'dashboard-ads-category-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-categories']);
    $this->container->router->xpost('/ads/categories/load-subcategories', 'Dashboard/AdsCategoriesController@loadSubcategories', ['name' => 'dashboard-ads-categories-load-subcategories', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-categories']);
    $this->container->router->xpost('/ads/categories/load-template-filter-items', 'Dashboard/AdsCategoriesController@loadTemplateFilterItems', ['name' => 'dashboard-ads-category-load-template-filter-items', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-categories']);
    $this->container->router->xpost('/ads/categories/sorting', 'Dashboard/AdsCategoriesController@sorting', ['name' => 'dashboard-ads-categories-sorting', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-categories']);

}, ['dashboard'=>true]);