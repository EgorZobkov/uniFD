<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/complaints', 'Dashboard/ComplaintsController@main', ['name' => 'dashboard-complaints', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-complaints']);

    $this->container->router->xpost('/complaint/delete', 'Dashboard/ComplaintsController@delete', ['name' => 'dashboard-complaint-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-complaints']);
    $this->container->router->xpost('/complaint/load-card', 'Dashboard/ComplaintsController@loadCard', ['name' => 'dashboard-complaint-load-card', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-complaints']);
    $this->container->router->xpost('/complaint/confirm', 'Dashboard/ComplaintsController@confirm', ['name' => 'dashboard-complaint-confirm', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-complaints']);


}, ['dashboard'=>true]);