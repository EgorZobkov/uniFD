<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/services', 'Dashboard/ServicesController@main', ['name' => 'dashboard-services', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-services']);
    $this->container->router->any('/services/tariffs', 'Dashboard/ServicesController@tariffs', ['name' => 'dashboard-services-tariffs', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-services']);

    $this->container->router->xpost('/services/load-data-chart', 'Dashboard/ServicesController@loadDataChartMonth', ['name' => 'dashboard-services-load-data-chart', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-services']);
    $this->container->router->xpost('/services/load-edit', 'Dashboard/ServicesController@loadEditService', ['name' => 'dashboard-services-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-services']);
    $this->container->router->xpost('/services/edit', 'Dashboard/ServicesController@editService', ['name' => 'dashboard-services-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-services']);

    $this->container->router->xpost('/services/tariff/add', 'Dashboard/ServicesController@addTariff', ['name' => 'dashboard-services-tariff-add', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-services']);
    $this->container->router->xpost('/services/tariff/edit', 'Dashboard/ServicesController@editTariff', ['name' => 'dashboard-services-tariff-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-services']);
    $this->container->router->xpost('/services/tariffs/load-data-chart', 'Dashboard/ServicesController@loadDataChartMonthTariffs', ['name' => 'dashboard-services-tariffs-load-data-chart', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-services']);
    $this->container->router->xpost('/services/tariff/delete', 'Dashboard/ServicesController@deleteTariff', ['name' => 'dashboard-services-tariff-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-services']);
    $this->container->router->xpost('/services/tariff/load-edit', 'Dashboard/ServicesController@loadEditTariff', ['name' => 'dashboard-services-tariff-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-services']);
    $this->container->router->xpost('/services/tariff/items-edit', 'Dashboard/ServicesController@editTariffItems', ['name' => 'dashboard-services-tariff-items-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-services']);

    $this->container->router->xpost('/services/sorting', 'Dashboard/ServicesController@servicesSorting', ['name' => 'dashboard-services-sorting', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-services']);
    $this->container->router->xpost('/services/tariffs/sorting', 'Dashboard/ServicesController@tariffsSorting', ['name' => 'dashboard-services-tariffs-sorting', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-services']);

}, ['dashboard'=>true]);