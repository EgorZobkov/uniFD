<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/stories', 'Dashboard/StoriesController@main', ['name' => 'dashboard-stories', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-stories']);

    $this->container->router->xpost('/stories/delete', 'Dashboard/StoriesController@delete', ['name' => 'dashboard-stories-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-stories']);
    $this->container->router->xpost('/stories/load-story', 'Dashboard/StoriesController@loadStory', ['name' => 'dashboard-stories-load-story', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-stories']);
    $this->container->router->xpost('/stories/change-status', 'Dashboard/StoriesController@changeStatus', ['name' => 'dashboard-stories-change-status', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-stories']);

}, ['dashboard'=>true]);