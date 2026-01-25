<?php
$this->container->router->group($this->container->config->app->dashboard_alias, function($router) {

    $this->container->router->get('/compile-core', 'Dashboard/SettingsController@compileCore', ['name' => 'dashboard-compile-core', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->any('/settings', 'Dashboard/SettingsController@main', ['name' => 'dashboard-settings', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->any('/settings/graphics', 'Dashboard/SettingsController@main', ['name' => 'dashboard-settings-graphics', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/graphics/save', 'Dashboard/SettingsController@saveGraphics', ['name' => 'dashboard-settings-graphics-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/clear-cache', 'Dashboard/SettingsController@clearCache', ['name' => 'dashboard-settings-clear-cache', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->any('/settings/information', 'Dashboard/SettingsController@main', ['name' => 'dashboard-settings-information', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/information/save', 'Dashboard/SettingsController@saveInformation', ['name' => 'dashboard-settings-information-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->any('/settings/integrations', 'Dashboard/SettingsController@main', ['name' => 'dashboard-settings-integrations', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/integrations/save', 'Dashboard/SettingsController@saveIntegrations', ['name' => 'dashboard-settings-integrations-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/integrations/test-key-telegram', 'Dashboard/SettingsController@integrationsTestKeyTelegram', ['name' => 'dashboard-settings-integrations-test-key-telegram', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/integrations/test-sms', 'Dashboard/SettingsController@integrationsTestSms', ['name' => 'dashboard-settings-integrations-test-sms', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->xpost('/settings/integrations/payment-load-edit', 'Dashboard/SettingsController@integrationsPaymentLoadEdit', ['name' => 'dashboard-settings-integrations-payment-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/integrations/payment-save-edit', 'Dashboard/SettingsController@integrationsPaymentSaveEdit', ['name' => 'dashboard-settings-integrations-payment-save-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->xpost('/settings/integrations/sms-load-options', 'Dashboard/SettingsController@integrationsSmsLoadOptions', ['name' => 'dashboard-settings-integrations-sms-load-options', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->any('/settings/systems', 'Dashboard/SettingsController@main', ['name' => 'dashboard-settings-systems', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/systems/save', 'Dashboard/SettingsController@saveSystems', ['name' => 'dashboard-settings-systems-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->any('/settings/access', 'Dashboard/SettingsController@main', ['name' => 'dashboard-settings-access', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/access/save', 'Dashboard/SettingsController@saveAccess', ['name' => 'dashboard-settings-access-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->any('/settings/mailing', 'Dashboard/SettingsController@main', ['name' => 'dashboard-settings-mailing', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/mailing/save', 'Dashboard/SettingsController@saveMailing', ['name' => 'dashboard-settings-mailing-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/mailing/load-template', 'Dashboard/SettingsController@mailingLoadTemplate', ['name' => 'dashboard-settings-mailing-load-template', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/mailing/test-send', 'Dashboard/SettingsController@mailingTestSend', ['name' => 'dashboard-settings-mailing-test-send', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->any('/settings/market', 'Dashboard/SettingsController@main', ['name' => 'dashboard-settings-market', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/market/save', 'Dashboard/SettingsController@saveMarket', ['name' => 'dashboard-settings-market-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->any('/settings/profile', 'Dashboard/SettingsController@main', ['name' => 'dashboard-settings-profile', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/profile/save', 'Dashboard/SettingsController@saveProfile', ['name' => 'dashboard-settings-profile-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->any('/settings/seo', 'Dashboard/SettingsController@main', ['name' => 'dashboard-settings-seo', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/seo/save', 'Dashboard/SettingsController@saveSeo', ['name' => 'dashboard-settings-seo-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
   
    $this->container->router->any('/settings/home', 'Dashboard/SettingsController@main', ['name' => 'dashboard-settings-home', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/home/save', 'Dashboard/SettingsController@saveHome', ['name' => 'dashboard-settings-home-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->any('/settings/api-app', 'Dashboard/SettingsController@main', ['name' => 'dashboard-settings-api-app', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/api-app/save', 'Dashboard/SettingsController@saveApiApp', ['name' => 'dashboard-settings-api-app-save', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->xpost('/settings/integrations/delivery-load-edit', 'Dashboard/SettingsController@integrationsDeliveryLoadEdit', ['name' => 'dashboard-settings-integrations-delivery-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/integrations/delivery-save-edit', 'Dashboard/SettingsController@integrationsDeliverySaveEdit', ['name' => 'dashboard-settings-integrations-delivery-save-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->xpost('/settings/integrations/oauth-load-edit', 'Dashboard/SettingsController@integrationsOAuthLoadEdit', ['name' => 'dashboard-settings-integrations-oauth-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/integrations/oauth-save-edit', 'Dashboard/SettingsController@integrationsOAuthSaveEdit', ['name' => 'dashboard-settings-integrations-oauth-save-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

    $this->container->router->xpost('/settings/integrations/messenger-load-edit', 'Dashboard/SettingsController@integrationsMessengerLoadEdit', ['name' => 'dashboard-settings-integrations-messenger-load-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);
    $this->container->router->xpost('/settings/integrations/messenger-save-edit', 'Dashboard/SettingsController@integrationsMessengerSaveEdit', ['name' => 'dashboard-settings-integrations-messenger-save-edit', 'before' => ['DashboardMiddleware', 'DashboardTranslateMiddleware'], 'route_id'=>'dashboard-settings']);

}, ['dashboard'=>true]);