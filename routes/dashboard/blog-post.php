<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/blog/posts', 'Dashboard/BlogPostController@posts', ['name' => 'dashboard-blog-posts', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-posts']);
    $this->container->router->any('/blog/post/content/:int', 'Dashboard/BlogPostController@postContent', ['name' => 'dashboard-blog-post-content', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-posts']);
    
    $this->container->router->xpost('/blog/post/add', 'Dashboard/BlogPostController@add', ['name' => 'dashboard-blog-post-add', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-posts']);
    $this->container->router->xpost('/blog/post/delete', 'Dashboard/BlogPostController@delete', ['name' => 'dashboard-blog-post-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-posts']);
    $this->container->router->xpost('/blog/post/multi-delete', 'Dashboard/BlogPostController@multiDelete', ['name' => 'dashboard-blog-post-multi-delete', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-posts']);
    $this->container->router->xpost('/blog/post/load-edit', 'Dashboard/BlogPostController@loadEdit', ['name' => 'dashboard-blog-post-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-posts']);
    $this->container->router->xpost('/blog/post/edit', 'Dashboard/BlogPostController@edit', ['name' => 'dashboard-blog-post-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-posts']);
    $this->container->router->xpost('/blog/post/content-save', 'Dashboard/BlogPostController@contentSave', ['name' => 'dashboard-blog-post-content-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-posts']);
    $this->container->router->xpost('/blog/post/upload-image', 'Dashboard/BlogPostController@uploadImage', ['name' => 'dashboard-blog-post-upload-image', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-blog-posts']);

}, ['dashboard'=>true]);