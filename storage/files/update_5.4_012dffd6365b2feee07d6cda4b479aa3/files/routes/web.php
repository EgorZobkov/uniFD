<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

$this->container->router->get('/', 'HomeController@home', ['name' => 'home', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->any('/webhook/:string/:string/:string/:string?', 'SystemController@webhook', ['before' => ['WebTranslateMiddleware']]);
$this->container->router->get('/cron/execution/:string', 'CronController@execution', ['before' => ['WebTranslateMiddleware']]);
$this->container->router->get('/oauth/:string', 'AuthorizeController@oauth', ['before' => ['WebTranslateMiddleware']]);
$this->container->router->get('/ref/:string', 'ProfileController@fixTransitionReferral', ['name' => 'transition-referral', 'before' => ['WebTranslateMiddleware','WebMiddleware']]);
$this->container->router->get('/map/:all?', 'MapController@main', ['name' => 'search-by-map', 'before' => ['WebTranslateMiddleware','WebMiddleware']]);
$this->container->router->xpost('/check-verify-phone', 'VerifyController@checkVerifyPhone', ['name' => 'check-verify-phone', 'before' => ['WebTranslateMiddleware','PostMiddleware']]);
$this->container->router->xpost('/check-code-verify-contact', 'VerifyController@checkCodeVerifyContact', ['name' => 'check-code-verify-contact', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/send-code-verify-contact', 'VerifyController@sendCodeVerifyContact', ['name' => 'send-code-verify-contact', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/check-verify-contact', 'VerifyController@checkVerifyContact', ['name' => 'check-verify-contact', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);

$this->container->router->xpost('/map/load-items', 'MapController@loadItems', ['name' => 'map-load-items', 'before' => ['WebTranslateMiddleware','PostMiddleware']]);
$this->container->router->xpost('/map/load-markers', 'MapController@loadMarkers', ['name' => 'map-load-markers', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/map/load-item', 'MapController@loadItem', ['name' => 'map-load-item', 'before' => ['WebTranslateMiddleware','PostMiddleware']]);
$this->container->router->xpost('/map/delivery/points/load-markers', 'MapController@loadDeliveryPointsMarkers', ['name' => 'map-load-delivery-points-markers', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->xpost('/map/delivery/point/load-item', 'MapController@loadDeliveryPointItem', ['name' => 'map-load-delivery-point-item', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware']]);

$this->container->router->xpost('/home/load-items', 'HomeController@loadItems', ['name' => 'home-load-items', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/adv/click', 'SystemController@advClick', ['name' => 'adv-click', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/search/item/click', 'SystemController@searchItemClick', ['name' => 'search-item-click', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);

$this->container->router->xpost('/go/partner-link', 'AdCardController@goPartnerLink', ['name' => 'go-partner-link', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/check-flash-notify', 'SystemController@checkFlashNotify', ['name' => 'check-flash-notify', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/translite', 'SystemController@translite', ['name' => 'translite', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);

$this->container->router->xpost('/captcha', 'SystemController@captcha', ['name' => 'captcha', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/captcha-verify', 'SystemController@captchaVerify', ['name' => 'captcha-verify', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->any('/ckfinder', 'SystemController@ckfinder', ['name' => 'ckfinder', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->xpost('/modal-open', 'SystemController@modalOpen', ['name' => 'modal-open', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);

$this->container->router->get('/auth', 'AuthorizeController@login', ['name' => 'login', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->get('/logout', 'AuthorizeController@logout', ['name' => 'profile-logout']);

$this->container->router->xpost('/auth', 'AuthorizeController@auth', ['name' => 'auth', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/registration', 'AuthorizeController@registration', ['name' => 'registration', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/restore-pass', 'AuthorizeController@restorePass', ['name' => 'restore-pass', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);

$this->container->router->xpost('/search-items-combined', 'CatalogController@searchItemsCombined', ['name' => 'search-items-combined', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);

$this->container->router->get('/blog', 'BlogController@blog', ['name' => 'blog', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->get('/blog/:string/:string-:int', 'BlogController@post', ['name' => 'blog-post', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->get('/blog/:all', 'BlogController@category', ['name' => 'blog', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->xpost('/blog/load-items', 'BlogController@loadItems', ['name' => 'blog-load-items', 'before' => ['WebTranslateMiddleware','PostMiddleware']]);

$this->container->router->get('/profile', 'ProfileController@profile', ['name' => 'profile', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/profile/ads', 'ProfileController@ads', ['name' => 'profile-ads', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/profile/wallet', 'ProfileController@wallet', ['name' => 'profile-wallet', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/profile/chat', 'ProfileController@chat', ['name' => 'profile-chat', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/profile/orders', 'ProfileController@orders', ['name' => 'profile-orders', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/profile/reviews', 'ProfileController@reviews', ['name' => 'profile-reviews', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/profile/verification', 'ProfileController@verification', ['name' => 'profile-verification', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/profile/tariffs', 'ProfileController@tariffs', ['name' => 'profile-tariffs', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/profile/shop', 'ProfileController@shop', ['name' => 'profile-shop', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/profile/favorites', 'ProfileController@favorites', ['name' => 'profile-favorites', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/profile/autorenewal', 'ProfileController@autorenewal', ['name' => 'profile-autorenewal', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/profile/statistics', 'ProfileController@statistics', ['name' => 'profile-statistics', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/profile/referral', 'ProfileController@referral', ['name' => 'profile-referral', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/profile/settings', 'ProfileController@settings', ['name' => 'profile-settings', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/user/card/:string', 'ProfileController@user', ['name' => 'user-card', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->get('/user/card/ads/:string', 'ProfileController@userAds', ['name' => 'user-card-ads', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);

$this->container->router->xpost('/user/add-complaint', 'ProfileController@addComplaint', ['name' => 'user-add-complaint', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/verification/upload-attach', 'ProfileController@verificationUploadAttach', ['name' => 'profile-verification-upload-attach', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/verification/send', 'ProfileController@verificationSend', ['name' => 'profile-verification-send', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/subscribe', 'ProfileController@subscribeUser', ['name' => 'profile-subscribe', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/blacklist/add', 'ProfileController@blacklistAdd', ['name' => 'profile-blacklist-add', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/favorite/add', 'ProfileController@favoriteAdd', ['name' => 'profile-favorite-add', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/searches/delete', 'ProfileController@searchDelete', ['name' => 'profile-searches-delete', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/renewal/delete', 'ProfileController@renewalDelete', ['name' => 'profile-renewal-delete', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/settings/edit', 'ProfileController@settingsEdit', ['name' => 'profile-settings-edit', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/settings/delete', 'ProfileController@profileDelete', ['name' => 'profile-settings-delete', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/settings/edit-password', 'ProfileController@editPassword', ['name' => 'profile-settings-edit-password', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/upload-avatar', 'ProfileController@uploadAvatar', ['name' => 'profile-upload-avatar', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/statistics/search-user-items', 'ProfileController@searchUserItemsInStatistics', ['name' => 'profile-statistics-search-user-items', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/statistics/load-data-chart', 'ProfileController@loadStatisticsChartMonth', ['name' => 'profile-statistics-load-data-chart', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/settings/payment/score-add', 'ProfileController@paymentScoreAdd', ['name' => 'profile-settings-payment-score-add', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/settings/payment/score-delete', 'ProfileController@paymentScoreDelete', ['name' => 'profile-settings-payment-score-delete', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/settings/payment/card-add', 'ProfileController@paymentCardAdd', ['name' => 'profile-settings-payment-card-add', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/settings/payment/score-default', 'ProfileController@paymentScoreDefault', ['name' => 'profile-settings-payment-score-default', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/settings/delivery/add-point', 'ProfileController@deliveryAddPoint', ['name' => 'profile-settings-delivery-add-point', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/profile/settings/delivery/status', 'ProfileController@deliveryStatus', ['name' => 'profile-settings-delivery-status', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);

$this->container->router->get('/review/add/:int', 'ReviewsController@add', ['name' => 'review-add', 'before' => [ 'WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->xpost('/review/upload-attach', 'ReviewsController@uploadAttach', ['name' => 'review-upload-attach', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/review/create', 'ReviewsController@reviewCreate', ['name' => 'review-create', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/review/response', 'ReviewsController@responseCreate', ['name' => 'review-response-create', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/review/delete', 'ReviewsController@delete', ['name' => 'review-delete', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/review/search-user-items', 'ReviewsController@searchUserItems', ['name' => 'review-search-user-items', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);

$this->container->router->xpost('/chat/open-send-message', 'ChatController@openSendMessage', ['name' => 'chat-open-send-message', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/chat/send-message', 'ChatController@send', ['name' => 'chat-send-message', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/chat/load-dialogues', 'ChatController@loadDialogues', ['name' => 'chat-load-dialogues', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/chat/load-dialogue', 'ChatController@loadDialogue', ['name' => 'chat-load-dialogue', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/chat/load-messages', 'ChatController@loadMessages', ['name' => 'chat-load-messages', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/chat/update-count-messages', 'ChatController@updateCountMessages', ['name' => 'chat-update-count-messages', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/chat/delete-dialogue', 'ChatController@deleteDialogue', ['name' => 'chat-delete-dialogue', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/chat/delete-message', 'ChatController@deleteMessage', ['name' => 'chat-delete-message', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/chat/channel-disable-notify', 'ChatController@channelDisableNotify', ['name' => 'chat-channel-disable-notify', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);

$this->container->router->xpost('/chat/upload-attach', 'ChatController@uploadAttach', ['name' => 'chat-upload-attach', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/chat/send-request-review', 'ChatController@sendRequestReview', ['name' => 'chat-send-request-review', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);

$this->container->router->get('/ad/create/', 'AdController@create', ['name' => 'ad-create', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->get('/ad/create/success/:int', 'AdController@publicationSuccess', ['name' => 'ad-publication-success', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->get('/ad/edit/:int', 'AdController@edit', ['name' => 'ad-edit', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);

$this->container->router->xpost('/ad/card/show-contacts', 'AdCardController@showContacts', ['name' => 'ad-card-show-contacts', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->get('/ad/services/:int', 'AdPaidServicesController@main', ['name' => 'ad-services', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->xpost('/ad/services/update-count-item', 'AdPaidServicesController@updateCount', ['name' => 'ad-services-update-count-item', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/services/search-user-items', 'AdPaidServicesController@searchUserItems', ['name' => 'ad-services-search-user-items', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/delete', 'AdCardController@delete', ['name' => 'ad-delete', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/extend', 'AdCardController@extend', ['name' => 'ad-extend', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/card/status-sold', 'AdCardController@changeStatusSold', ['name' => 'ad-card-status-sold', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/card/status-publication', 'AdCardController@changeStatusPublication', ['name' => 'ad-card-status-publication', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/add-complaint', 'AdCardController@addComplaint', ['name' => 'ad-add-complaint', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/card/booking-load-calendar', 'AdCardController@bookingCalendar', ['name' => 'ad-card-booking-load-calendar', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/card/booking-load-calculation', 'AdCardController@bookingCalculation', ['name' => 'ad-card-booking-load-calculation', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/card/booking-create-order', 'AdCardController@bookingCreateOrder', ['name' => 'ad-card-booking-create-order', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/card/booking-prices-calculation', 'AdCardController@bookingPricesCalculation', ['name' => 'ad-card-booking-prices-calculation', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerifyCsrfTokenMiddleware']]);

$this->container->router->xpost('/ad/create/change-category-options', 'AdController@createChangeCategoryOptions', ['name' => 'ad-create-change-category-options', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/create/load-filter-items', 'AdController@createLoadFilterItems', ['name' => 'ad-create-load-filter-items', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/create/publication', 'AdController@publication', ['name' => 'ad-publication', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/create/update', 'AdController@update', ['name' => 'ad-update', 'before' => ['WebTranslateMiddleware','PostMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/create/load-media', 'AdController@loadMedia', ['name' => 'ad-create-load-media', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/create/load-geo-options', 'AdController@loadGeoOptions', ['name' => 'ad-create-load-geo-options', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/ad/create/load-content', 'AdController@loadContentCreate', ['name' => 'ad-create-load-content', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerifyCsrfTokenMiddleware']]);

$this->container->router->xpost('/geo/change', 'GeoController@change', ['name' => 'geo-change', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/geo/change-country', 'GeoController@changeCountry', ['name' => 'geo-change-country', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/geo/change-options', 'GeoController@changeOptions', ['name' => 'geo-change-options', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/geo/clear-options', 'GeoController@clearOptions', ['name' => 'geo-clear-options', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/geo/search-combined', 'GeoController@searchCombined', ['name' => 'geo-search-combined', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/geo/search-city', 'GeoController@searchCity', ['name' => 'geo-search-city', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/geo/search-address', 'GeoController@searchAddress', ['name' => 'geo-search-address', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/geo/coordinates-detect', 'GeoController@coordinatesDetect', ['name' => 'geo-coordinates-detect', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);

$this->container->router->xpost('/catalog/change-view-item', 'CatalogController@changeViewItem', ['name' => 'catalog-change-view-item', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/catalog/load-items', 'CatalogController@loadItems', ['name' => 'catalog-load-items', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/catalog/load-filter-items', 'CatalogController@loadFilterItems', ['name' => 'catalog-load-filter-items', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/catalog/apply-filters', 'CatalogController@acceptFilters', ['name' => 'catalog-apply-filters', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/catalog/clear-filters', 'CatalogController@clearFilters', ['name' => 'catalog-clear-filters', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/catalog/save-search', 'CatalogController@saveSearch', ['name' => 'catalog-save-search', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->xpost('/catalog/load-subcategories', 'CatalogController@loadSubcategories', ['name' => 'catalog-load-subcategories', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);

$this->container->router->xpost('/payment/load-option', 'TransactionsController@loadPaymentOption', ['name' => 'payment-load-option', 'before' => ['WebTranslateMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/payment/target', 'TransactionsController@initPaymentTarget', ['name' => 'payment-target', 'before' => ['WebTranslateMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware', 'PostMiddleware']]);
$this->container->router->xpost('/payment/wallet', 'TransactionsController@initPaymentWallet', ['name' => 'payment-wallet', 'before' => ['WebTranslateMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware', 'PostMiddleware']]);

$this->container->router->get('/payment/status/order/:string', 'TransactionsController@paymentStatusOrder', ['before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->get('/payment/status/success', 'TransactionsController@paymentStatusSuccess', ['before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->get('/payment/status/fail', 'TransactionsController@paymentStatusFail', ['before' => ['WebTranslateMiddleware', 'WebMiddleware']]);

$this->container->router->get('/order/buy/:int', 'TransactionsController@buyItemCard', ['name' => 'order-item-buy', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->get('/order/card/:string', 'TransactionsController@orderCard', ['name' => 'order-card', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->xpost('/payment/item', 'TransactionsController@initPaymentItem', ['name' => 'payment-item', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/payment/order', 'TransactionsController@initPaymentOrder', ['name' => 'payment-order', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/order/deal/change-status', 'TransactionsController@changeStatusDeal', ['name' => 'order-deal-change-status', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/order/deal/add-payment-score', 'TransactionsController@addPaymentScoreUser', ['name' => 'order-deal-add-payment-score', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/order/deal/cancel', 'TransactionsController@cancelDeal', ['name' => 'order-deal-cancel', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/order/deal/dispute-upload-attach', 'TransactionsController@disputeUploadAttach', ['name' => 'order-deal-dispute-upload-attach', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/order/deal/dispute-add', 'TransactionsController@disputeAdd', ['name' => 'order-deal-dispute-add', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/order/deal/dispute-close', 'TransactionsController@disputeClose', ['name' => 'order-deal-dispute-close', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/order/delivery/save-recipient', 'TransactionsController@saveDeliveryRecipient', ['name' => 'order-delivery-save-recipient', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);

$this->container->router->get('/cart', 'CartController@cart', ['name' => 'cart', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->get('/cart/checkout', 'CartController@checkout', ['name' => 'cart-checkout', 'before' => ['WebTranslateMiddleware', 'WebMiddleware', 'VerificationAuthMiddleware']]);
$this->container->router->xpost('/cart/add', 'CartController@addToCart', ['name' => 'cart-add', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/cart/update', 'CartController@update', ['name' => 'cart-update', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/cart/update-count', 'CartController@updateCount', ['name' => 'cart-update-count', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/cart/item-delete', 'CartController@itemDelete', ['name' => 'cart-item-delete', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/cart/item-minus-count', 'CartController@itemMinusCount', ['name' => 'cart-item-minus-count', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/cart/item-plus-count', 'CartController@itemPlusCount', ['name' => 'cart-item-plus-count', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/cart/gocheckout', 'CartController@goCheckout', ['name' => 'cart-gocheckout', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/cart/payment', 'CartController@payment', ['name' => 'cart-payment', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);

$this->container->router->xpost('/stories/upload-attach', 'StoriesController@uploadAttach', ['name' => 'stories-upload-attach', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/stories/publication', 'StoriesController@publication', ['name' => 'stories-publication', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/stories/load', 'StoriesController@load', ['name' => 'stories-load', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/stories/delete', 'StoriesController@delete', ['name' => 'stories-delete', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerificationAuthMiddleware','VerifyCsrfTokenMiddleware']]);

$this->container->router->get('/shop/:string', 'ShopController@shop', ['name' => 'shop', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->get('/shop/:string/page/:string', 'ShopController@page', ['name' => 'shop-page', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->get('/shop/:string/catalog/:all?', 'ShopController@catalog', ['name' => 'shop-catalog', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);

$this->container->router->xpost('/shop/upload-attach', 'ShopController@uploadAttach', ['name' => 'shop-upload-attach', 'before' => ['WebTranslateMiddleware', 'PostMiddleware','VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/shop/open', 'ShopController@open', ['name' => 'shop-open', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/shop/edit', 'ShopController@edit', ['name' => 'shop-edit', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/shop/delete', 'ShopController@delete', ['name' => 'shop-delete', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/shop/upload-banner', 'ShopController@uploadBanner', ['name' => 'shop-upload-banner', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/shop/delete-banner', 'ShopController@deleteBanner', ['name' => 'shop-delete-banner', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/shop/add-page', 'ShopController@addPage', ['name' => 'shop-add-page', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/shop/edit-page', 'ShopController@editPage', ['name' => 'shop-edit-page', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/shop/delete-page', 'ShopController@deletePage', ['name' => 'shop-delete-page', 'before' => ['WebTranslateMiddleware', 'PostMiddleware', 'VerificationAuthMiddleware', 'VerifyCsrfTokenMiddleware']]);
$this->container->router->xpost('/shop/load-items', 'ShopController@loadItems', ['name' => 'shop-load-items', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);

$this->container->router->get('/shops', 'ShopsController@shops', ['name' => 'shops', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->get('/shops/:string', 'ShopsController@shopsByCategories', ['name' => 'shops', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->xpost('/shops/load-items', 'ShopsController@loadItems', ['name' => 'shops-load-items', 'before' => ['WebTranslateMiddleware', 'PostMiddleware']]);

if($this->container->settings->multi_languages_status){

	$languages = $this->container->model->languages->getAll("status=?", [1]);

	if($languages){
		foreach ($languages as $value) {
			$this->container->router->get('/'.$value["iso"], 'HomeController@home', ['name'=>'home', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
		}
	}

}

$pages = $this->container->model->template_pages->getAll("freeze=? and alias is not null", [0]);

if($pages){
	foreach ($pages as $value) {
		$this->container->router->get('/'.$value["alias"], 'PageController@main', ['name'=>'other_page', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
	}
}

$this->container->router->get('/:all/:string-:int', 'AdCardController@card', ['name' => 'ad-card', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);
$this->container->router->get('/:all', 'CatalogController@catalog', ['name' => 'catalog', 'before' => ['WebTranslateMiddleware', 'WebMiddleware']]);