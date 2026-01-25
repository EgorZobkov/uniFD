<?php

$compile_core = true;

if(!copy(__dir__.'/files/app/Addons/Delivery/Yandex.php', BASE_PATH.'/app/Addons/Delivery/Yandex.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/app/Addons/Delivery/Yandex.php в директорию '.BASE_PATH.'/app/Addons/Delivery/';
}

if(!copy(__dir__.'/files/app/Addons/Maps/Google.php', BASE_PATH.'/app/Addons/Maps/Google.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/app/Addons/Maps/Google.php в директорию '.BASE_PATH.'/app/Addons/Maps/';
}

if(!copy(__dir__.'/files/app/Addons/Maps/Openmapstreet.php', BASE_PATH.'/app/Addons/Maps/Openmapstreet.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/app/Addons/Maps/Openmapstreet.php в директорию '.BASE_PATH.'/app/Addons/Maps/';
}

if(!copy(__dir__.'/files/app/Addons/Maps/Yandex.php', BASE_PATH.'/app/Addons/Maps/Yandex.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/app/Addons/Maps/Yandex.php в директорию '.BASE_PATH.'/app/Addons/Maps/';
}

if(!copy(__dir__.'/files/app/Addons/Payments/Tbank.php', BASE_PATH.'/app/Addons/Payments/Tbank.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/app/Addons/Payments/Tbank.php в директорию '.BASE_PATH.'/app/Addons/Payments/';
}

if(!copy(__dir__.'/files/app/Models/StoriesWaitingMakeCollage.php', BASE_PATH.'/app/Models/StoriesWaitingMakeCollage.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/app/Models/StoriesWaitingMakeCollage.php в директорию '.BASE_PATH.'/app/Models/';
}

if(!copy(__dir__.'/files/app/Http/Api.zip', BASE_PATH.'/app/Http/Controllers/Api.zip')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/app/Http/Api.zip в директорию '.BASE_PATH.'/app/Http/Controllers/';
}else{
	if($zip->open(BASE_PATH.'/app/Http/Controllers/Api.zip') === TRUE) {

		deleteFolder(BASE_PATH."/app/Http/Controllers/Api/");
	    $zip->extractTo(BASE_PATH.'/app/Http/Controllers/');
	    $zip->close();
	    unlink(BASE_PATH.'/app/Http/Controllers/Api.zip');

	}	
}

if(!copy(__dir__.'/files/view/dashboard/deals/card.tpl', BASE_PATH."/resources/view/".$app->config->app->dashboard_alias.'/deals/card.tpl')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/dashboard/deals/card.tpl в директорию '.BASE_PATH.'/resources/view/'.$app->config->app->dashboard_alias.'/deals/';
}



if(!copy(__dir__.'/files/routes/api.php', BASE_PATH.'/routes/api.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/routes/api.php в директорию '.BASE_PATH.'/routes/';
}

if(!copy(__dir__.'/files/routes/web.php', BASE_PATH.'/routes/web.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/routes/web.php в директорию '.BASE_PATH.'/routes/';
}

if(!copy(__dir__.'/files/storage/translations/app.tr', BASE_PATH.'/storage/translations/app.tr')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/storage/translations/app.tr в директорию '.BASE_PATH.'/storage/translations/';
}

if(!copy(__dir__.'/files/storage/translations/app.tr', BASE_PATH.'/storage/translations/ru/app.tr')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/storage/translations/app.tr в директорию '.BASE_PATH.'/storage/translations/ru/';
}

if(!copy(__dir__.'/files/view/web/ad-paid-services.tpl', BASE_PATH.'/resources/view/web/ad-paid-services.tpl')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/ad-paid-services.tpl в директорию '.BASE_PATH.'/resources/view/web/';
}

if(!copy(__dir__.'/files/view/web/ad-publication-success.tpl', BASE_PATH.'/resources/view/web/ad-publication-success.tpl')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/ad-publication-success.tpl в директорию '.BASE_PATH.'/resources/view/web/';
}

if(!copy(__dir__.'/files/view/web/cart-checkout.tpl', BASE_PATH.'/resources/view/web/cart-checkout.tpl')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/cart-checkout.tpl в директорию '.BASE_PATH.'/resources/view/web/';
}

if(!copy(__dir__.'/files/view/web/shop.tpl', BASE_PATH.'/resources/view/web/shop.tpl')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/shop.tpl в директорию '.BASE_PATH.'/resources/view/web/';
}

if(!copy(__dir__.'/files/view/web/shop-catalog.tpl', BASE_PATH.'/resources/view/web/shop-catalog.tpl')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/shop-catalog.tpl в директорию '.BASE_PATH.'/resources/view/web/';
}

if(!copy(__dir__.'/files/view/web/components/modals/ad-paid-services-search-user-items.tpl', BASE_PATH.'/resources/view/web/components/modals/ad-paid-services-search-user-items.tpl')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/components/modals/ad-paid-services-search-user-items.tpl в директорию '.BASE_PATH.'/resources/view/web/components/modals/';
}

if(!copy(__dir__.'/files/view/web/components/modals/delivery-history-modal.tpl', BASE_PATH.'/resources/view/web/components/modals/delivery-history-modal.tpl')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/components/modals/delivery-history-modal.tpl в директорию '.BASE_PATH.'/resources/view/web/components/modals/';
}

if(!copy(__dir__.'/files/view/web/components/modals/delivery-points-modal.tpl', BASE_PATH.'/resources/view/web/components/modals/delivery-points-modal.tpl')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/components/modals/delivery-points-modal.tpl в директорию '.BASE_PATH.'/resources/view/web/components/modals/';
}

$css = file_get_contents($app->config->storage->files.'/'.$filename.'/files/view/web/css/main.css');

if($css){
	if(file_put_contents(BASE_PATH.'/resources/view/web/assets/css/main.css', $css, FILE_APPEND)){
		$update_result[] = "Добавлены стили в файл main.css";
	}else{
		$update_errors[] = "Не удалось добавить стили в файл main.css в директорию ".BASE_PATH.'/resources/view/web/assets/css/';
	}
}

if(!copy(__dir__.'/files/view/web/js/ad_paid_services.js', BASE_PATH.'/resources/view/web/assets/js/ad_paid_services.js')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/js/ad_paid_services.js в директорию '.BASE_PATH.'/resources/view/web/assets/js';
}

if(!copy(__dir__.'/files/view/web/js/cart.js', BASE_PATH.'/resources/view/web/assets/js/cart.js')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/js/cart.js в директорию '.BASE_PATH.'/resources/view/web/assets/js';
}

if(!copy(__dir__.'/files/view/web/js/chat.js', BASE_PATH.'/resources/view/web/assets/js/chat.js')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/js/chat.js в директорию '.BASE_PATH.'/resources/view/web/assets/js';
}

if(!copy(__dir__.'/files/view/web/js/helpers.class.js', BASE_PATH.'/resources/view/web/assets/js/helpers.class.js')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/js/helpers.class.js в директорию '.BASE_PATH.'/resources/view/web/assets/js';
}

if(!copy(__dir__.'/files/view/web/js/main.js', BASE_PATH.'/resources/view/web/assets/js/main.js')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/js/main.js в директорию '.BASE_PATH.'/resources/view/web/assets/js';
}

if(!copy(__dir__.'/files/view/web/js/profile.js', BASE_PATH.'/resources/view/web/assets/js/profile.js')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/js/profile.js в директорию '.BASE_PATH.'/resources/view/web/assets/js';
}

if(!copy(__dir__.'/files/view/web/js/transaction.js', BASE_PATH.'/resources/view/web/assets/js/transaction.js')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/js/transaction.js в директорию '.BASE_PATH.'/resources/view/web/assets/js';
}

if(!copy(__dir__.'/files/view/web/order/buy.tpl', BASE_PATH.'/resources/view/web/order/buy.tpl')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/order/buy.tpl в директорию '.BASE_PATH.'/resources/view/web/order/';
}

if(!copy(__dir__.'/files/view/web/order/card.tpl', BASE_PATH.'/resources/view/web/order/card.tpl')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/order/card.tpl в директорию '.BASE_PATH.'/resources/view/web/order/';
}

if(!copy(__dir__.'/files/view/web/profile/settings.tpl', BASE_PATH.'/resources/view/web/profile/settings.tpl')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/view/web/profile/settings.tpl в директорию '.BASE_PATH.'/resources/view/web/profile/';
}

if(!copy(__dir__.'/files/core/components/AdPaidServices/activation.php', BASE_PATH.'/core/components/contents/AdPaidServices/activation.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/AdPaidServices/activation.php в директорию '.BASE_PATH.'/core/components/contents/AdPaidServices/';
}

if(!copy(__dir__.'/files/core/components/AdPaidServices/outItemsWaitingList.php', BASE_PATH.'/core/components/contents/AdPaidServices/outItemsWaitingList.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/AdPaidServices/outItemsWaitingList.php в директорию '.BASE_PATH.'/core/components/contents/AdPaidServices/';
}

if(!copy(__dir__.'/files/core/components/AdPaidServices/outServices.php', BASE_PATH.'/core/components/contents/AdPaidServices/outServices.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/AdPaidServices/outServices.php в директорию '.BASE_PATH.'/core/components/contents/AdPaidServices/';
}

if(!copy(__dir__.'/files/core/components/AdPaidServices/searchItemsWaitingList.php', BASE_PATH.'/core/components/contents/AdPaidServices/searchItemsWaitingList.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/AdPaidServices/searchItemsWaitingList.php в директорию '.BASE_PATH.'/core/components/contents/AdPaidServices/';
}

if(!copy(__dir__.'/files/core/components/Delivery/calculationData.php', BASE_PATH.'/core/components/contents/Delivery/calculationData.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Delivery/calculationData.php в директорию '.BASE_PATH.'/core/components/contents/Delivery/';
}

if(!copy(__dir__.'/files/core/components/Delivery/cancelOrder.php', BASE_PATH.'/core/components/contents/Delivery/cancelOrder.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Delivery/cancelOrder.php в директорию '.BASE_PATH.'/core/components/contents/Delivery/';
}

if(!copy(__dir__.'/files/core/components/Delivery/hasAvailableDelivery.php', BASE_PATH.'/core/components/contents/Delivery/hasAvailableDelivery.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Delivery/hasAvailableDelivery.php в директорию '.BASE_PATH.'/core/components/contents/Delivery/';
}

if(!copy(__dir__.'/files/core/components/Delivery/outDeliveryListInCart.php', BASE_PATH.'/core/components/contents/Delivery/outDeliveryListInCart.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Delivery/outDeliveryListInCart.php в директорию '.BASE_PATH.'/core/components/contents/Delivery/';
}

if(!copy(__dir__.'/files/core/components/Delivery/outDeliveryListInOrder.php', BASE_PATH.'/core/components/contents/Delivery/outDeliveryListInOrder.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Delivery/outDeliveryListInOrder.php в директорию '.BASE_PATH.'/core/components/contents/Delivery/';
}

if(!copy(__dir__.'/files/core/components/Delivery/outDeliveryListInProfile.php', BASE_PATH.'/core/components/contents/Delivery/outDeliveryListInProfile.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Delivery/outDeliveryListInProfile.php в директорию '.BASE_PATH.'/core/components/contents/Delivery/';
}

if(!copy(__dir__.'/files/core/components/Delivery/outHistoryData.php', BASE_PATH.'/core/components/contents/Delivery/outHistoryData.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Delivery/outHistoryData.php в директорию '.BASE_PATH.'/core/components/contents/Delivery/';
}

if(!copy(__dir__.'/files/core/components/Delivery/searchPoints.php', BASE_PATH.'/core/components/contents/Delivery/searchPoints.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Delivery/searchPoints.php в директорию '.BASE_PATH.'/core/components/contents/Delivery/';
}

if(!copy(__dir__.'/files/core/components/Delivery/updateHistoryData.php', BASE_PATH.'/core/components/contents/Delivery/updateHistoryData.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Delivery/updateHistoryData.php в директорию '.BASE_PATH.'/core/components/contents/Delivery/';
}

if(!copy(__dir__.'/files/core/components/Profile/outMethodAddScoreUser.php', BASE_PATH.'/core/components/contents/Profile/outMethodAddScoreUser.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Profile/outMethodAddScoreUser.php в директорию '.BASE_PATH.'/core/components/contents/Profile/';
}

if(!copy(__dir__.'/files/core/components/Stories/addWaitingMakeCollage.php', BASE_PATH.'/core/components/contents/Stories/addWaitingMakeCollage.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Stories/addWaitingMakeCollage.php в директорию '.BASE_PATH.'/core/components/contents/Stories/';
}

if(!copy(__dir__.'/files/core/components/Stories/makeCollageItemAndPublication.php', BASE_PATH.'/core/components/contents/Stories/makeCollageItemAndPublication.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Stories/makeCollageItemAndPublication.php в директорию '.BASE_PATH.'/core/components/contents/Stories/';
}

if(!copy(__dir__.'/files/core/components/Stories/publication.php', BASE_PATH.'/core/components/contents/Stories/publication.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Stories/publication.php в директорию '.BASE_PATH.'/core/components/contents/Stories/';
}

if(!copy(__dir__.'/files/core/components/Transaction/addSolutionDisputeDeal.php', BASE_PATH.'/core/components/contents/Transaction/addSolutionDisputeDeal.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/addSolutionDisputeDeal.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Transaction/calculationDealProfit.php', BASE_PATH.'/core/components/contents/Transaction/calculationDealProfit.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/calculationDealProfit.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Transaction/callback.php', BASE_PATH.'/core/components/contents/Transaction/callback.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/callback.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Transaction/cancelDeal.php', BASE_PATH.'/core/components/contents/Transaction/cancelDeal.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/cancelDeal.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Transaction/changeStatusDeal.php', BASE_PATH.'/core/components/contents/Transaction/changeStatusDeal.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/changeStatusDeal.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Transaction/createDeal.php', BASE_PATH.'/core/components/contents/Transaction/createDeal.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/createDeal.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Transaction/getDealByOrderId.php', BASE_PATH.'/core/components/contents/Transaction/getDealByOrderId.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/getDealByOrderId.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Transaction/getDealItem.php', BASE_PATH.'/core/components/contents/Transaction/getDealItem.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/getDealItem.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Transaction/initPaymentCart.php', BASE_PATH.'/core/components/contents/Transaction/initPaymentCart.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/initPaymentCart.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Transaction/initPaymentItem.php', BASE_PATH.'/core/components/contents/Transaction/initPaymentItem.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/initPaymentItem.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Transaction/outActionsOrderDeal.php', BASE_PATH.'/core/components/contents/Transaction/outActionsOrderDeal.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/outActionsOrderDeal.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Transaction/paymentCardAdd.php', BASE_PATH.'/core/components/contents/Transaction/paymentCardAdd.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/paymentCardAdd.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Transaction/paymentCardDelete.php', BASE_PATH.'/core/components/contents/Transaction/paymentCardDelete.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/paymentCardDelete.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Transaction/calculationDealProfitUserPayments.php', BASE_PATH.'/core/components/contents/Transaction/calculationDealProfitUserPayments.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Transaction/calculationDealProfitUserPayments.php в директорию '.BASE_PATH.'/core/components/contents/Transaction/';
}

if(!copy(__dir__.'/files/core/components/Geo/outMapDeliveryPoints.php', BASE_PATH.'/core/components/contents/Geo/outMapDeliveryPoints.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/components/Geo/outMapDeliveryPoints.php в директорию '.BASE_PATH.'/core/components/contents/Geo/';
}



if(!copy(__dir__.'/files/core/controllers/web/AdCardController/showContacts.php', BASE_PATH.'/core/controllers/web/AdCardController/showContacts.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/AdCardController/showContacts.php в директорию '.BASE_PATH.'/core/controllers/web/AdCardController/';
}

if(!copy(__dir__.'/files/core/controllers/web/AdPaidServicesController/searchUserItems.php', BASE_PATH.'/core/controllers/web/AdPaidServicesController/searchUserItems.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/AdPaidServicesController/searchUserItems.php в директорию '.BASE_PATH.'/core/controllers/web/AdPaidServicesController/';
}

if(!copy(__dir__.'/files/core/controllers/web/AdPaidServicesController/updateCount.php', BASE_PATH.'/core/controllers/web/AdPaidServicesController/updateCount.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/AdPaidServicesController/updateCount.php в директорию '.BASE_PATH.'/core/controllers/web/AdPaidServicesController/';
}

if(!copy(__dir__.'/files/core/controllers/web/CartController/goCheckout.php', BASE_PATH.'/core/controllers/web/CartController/goCheckout.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/CartController/goCheckout.php в директорию '.BASE_PATH.'/core/controllers/web/CartController/';
}

if(!copy(__dir__.'/files/core/controllers/web/CronController/deliveryHistory.php', BASE_PATH.'/core/controllers/web/CronController/deliveryHistory.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/CronController/deliveryHistory.php в директорию '.BASE_PATH.'/core/controllers/web/CronController/';
}

if(!copy(__dir__.'/files/core/controllers/web/CronController/storiesMakeCollage.php', BASE_PATH.'/core/controllers/web/CronController/storiesMakeCollage.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/CronController/storiesMakeCollage.php в директорию '.BASE_PATH.'/core/controllers/web/CronController/';
}

if(!copy(__dir__.'/files/core/controllers/web/MapController/loadDeliveryPointItem.php', BASE_PATH.'/core/controllers/web/MapController/loadDeliveryPointItem.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/MapController/loadDeliveryPointItem.php в директорию '.BASE_PATH.'/core/controllers/web/MapController/';
}

if(!copy(__dir__.'/files/core/controllers/web/MapController/loadDeliveryPointsMarkers.php', BASE_PATH.'/core/controllers/web/MapController/loadDeliveryPointsMarkers.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/MapController/loadDeliveryPointsMarkers.php в директорию '.BASE_PATH.'/core/controllers/web/MapController/';
}

if(!copy(__dir__.'/files/core/controllers/web/ProfileController/deliveryAddPoint.php', BASE_PATH.'/core/controllers/web/ProfileController/deliveryAddPoint.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/ProfileController/deliveryAddPoint.php в директорию '.BASE_PATH.'/core/controllers/web/ProfileController/';
}

if(!copy(__dir__.'/files/core/controllers/web/ProfileController/paymentCardAdd.php', BASE_PATH.'/core/controllers/web/ProfileController/paymentCardAdd.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/ProfileController/paymentCardAdd.php в директорию '.BASE_PATH.'/core/controllers/web/ProfileController/';
}

if(!copy(__dir__.'/files/core/controllers/web/ProfileController/paymentScoreDelete.php', BASE_PATH.'/core/controllers/web/ProfileController/paymentScoreDelete.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/ProfileController/paymentScoreDelete.php в директорию '.BASE_PATH.'/core/controllers/web/ProfileController/';
}

if(!copy(__dir__.'/files/core/controllers/web/ShopController/shop.php', BASE_PATH.'/core/controllers/web/ShopController/shop.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/ShopController/shop.php в директорию '.BASE_PATH.'/core/controllers/web/ShopController/';
}

if(!copy(__dir__.'/files/core/controllers/web/TransactionsController/changeStatusDeal.php', BASE_PATH.'/core/controllers/web/TransactionsController/changeStatusDeal.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/TransactionsController/changeStatusDeal.php в директорию '.BASE_PATH.'/core/controllers/web/TransactionsController/';
}

if(!copy(__dir__.'/files/core/controllers/web/TransactionsController/disputeClose.php', BASE_PATH.'/core/controllers/web/TransactionsController/disputeClose.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/controllers/web/TransactionsController/disputeClose.php в директорию '.BASE_PATH.'/core/controllers/web/TransactionsController/';
}

if(!copy(__dir__.'/files/core/systems/Api/getSettings.php', BASE_PATH.'/core/systems/Api/getSettings.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/systems/Api/getSettings.php в директорию '.BASE_PATH.'/core/systems/Api/';
}

if(!copy(__dir__.'/files/core/systems/Api/outInfoPaymentsOrderDeal.php', BASE_PATH.'/core/systems/Api/outInfoPaymentsOrderDeal.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/systems/Api/outInfoPaymentsOrderDeal.php в директорию '.BASE_PATH.'/core/systems/Api/';
}

if(!copy(__dir__.'/files/core/systems/Api/storiesPublication.php', BASE_PATH.'/core/systems/Api/storiesPublication.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/systems/Api/storiesPublication.php в директорию '.BASE_PATH.'/core/systems/Api/';
}

if(!copy(__dir__.'/files/core/systems/Api/usersStoriesData.php', BASE_PATH.'/core/systems/Api/usersStoriesData.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/systems/Api/usersStoriesData.php в директорию '.BASE_PATH.'/core/systems/Api/';
}

if(!copy(__dir__.'/files/core/systems/Api/userStoriesData.php', BASE_PATH.'/core/systems/Api/userStoriesData.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/systems/Api/userStoriesData.php в директорию '.BASE_PATH.'/core/systems/Api/';
}

if(!copy(__dir__.'/files/core/systems/Ui/managerModal.php', BASE_PATH.'/core/systems/Ui/managerModal.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/systems/Ui/managerModal.php в директорию '.BASE_PATH.'/core/systems/Ui/';
}

if(!copy(__dir__.'/files/core/systems/Ui/outInputPhoneContact.php', BASE_PATH.'/core/systems/Ui/outInputPhoneContact.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/core/systems/Ui/outInputPhoneContact.php в директорию '.BASE_PATH.'/core/systems/Ui/';
}

if(!copy(__dir__.'/files/app/Systems/Clean.php', BASE_PATH.'/app/Systems/Clean.php')){
	$update_errors[] = 'Не удалось скопировать файл '.__dir__.'/files/app/Systems/Clean.php в директорию '.BASE_PATH.'/app/Systems/';
}

// Tables

if($app->db->exec("SHOW TABLES LIKE 'uni_system_cron_tasks'")){
	$app->db->exec("DROP TABLE `uni_system_cron_tasks`");
}
if($app->db->exec("SHOW TABLES LIKE 'uni_delivery_points'")){
	$app->db->exec("DROP TABLE `uni_delivery_points`");
}
if($app->db->exec("SHOW TABLES LIKE 'uni_translations_default_content'")){
	$app->db->exec("DROP TABLE `uni_translations_default_content`");
}
if($app->db->exec("SHOW TABLES LIKE 'uni_system_delivery_services'")){
	$app->db->exec("DROP TABLE `uni_system_delivery_services`");
}

$tables = glob(__dir__.'/files/tables/*.sql');

if (count($tables)) {
	foreach ($tables as $path) {
		$info = pathinfo($path);
		if(!$app->db->exec("SHOW TABLES LIKE '".$info['filename']."'")){
			$app->db->exec(file_get_contents($path));
		}
	}
}

$result = $app->db->exec("SHOW COLUMNS FROM `uni_stories_media` LIKE 'duration'");
if(!$result){
    $app->db->exec("ALTER TABLE `uni_stories_media` ADD COLUMN duration FLOAT NOT NULL DEFAULT '0'");
}

$result = $app->db->exec("SHOW COLUMNS FROM `uni_transactions_deals` LIKE 'delivery_history_data'");
if(!$result){
    $app->db->exec("ALTER TABLE `uni_transactions_deals` ADD COLUMN delivery_history_data TEXT NULL DEFAULT NULL");
}

$result = $app->db->exec("SHOW COLUMNS FROM `uni_transactions_deals` LIKE 'delivery_amount'");
if(!$result){
    $app->db->exec("ALTER TABLE `uni_transactions_deals` ADD COLUMN delivery_amount FLOAT NOT NULL DEFAULT '0'");
}

$result = $app->db->exec("SHOW COLUMNS FROM `uni_users_payment_data` LIKE 'card_id'");
if(!$result){
    $app->db->exec("ALTER TABLE `uni_users_payment_data` ADD COLUMN card_id VARCHAR(255) NULL");
}

$result = $app->db->exec("SHOW COLUMNS FROM `uni_users_shipping_points` LIKE 'point_code'");
if(!$result){
    $app->db->exec("ALTER TABLE `uni_users_shipping_points` ADD COLUMN point_code VARCHAR(255) NULL");
}

if(!$app->model->settings->find("name=?", ["phone_add_plus_status"])){
	$app->model->settings->insert(["name"=>"phone_add_plus_status", "value"=>"1"]);
}

$app->model->system_payment_services->update(["secure_deal_available"=>1, "secure_deal_status"=>1, "type_score"=>"add_card"], ["alias=?",["tbank"]]);

// Update lang content

$app->translate->updateTables();
$app->translate->updateContent();

?>