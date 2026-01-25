<?php
$this->container->router->group("api", function($router) {

	$this->container->router->get('/settings/get', 'Api/SettingsController@get', ['name' => 'api-settings-get', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/settings/combined/data', 'Api/SettingsController@getCombinedData', ['name' => 'api-settings-combined-data', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/shops/all', 'Api/ShopsController@getAllShops', ['name' => 'api-shops-all', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/ads/all', 'Api/AdsController@getAllAds', ['name' => 'api-ads-all', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/geo/location', 'Api/GeoController@location', ['name' => 'api-geo-location', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->post('/auth', 'Api/AuthorizeController@auth', ['name' => 'api-auth', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/registration', 'Api/AuthorizeController@registration', ['name' => 'api-registration', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/auth/token', 'Api/AuthorizeController@authToken', ['name' => 'api-auth-token', 'before' => ['AppTranslateMiddleware', 'ApiMiddleware']]);
    $this->container->router->post('/auth/recovery', 'Api/AuthorizeController@recovery', ['name' => 'api-auth-recovery', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/recovery/edit/pass', 'Api/AuthorizeController@recoveryEditPass', ['name' => 'api-recovery-edit-pass', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->post('/verify/send', 'Api/VerifyController@send', ['name' => 'api-verify-send', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/verify/code', 'Api/VerifyController@verifyCode', ['name' => 'api-verify-code', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/verify/phone/check', 'Api/VerifyController@checkVerifyPhone', ['name' => 'api-verify-phone-check', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/profile/data', 'Api/ProfileController@getData', ['name' => 'api-profile-data', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/profile/tariffs/all', 'Api/ProfileController@getAllTariffs', ['name' => 'api-profile-tariffs-all', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/tariff/activate', 'Api/ProfileController@tariffActivate', ['name' => 'api-profile-tariff-activate', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/tariff/delete', 'Api/ProfileController@tariffDelete', ['name' => 'api-profile-tariff-delete', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/profile/verification', 'Api/ProfileController@getVerificationData', ['name' => 'api-profile-verification', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/transaction/init/payment', 'Api/TransactionsController@initPayment', ['name' => 'api-transaction-init-payment', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/transaction/status/payment', 'Api/TransactionsController@statusPayment', ['name' => 'api-transaction-status-payment', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->post('/storage/save', 'Api/StorageController@storageSave', ['name' => 'api-storage-save', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/stories/upload', 'Api/StoriesController@upload', ['name' => 'api-stories-upload', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/stories/users/all', 'Api/StoriesController@usersStories', ['name' => 'api-stories-users-all', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/stories/user/all', 'Api/StoriesController@userStories', ['name' => 'api-stories-user-all', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/stories/view/update', 'Api/StoriesController@updateViewStory', ['name' => 'api-stories-view-update', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/stories/story/delete', 'Api/StoriesController@deleteStory', ['name' => 'api-stories-story-delete', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->post('/profile/favorites/manage', 'Api/ProfileController@favoritesManage', ['name' => 'api-profile-favorites-manage', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/add-delivery-point', 'Api/ProfileController@addDeliveryPoint', ['name' => 'api-profile-add-delivery-point', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/catalog/offers', 'Api/CatalogController@getOffers', ['name' => 'api-catalog-offers', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/ad/card/get', 'Api/AdCardController@getCard', ['name' => 'api-ad-get-card', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/ad/card/contacts', 'Api/AdCardController@getContacts', ['name' => 'api-ad-card-contacts', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/ad/card/similars', 'Api/AdCardController@getSimilars', ['name' => 'api-ad-card-similars', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->post('/ad/card/add-complaint', 'Api/AdCardController@addComplaint', ['name' => 'api-ad-card-add-complaint', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/ad/card/go-partner-link', 'Api/AdCardController@goPartnerLink', ['name' => 'api-ad-card-go-partner-link', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->post('/ad/card/delete', 'Api/AdCardController@deleteAd', ['name' => 'api-ad-card-delete', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/ad/card/change-status', 'Api/AdCardController@changeStatus', ['name' => 'api-ad-card-change-status', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/ad/card/services-tariffs-all', 'Api/AdCardController@getServicesTariffsAll', ['name' => 'api-ad-card-services-tariffs-all', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/user/card/data', 'Api/UserController@getData', ['name' => 'api-user-card-data', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/user/card/ads', 'Api/UserController@getAllAds', ['name' => 'api-user-card-all-ads', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/user/card/add-complaint', 'Api/UserController@addComplaint', ['name' => 'api-user-card-add-complaint', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/user/card/add-blacklist', 'Api/UserController@addBlacklist', ['name' => 'api-user-card-add-blacklist', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/user/card/subscribe', 'Api/UserController@subscribe', ['name' => 'api-user-card-subscribe', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/profile/ads', 'Api/ProfileController@getAllAds', ['name' => 'api-profile-all-ads', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/edit/status_text', 'Api/ProfileController@editStatusText', ['name' => 'api-profile-edit-status-text', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    
    $this->container->router->get('/reviews', 'Api/ReviewsController@getReviews', ['name' => 'api-reviews', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/review', 'Api/ReviewsController@getReview', ['name' => 'api-review', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/review/delete', 'Api/ReviewsController@deleteReview', ['name' => 'api-review-delete', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/review/add-answer', 'Api/ReviewsController@addAnswer', ['name' => 'api-review-add-answer', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/review/data', 'Api/ReviewsController@getData', ['name' => 'api-review-data', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/review/create', 'Api/ReviewsController@create', ['name' => 'api-review-create', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/review/search-items', 'Api/ReviewsController@searchUserItems', ['name' => 'api-review-search-items', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/profile/balance/history', 'Api/ProfileController@getBalanceHistory', ['name' => 'api-profile-balance-history', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/add-verification', 'Api/ProfileController@addVerification', ['name' => 'api-profile-add-verification', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/profile/tariff/scheduler/items', 'Api/ProfileController@getSchedulerItems', ['name' => 'api-profile-tariff-scheduler-items', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/tariff/scheduler/delete', 'Api/ProfileController@deleteSchedulerItem', ['name' => 'api-profile-tariff-scheduler-delete', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/profile/tariff/extra-statistics', 'Api/ProfileController@getExtraStatistics', ['name' => 'api-profile-tariff-extra-statistics', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/profile/orders', 'Api/ProfileController@getOrders', ['name' => 'api-profile-orders', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/profile/favorites', 'Api/ProfileController@getFavorites', ['name' => 'api-profile-favorites', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/favorite/delete', 'Api/ProfileController@deleteFavorite', ['name' => 'api-profile-favorite-delete', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/search/delete', 'Api/ProfileController@deleteSearch', ['name' => 'api-profile-search-delete', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/profile/subscriptions', 'Api/ProfileController@getSubscriptions', ['name' => 'api-profile-subscriptions', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/subscription/delete', 'Api/ProfileController@deleteSubscription', ['name' => 'api-profile-subscription-delete', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/card/edit-pass', 'Api/ProfileController@editPassword', ['name' => 'api-profile-card-edit-pass', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/card/delete', 'Api/ProfileController@profileDelete', ['name' => 'api-profile-card-delete', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/card/edit', 'Api/ProfileController@profileEdit', ['name' => 'api-profile-card-edit', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->post('/profile/card/delete-score', 'Api/ProfileController@deleteScore', ['name' => 'api-profile-card-delete-score', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/card/default-score', 'Api/ProfileController@defaultScore', ['name' => 'api-profile-card-default-score', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/card/add-score', 'Api/ProfileController@addScore', ['name' => 'api-profile-card-add-score', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/card/add-card', 'Api/ProfileController@addCard', ['name' => 'api-profile-card-add-card', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/profile/users-blacklist', 'Api/ProfileController@getUsersBlacklist', ['name' => 'api-profile-users-blacklist', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/delete-user-blacklist', 'Api/ProfileController@deleteUserBlacklist', ['name' => 'api-profile-delete-user-blacklist', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/geo/list', 'Api/GeoController@getCountriesAndDefaultCities', ['name' => 'api-geo-list', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/geo/search/combined', 'Api/GeoController@searchGeoCombined', ['name' => 'api-geo-search-geo-combined', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/catalog/search/items', 'Api/CatalogController@searchItems', ['name' => 'api-catalog-search-items', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/catalog/ads', 'Api/CatalogController@getAds', ['name' => 'api-catalog-ads', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/catalog/map/ads', 'Api/CatalogController@getAdsMap', ['name' => 'api-catalog-map-ads', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/catalog/ads-by-ids', 'Api/CatalogController@getAdsByIds', ['name' => 'api-catalog-ads-by-ids', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/catalog/snippets', 'Api/CatalogController@getSnippets', ['name' => 'api-catalog-snippets', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/catalog/ads-by-filters', 'Api/CatalogController@getAdsByFilters', ['name' => 'api-catalog-ads-by-filters', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/filters/options', 'Api/FiltersController@getOptions', ['name' => 'api-filters-options', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/filters/all', 'Api/FiltersController@getAllFilters', ['name' => 'api-filters-all', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/catalog/categories', 'Api/CatalogController@getCategories', ['name' => 'api-catalog-categories', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/catalog/save/search', 'Api/CatalogController@saveSearch', ['name' => 'api-catalog-save-search', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->post('/ad/create', 'Api/AdController@adCreate', ['name' => 'api-ad-create', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/ad/update', 'Api/AdController@adUpdate', ['name' => 'api-ad-update', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/ad/load', 'Api/AdController@adLoad', ['name' => 'api-ad-load', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/ad/options', 'Api/AdController@getOptions', ['name' => 'api-ad-options', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/ad/validation', 'Api/AdController@validation', ['name' => 'api-ad-validation', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/ad/create/services-tariffs-all', 'Api/AdController@getServicesTariffsAll', ['name' => 'api-ad-create-services-tariffs-all', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/geo/coordinates/decoding-address', 'Api/GeoController@decodingAddressByCoordinates', ['name' => 'api-geo-coordinates-decoding-address', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/geo/search/address', 'Api/GeoController@searchAddress', ['name' => 'api-geo-search-address', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/blog/posts', 'Api/BlogController@getPosts', ['name' => 'api-blog-posts', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/blog/post', 'Api/BlogController@getPost', ['name' => 'api-blog-post', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/shop/card', 'Api/ShopController@getData', ['name' => 'api-shop-card', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/shop/create', 'Api/ShopController@create', ['name' => 'api-shop-create', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/shop/load', 'Api/ShopController@load', ['name' => 'api-shop-load', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/shop/edit', 'Api/ShopController@edit', ['name' => 'api-shop-edit', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/shop/add-page', 'Api/ShopController@addPage', ['name' => 'api-shop-add-page', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/shop/delete-page', 'Api/ShopController@deletePage', ['name' => 'api-shop-delete-page', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/shop/edit-page', 'Api/ShopController@editPage', ['name' => 'api-shop-edit-page', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/shop/delete', 'Api/ShopController@deleteShop', ['name' => 'api-shop-delete', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/shop/search/items', 'Api/ShopController@searchItems', ['name' => 'api-shop-search-items', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->post('/shop/delete-banner', 'Api/ShopController@deleteBanner', ['name' => 'api-shop-delete-banner', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/profile/fortune/add-bonus', 'Api/ProfileController@fortuneAddBonus', ['name' => 'api-profile-fortune-add-bonus', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/chat/dialogues', 'Api/ChatController@getDialogues', ['name' => 'api-chat-dialogues', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/chat/count-messages', 'Api/ChatController@getCountMessages', ['name' => 'api-chat-count-messages', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/chat/clear-dialogues', 'Api/ChatController@clearDialogues', ['name' => 'api-chat-clear-dialogues', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/chat/send', 'Api/ChatController@send', ['name' => 'api-chat-send', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/chat/delete-message', 'Api/ChatController@deleteMessage', ['name' => 'api-chat-delete-message', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/chat/delete-dialogue', 'Api/ChatController@deleteDialogue', ['name' => 'api-chat-delete-dialogue', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/chat/dialogue', 'Api/ChatController@getDialogue', ['name' => 'api-chat-dialogue', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/chat/update-dialogue', 'Api/ChatController@updateDialogue', ['name' => 'api-chat-update-dialogue', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/chat/disable-notifications', 'Api/ChatController@disableNotifications', ['name' => 'api-chat-disable-notifications', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/chat/send-request-review', 'Api/ChatController@sendRequestReview', ['name' => 'api-chat-send-request-review', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/cart/data', 'Api/CartController@getData', ['name' => 'api-cart-data', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/cart/update', 'Api/CartController@update', ['name' => 'api-cart-update', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/cart/plus', 'Api/CartController@plusItem', ['name' => 'api-cart-plus-item', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/cart/minus', 'Api/CartController@minusItem', ['name' => 'api-cart-minus-item', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/cart/delete', 'Api/CartController@deleteItem', ['name' => 'api-cart-delete-item', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/cart/clear', 'Api/CartController@clearItems', ['name' => 'api-cart-clear-items', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/deal/checkout-data', 'Api/DealController@checkoutData', ['name' => 'api-deal-checkout-data', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/deal/add-recipient', 'Api/DealController@addRecipient', ['name' => 'api-deal-add-recipient', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/deal/order', 'Api/DealController@getOrder', ['name' => 'api-deal-order', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/deal/cancel-order', 'Api/DealController@cancelOrder', ['name' => 'api-deal-cancel-order', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/deal/change-status', 'Api/DealController@changeStatus', ['name' => 'api-deal-change-status', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/deal/add-disput', 'Api/DealController@addDisput', ['name' => 'api-deal-add-disput', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/deal/close-disput', 'Api/DealController@closeDisput', ['name' => 'api-deal-close-disput', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/delivery/search-points', 'Api/DeliveryController@searchPoints', ['name' => 'api-delivery-search-points', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/delivery/points-markers', 'Api/DeliveryController@pointsMarkers', ['name' => 'api-delivery-points-markers', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->get('/delivery/point-data', 'Api/DeliveryController@getPoint', ['name' => 'api-delivery-point-data', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/delivery/history', 'Api/DeliveryController@getHistory', ['name' => 'api-delivery-history', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/booking/data', 'Api/BookingController@getData', ['name' => 'api-booking-data', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);
    $this->container->router->post('/booking/create-order', 'Api/BookingController@createOrder', ['name' => 'api-booking-create-order', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

    $this->container->router->get('/referral/data', 'Api/ReferralController@getData', ['name' => 'api-referral-data', 'before' => ['AppTranslateMiddleware','ApiMiddleware']]);

});
