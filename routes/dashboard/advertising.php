<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/advertising', 'Dashboard/AdvertisingController@main', ['name' => 'dashboard-advertising', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-advertising']);
    
    $this->container->router->xpost('/advertising/add', 'Dashboard/AdvertisingController@add', ['name' => 'dashboard-advertising-add', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-advertising']);
    $this->container->router->xpost('/advertising/delete', 'Dashboard/AdvertisingController@delete', ['name' => 'dashboard-advertising-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-advertising']);
    $this->container->router->xpost('/advertising/load-edit', 'Dashboard/AdvertisingController@loadEdit', ['name' => 'dashboard-advertising-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-advertising']);
    $this->container->router->xpost('/advertising/edit', 'Dashboard/AdvertisingController@edit', ['name' => 'dashboard-advertising-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-advertising']);
    $this->container->router->xpost('/advertising/geo-search', 'Dashboard/AdvertisingController@geoSearch', ['name' => 'dashboard-advertising-geo-search', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-advertising']);
    $this->container->router->xpost('/advertising/slider-load-add', 'Dashboard/AdvertisingController@sliderLoadAdd', ['name' => 'dashboard-advertising-slider-load-add', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-advertising']);
    $this->container->router->xpost('/advertising/slider-add', 'Dashboard/AdvertisingController@sliderAdd', ['name' => 'dashboard-advertising-slider-add', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-advertising']);
    $this->container->router->xpost('/advertising/load-data-chart', 'Dashboard/AdvertisingController@loadDataChartMonth', ['name' => 'dashboard-advertising-load-data-chart', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-advertising']);

}, ['dashboard'=>true]);
