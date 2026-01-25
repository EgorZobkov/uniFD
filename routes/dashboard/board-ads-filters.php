<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/ads/filters', 'Dashboard/AdsFiltersController@main', ['name' => 'dashboard-ads-filters', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);
    $this->container->router->any('/ads/filters/links', 'Dashboard/AdsFiltersController@links', ['name' => 'dashboard-ads-filters-links', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);

    $this->container->router->xpost('/ads/filter/add', 'Dashboard/AdsFiltersController@add', ['name' => 'dashboard-ads-filter-add', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);
    $this->container->router->xpost('/ads/filter/delete', 'Dashboard/AdsFiltersController@delete', ['name' => 'dashboard-ads-filter-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);
    $this->container->router->xpost('/ads/filter/load-edit', 'Dashboard/AdsFiltersController@loadEdit', ['name' => 'dashboard-ads-filter-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);
    $this->container->router->xpost('/ads/filter/edit', 'Dashboard/AdsFiltersController@edit', ['name' => 'dashboard-ads-filter-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);
    $this->container->router->xpost('/ads/filter/load-add-podfilter', 'Dashboard/AdsFiltersController@loadAddPodfilter', ['name' => 'dashboard-ads-filter-load-add-podfilter', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);
    $this->container->router->xpost('/ads/filter/add-podfilter', 'Dashboard/AdsFiltersController@addPodfilter', ['name' => 'dashboard-ads-filter-add-podfilter', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);
    $this->container->router->xpost('/ads/filter/load-items-filter', 'Dashboard/AdsFiltersController@loadItemsFilter', ['name' => 'dashboard-ads-filter-load-items-filter', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);
    $this->container->router->xpost('/ads/filters/load-subfilters', 'Dashboard/AdsFiltersController@loadSubfilters', ['name' => 'dashboard-ads-filters-load-subfilters', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);

    $this->container->router->xpost('/ads/filter/link/add', 'Dashboard/AdsFiltersController@addFilterLink', ['name' => 'dashboard-ads-filter-link-add', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);
    $this->container->router->xpost('/ads/filter/link/delete', 'Dashboard/AdsFiltersController@deleteFilterLink', ['name' => 'dashboard-ads-filter-link-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);
    $this->container->router->xpost('/ads/filter/link/load-edit', 'Dashboard/AdsFiltersController@loadEditFilterLink', ['name' => 'dashboard-ads-filter-link-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);
    $this->container->router->xpost('/ads/filter/link/edit', 'Dashboard/AdsFiltersController@editFilterLink', ['name' => 'dashboard-ads-filter-link-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);
    $this->container->router->xpost('/ads/filters/sorting', 'Dashboard/AdsFiltersController@filtersSorting', ['name' => 'dashboard-ads-filters-sorting', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);
    $this->container->router->xpost('/ads/filters/insert-list-items', 'Dashboard/AdsFiltersController@insertListItems', ['name' => 'dashboard-ads-filter-insert-list-items', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-ads-filters']);

}, ['dashboard'=>true]);