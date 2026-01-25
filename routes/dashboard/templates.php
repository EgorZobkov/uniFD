<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/templates', 'Dashboard/TemplatesController@main', ['name' => 'dashboard-templates', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-templates']);
    $this->container->router->any('/template/page/:id', 'Dashboard/TemplatesController@viewPage', ['name' => 'dashboard-template-view-page', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-templates']);
    $this->container->router->any('/template/css', 'Dashboard/TemplatesController@css', ['name' => 'dashboard-template-css', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-templates']);
    $this->container->router->any('/template/css/:any', 'Dashboard/TemplatesController@viewCss', ['name' => 'dashboard-template-view-css', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-templates']);
    $this->container->router->any('/template/js/', 'Dashboard/TemplatesController@js', ['name' => 'dashboard-template-js', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-templates']);
    $this->container->router->any('/template/js/:any', 'Dashboard/TemplatesController@viewJs', ['name' => 'dashboard-template-view-js', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-templates']);

    $this->container->router->xpost('/template/load-edit-page', 'Dashboard/TemplatesController@loadEditPage', ['name' => 'dashboard-template-load-edit-page', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-templates']);
    $this->container->router->xpost('/template/edit-page', 'Dashboard/TemplatesController@editPage', ['name' => 'dashboard-template-edit-page', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-templates']);
    $this->container->router->xpost('/template/save', 'Dashboard/TemplatesController@save', ['name' => 'dashboard-template-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-templates']);
    $this->container->router->xpost('/template/add-page', 'Dashboard/TemplatesController@addPage', ['name' => 'dashboard-template-add-page', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-templates']);
    $this->container->router->xpost('/template/delete-page', 'Dashboard/TemplatesController@deletePage', ['name' => 'dashboard-template-delete-page', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-templates']);
    
}, ['dashboard'=>true]);