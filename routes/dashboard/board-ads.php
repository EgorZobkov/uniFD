<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/ads', 'Dashboard/AdsController@main', ['name' => 'dashboard-ads', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads']);
    
    $this->container->router->xpost('/ad/delete', 'Dashboard/AdsController@delete', ['name' => 'dashboard-ad-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads']);
    $this->container->router->xpost('/ad/load-card', 'Dashboard/AdsController@loadCard', ['name' => 'dashboard-ad-load-card', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads']);
    $this->container->router->xpost('/ad/load-user-card', 'Dashboard/AdsController@loadUserCard', ['name' => 'dashboard-ad-load-user-card', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads']);
    $this->container->router->xpost('/ad/approve', 'Dashboard/AdsController@approve', ['name' => 'dashboard-ad-approve', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads']);
    $this->container->router->xpost('/ad/change-status', 'Dashboard/AdsController@changeStatus', ['name' => 'dashboard-ad-change-status', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads']);
    $this->container->router->xpost('/ad/change-multi-status', 'Dashboard/AdsController@changeMultiStatus', ['name' => 'dashboard-ad-multi-change-status', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads']);
    $this->container->router->xpost('/ad/multi-extend', 'Dashboard/AdsController@multiExtend', ['name' => 'dashboard-ad-multi-extend', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads']);
    $this->container->router->xpost('/ad/save-comment-status', 'Dashboard/AdsController@saveCommentStatus', ['name' => 'dashboard-ad-save-comment-status', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads']);
    $this->container->router->xpost('/ad/load-data-chart', 'Dashboard/AdsController@loadDataChartMonth', ['name' => 'dashboard-ad-load-data-chart', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads']);
    $this->container->router->xpost('/ad/multi-delete', 'Dashboard/AdsController@multiDelete', ['name' => 'dashboard-ad-multi-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads']);

}, ['dashboard'=>true]);