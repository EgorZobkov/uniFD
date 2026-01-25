<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/reviews', 'Dashboard/ReviewsController@main', ['name' => 'dashboard-reviews', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-reviews']);

    $this->container->router->xpost('/review/delete', 'Dashboard/ReviewsController@delete', ['name' => 'dashboard-review-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-reviews']);
    $this->container->router->xpost('/review/load-card', 'Dashboard/ReviewsController@loadCard', ['name' => 'dashboard-review-load-card', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-reviews']);
    $this->container->router->xpost('/review/confirm', 'Dashboard/ReviewsController@confirm', ['name' => 'dashboard-review-confirm', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-reviews']);

    $this->container->router->xpost('/review/load-edit', 'Dashboard/ReviewsController@loadEdit', ['name' => 'dashboard-review-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-reviews']);
    $this->container->router->xpost('/review/edit', 'Dashboard/ReviewsController@edit', ['name' => 'dashboard-review-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-reviews']);

}, ['dashboard'=>true]);