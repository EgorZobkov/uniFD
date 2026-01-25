<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/promo/banners', 'Dashboard/PromoBannersController@main', ['name' => 'dashboard-promo-banners', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-promo-banners']);
    
    $this->container->router->xpost('/promo/banner/add', 'Dashboard/PromoBannersController@add', ['name' => 'dashboard-promo-banner-add', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-promo-banners']);
    $this->container->router->xpost('/promo/banner/edit', 'Dashboard/PromoBannersController@edit', ['name' => 'dashboard-promo-banner-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-promo-banners']);
    $this->container->router->xpost('/promo/banner/delete', 'Dashboard/PromoBannersController@delete', ['name' => 'dashboard-promo-banner-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-promo-banners']);
    $this->container->router->xpost('/promo/banner/load-edit', 'Dashboard/PromoBannersController@loadEdit', ['name' => 'dashboard-promo-banner-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-promo-banners']);

}, ['dashboard'=>true]);