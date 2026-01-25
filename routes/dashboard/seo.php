<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/seo', 'Dashboard/SeoController@main', ['name' => 'dashboard-seo', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-seo']);
    $this->container->router->any('/seo/card/:id', 'Dashboard/SeoController@card', ['name' => 'dashboard-seo-card', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-seo']);
    $this->container->router->xpost('/seo/save', 'Dashboard/SeoController@save', ['name' => 'dashboard-seo-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-seo']);

}, ['dashboard'=>true]);