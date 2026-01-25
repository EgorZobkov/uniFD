<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->get('/', 'Dashboard/DashboardController@home', ['name' => 'dashboard', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-home']);
    $this->container->router->get('/auth', 'Dashboard/AuthorizeController@login', ['name' => 'dashboard-auth', 'before' => ['DashboardAuthorizeMiddleware', 'DashboardTranslateMiddleware']]);
    $this->container->router->get('/forgot', 'Dashboard/AuthorizeController@forgot', ['name' => 'dashboard-forgot', 'before' => ['DashboardAuthorizeMiddleware', 'DashboardTranslateMiddleware']]);
    $this->container->router->get('/access-key/:string', 'Dashboard/AuthorizeController@accessKey', ['before' => ['DashboardTranslateMiddleware']]);
    $this->container->router->get('/logout', 'Dashboard/AuthorizeController@logout', ['name' => 'dashboard-logout', 'before' => ['DashboardTranslateMiddleware']]);

    $this->container->router->xpost('/auth', 'Dashboard/AuthorizeController@auth', ['name' => 'dashboard-auth-enter', 'before' => ['DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/restore-pass', 'Dashboard/AuthorizeController@restorePass', ['name' => 'dashboard-restore-pass', 'before' => ['DashboardTranslateMiddleware']]);

    $this->container->router->xpost('/search', 'Dashboard/DashboardController@search', ['name' => 'dashboard-search', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/add-to-favorites', 'Dashboard/DashboardController@addToFavorites', ['name' => 'dashboard-system-add-to-favorites', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/add-delete-favorite', 'Dashboard/DashboardController@deleteFavorite', ['name' => 'dashboard-system-delete-favorite', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/customize-template', 'Dashboard/DashboardController@customizeTemplate', ['name' => 'dashboard-system-customize-template', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/collapsed-sidebar', 'Dashboard/DashboardController@collapsedSidebar', ['name' => 'dashboard-system-collapsed-sidebar', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/widgets-sorting', 'Dashboard/DashboardController@widgetsSorting', ['name' => 'dashboard-widgets-sorting', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/widget-remove', 'Dashboard/DashboardController@widgetRemove', ['name' => 'dashboard-widget-remove', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/home-update', 'Dashboard/DashboardController@homeUpdate', ['name' => 'dashboard-home-update', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware']]);

    $this->container->router->xpost('/captcha', 'Dashboard/DashboardController@captcha', ['name' => 'dashboard-captcha', 'before' => ['DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/captcha-verify', 'Dashboard/AuthorizeController@captchaVerify', ['name' => 'dashboard-captcha-verify', 'before' => ['DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/check-flash-notify', 'Dashboard/DashboardController@checkFlashNotify', ['name' => 'dashboard-check-flash-notify', 'before' => ['DashboardTranslateMiddleware']]);
    $this->container->router->xpost('/translite', 'Dashboard/DashboardController@translite', ['name' => 'dashboard-translite', 'before' => ['DashboardTranslateMiddleware']]);

}, ['dashboard'=>true]);