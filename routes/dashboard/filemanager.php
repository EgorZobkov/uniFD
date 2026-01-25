<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->xpost('/filemanager/load-files', 'Dashboard/FilemanagerController@loadFiles', ['name' => 'dashboard-filemanager-load-files', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-filemanager']);
    $this->container->router->xpost('/filemanager/upload-files', 'Dashboard/FilemanagerController@uploadFiles', ['name' => 'dashboard-filemanager-upload-files', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-filemanager']);
    $this->container->router->xpost('/filemanager/delete-file', 'Dashboard/FilemanagerController@deleteFile', ['name' => 'dashboard-filemanager-delete-file', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-filemanager']);

}, ['dashboard'=>true]);