<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/shops', 'Dashboard/ShopsController@main', ['name' => 'dashboard-shops', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-shops']);

    $this->container->router->xpost('/shops/edit', 'Dashboard/ShopsController@edit', ['name' => 'dashboard-shops-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-shops']);
    $this->container->router->xpost('/shops/load-edit', 'Dashboard/ShopsController@loadEdit', ['name' => 'dashboard-shops-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-shops']);
    $this->container->router->xpost('/shops/delete', 'Dashboard/ShopsController@delete', ['name' => 'dashboard-shops-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-shops']);
    $this->container->router->xpost('/shops/load-card', 'Dashboard/ShopsController@loadCard', ['name' => 'dashboard-shops-load-card', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-shops']);
    $this->container->router->xpost('/shops/change-status', 'Dashboard/ShopsController@changeStatus', ['name' => 'dashboard-shops-change-status', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-shops']);
    $this->container->router->xpost('/shops/save-comment-status', 'Dashboard/ShopsController@saveCommentStatus', ['name' => 'dashboard-shops-save-comment-status', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-shops']);

}, ['dashboard'=>true]);