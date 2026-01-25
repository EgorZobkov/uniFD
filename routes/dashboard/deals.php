<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/deals', 'Dashboard/DealsController@main', ['name' => 'dashboard-deals', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-deals']);
    $this->container->router->any('/deal/card/:string', 'Dashboard/DealsController@card', ['name' => 'dashboard-deal-card', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-deals']);

    $this->container->router->xpost('/deals/load-data-chart', 'Dashboard/DealsController@loadDataChartMonth', ['name' => 'dashboard-deals-load-data-chart', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-deals']);
    $this->container->router->xpost('/deals/payment-load-card', 'Dashboard/DealsController@loadCardPayment', ['name' => 'dashboard-deal-payment-load-card', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-deals']);
    $this->container->router->xpost('/deals/payment-save-comment-error', 'Dashboard/DealsController@paymentSaveCommentError', ['name' => 'dashboard-deal-payment-save-comment-error', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-deals']);
    $this->container->router->xpost('/deals/payment-change-status', 'Dashboard/DealsController@paymentChangeStatus', ['name' => 'dashboard-deal-payment-change-status', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-deals']);
    $this->container->router->xpost('/deals/delete', 'Dashboard/DealsController@delete', ['name' => 'dashboard-deal-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-deals']);
    $this->container->router->xpost('/deals/dispute-save', 'Dashboard/DealsController@disputeSave', ['name' => 'dashboard-deal-dispute-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-deals']);

}, ['dashboard'=>true]);