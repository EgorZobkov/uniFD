<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/updates', 'Dashboard/UpdatesController@main', ['name' => 'dashboard-updates', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-updates']);

}, ['dashboard'=>true]);