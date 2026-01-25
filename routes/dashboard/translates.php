<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/translates', 'Dashboard/TranslatesController@main', ['name' => 'dashboard-translates', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-translates']);
    
    $this->container->router->xpost('/translates/add-language', 'Dashboard/TranslatesController@addLanguage', ['name' => 'dashboard-translates-add-language', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-translates']);
    $this->container->router->xpost('/translates/edit-language', 'Dashboard/TranslatesController@editLanguage', ['name' => 'dashboard-translates-edit-language', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-translates']);
    $this->container->router->xpost('/translates/delete-language', 'Dashboard/TranslatesController@deleteLanguage', ['name' => 'dashboard-translates-delete-language', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-translates']);
    $this->container->router->xpost('/translates/language-load-edit', 'Dashboard/TranslatesController@loadEditLanguage', ['name' => 'dashboard-translates-language-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-translates']);

    $this->container->router->xpost('/translates/edit-content', 'Dashboard/TranslatesController@editContent', ['name' => 'dashboard-translates-edit-content', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-translates']);
    $this->container->router->xpost('/translates/update-content', 'Dashboard/TranslatesController@updateContent', ['name' => 'dashboard-translates-update-content', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-translates']);

}, ['dashboard'=>true]);