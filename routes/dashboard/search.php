<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/search/keywords', 'Dashboard/SearchController@keywords', ['name' => 'dashboard-search-keywords', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-search-keywords']);
    $this->container->router->any('/search/requests', 'Dashboard/SearchController@requests', ['name' => 'dashboard-search-requests', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-search-keywords']);

    $this->container->router->xpost('/search/requests/clear', 'Dashboard/SearchController@requestsClear', ['name' => 'dashboard-search-requests-clear', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-search-keywords']);
    $this->container->router->xpost('/search/keywords/add', 'Dashboard/SearchController@keywordAdd', ['name' => 'dashboard-search-keywords-add', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-search-keywords']);
    $this->container->router->xpost('/search/keywords/edit', 'Dashboard/SearchController@keywordEdit', ['name' => 'dashboard-search-keywords-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-search-keywords']);
    $this->container->router->xpost('/search/keywords/delete', 'Dashboard/SearchController@keywordDelete', ['name' => 'dashboard-search-keywords-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-search-keywords']);
    $this->container->router->xpost('/search/keywords/load-edit', 'Dashboard/SearchController@loadEditKeyword', ['name' => 'dashboard-search-keyword-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-search-keywords']);

}, ['dashboard'=>true]);