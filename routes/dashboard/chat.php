<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->any('/chat', 'Dashboard/ChatController@main', ['name' => 'dashboard-chat', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->any('/chat/channel/:int', 'Dashboard/ChatController@channel', ['name' => 'dashboard-chat-channel', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->any('/chat/dialogue/:int', 'Dashboard/ChatController@dialogue', ['name' => 'dashboard-chat-dialogue', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->any('/chat/messages', 'Dashboard/ChatController@allChatMessages', ['name' => 'dashboard-chat-messages', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);

    $this->container->router->xpost('/chat/add-channel', 'Dashboard/ChatController@addChannel', ['name' => 'dashboard-chat-add-channel', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/channel-load-edit', 'Dashboard/ChatController@loadEditChannel', ['name' => 'dashboard-chat-channel-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/edit-channel', 'Dashboard/ChatController@editChannel', ['name' => 'dashboard-chat-edit-channel', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/delete-channel', 'Dashboard/ChatController@deleteChannel', ['name' => 'dashboard-chat-delete-channel', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);

    $this->container->router->xpost('/chat/add-responder', 'Dashboard/ChatController@addResponder', ['name' => 'dashboard-chat-add-responder', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/delete-responder', 'Dashboard/ChatController@deleteResponder', ['name' => 'dashboard-chat-delete-responder', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/responder-load-edit', 'Dashboard/ChatController@loadEditResponder', ['name' => 'dashboard-chat-responder-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/edit-responder', 'Dashboard/ChatController@editResponder', ['name' => 'dashboard-chat-edit-responder', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);

    $this->container->router->xpost('/chat/send-message', 'Dashboard/ChatController@send', ['name' => 'dashboard-chat-send-message', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/upload-attach', 'Dashboard/ChatController@uploadAttach', ['name' => 'dashboard-chat-upload-attach', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/update-count-messages', 'Dashboard/ChatController@updateCountMessages', ['name' => 'dashboard-chat-update-count-messages', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/load-dialogues', 'Dashboard/ChatController@loadDialogues', ['name' => 'dashboard-chat-load-dialogues', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/load-dialogue', 'Dashboard/ChatController@loadDialogue', ['name' => 'dashboard-chat-load-dialogue', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/delete-message', 'Dashboard/ChatController@deleteMessage', ['name' => 'dashboard-chat-delete-message', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/add-blacklist', 'Dashboard/ChatController@addToBlacklist', ['name' => 'dashboard-chat-add-blacklist', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/delete-blacklist', 'Dashboard/ChatController@deleteBlacklist', ['name' => 'dashboard-chat-delete-blacklist', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/delete-dialogue', 'Dashboard/ChatController@deleteDialogue', ['name' => 'dashboard-chat-delete-dialogue', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/edit-automessages', 'Dashboard/ChatController@editAutomessages', ['name' => 'dashboard-chat-edit-automessages', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/load-support-dialogues', 'Dashboard/ChatController@loadSupportDialogues', ['name' => 'dashboard-chat-load-support-dialogues', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/load-support-dialogue', 'Dashboard/ChatController@loadSupportDialogue', ['name' => 'dashboard-chat-load-support-dialogue', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);
    $this->container->router->xpost('/chat/load-message', 'Dashboard/ChatController@loadMessage', ['name' => 'dashboard-chat-load-message', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-chat']);

}, ['dashboard'=>true]);