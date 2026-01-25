<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/users/verifications', 'Dashboard/UsersVerificationsController@main', ['name' => 'dashboard-users-verifications', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-users-verifications']);

    $this->container->router->xpost('/user/verification/delete', 'Dashboard/UsersVerificationsController@delete', ['name' => 'dashboard-users-verification-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-users-verifications']);
    $this->container->router->xpost('/user/verification/change-status', 'Dashboard/UsersVerificationsController@changeStatus', ['name' => 'dashboard-users-verification-change-status', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-users-verifications']);
    $this->container->router->xpost('/user/verification/load-card', 'Dashboard/UsersVerificationsController@loadCard', ['name' => 'dashboard-users-verification-load-card', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-users-verifications']);
    $this->container->router->xpost('/user/verification/save-comment-status', 'Dashboard/UsersVerificationsController@saveCommentStatus', ['name' => 'dashboard-users-verification-save-comment-status', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-users-verifications']);

}, ['dashboard'=>true]);