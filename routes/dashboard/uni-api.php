<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->xpost('/uniid/auth', 'Dashboard/UniApiController@authUniId', ['name' => 'dashboard-uniid-auth', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/uniid/logout', 'Dashboard/UniApiController@logoutUniId', ['name' => 'dashboard-uniid-logout', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/uniid/check-update', 'Dashboard/UniApiController@checkUpdate', ['name' => 'dashboard-uniid-check-update', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/uniid/install-update', 'Dashboard/UniApiController@installUpdate', ['name' => 'dashboard-uniid-install-update', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware']]);

}, ['dashboard'=>true]);