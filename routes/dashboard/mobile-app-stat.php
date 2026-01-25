<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/mobile-app/stat', 'Dashboard/MobileAppStatController@main', ['name' => 'dashboard-mobile-app-stat', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-mobile-app-stat']);
    $this->container->router->xpost('/mobile-app/stat/load-data-chart', 'Dashboard/MobileAppStatController@loadDataChartWeekAndMonth', ['name' => 'dashboard-mobile-app-stat-load-data-chart', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-mobile-app-stat']);

}, ['dashboard'=>true]);