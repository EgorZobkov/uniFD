import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   if($('.ad-card-media-slider-swiper').length){
      new Swiper(document.querySelector('.ad-card-media-slider-swiper'), {
         loop: false,
         slidesPerView: "auto",
         spaceBetween: 10,        
         navigation: {
           nextEl: '.ad-card-media-slider-nav-right',
           prevEl: '.ad-card-media-slider-nav-left',
         },
      });
   }

   $(document).on('click','.initPaymentItemSecureDeal', function (e) {  

      helpers.startProcessLoadButton($('.initPaymentItemSecureDeal'));

      helpers.request({url:"payment-item", data: {id: $(this).data("id"), delivery_point_id: $("input[name=delivery_point_id]").val()}, precheck: true, button: $('.initPaymentItemSecureDeal')}, function(data) {

         if(data["status"]){
            if(data["link"] != undefined){
                location.href = data["link"];
            }else{
                location.reload();
            }
         }else{
            helpers.showNotice("error", data["answer"]);
            helpers.endProcessLoadButton($('.initPaymentItemSecureDeal'));
         }
  
      });

      e.preventDefault();

   });

   $(document).on('click','.initPaymentOrderSecureDeal', function (e) {  

      helpers.startProcessLoadButton($('.initPaymentOrderSecureDeal'));

      helpers.request({url:"payment-order", data: {id: $(this).data("id")}, precheck: true, button: $('.initPaymentOrderSecureDeal')}, function(data) {

         if(data["status"]){
            if(data["link"] != undefined){
                location.href = data["link"];
            }else{
                location.reload();
            }
         }else{
            helpers.showNotice("error", data["answer"]);
            helpers.endProcessLoadButton($('.initPaymentOrderSecureDeal'));
         }
  
      });

      e.preventDefault();

   });

   $(document).on('click','.actionChangeStatusOrderDeal', function (e) {  

      helpers.startProcessLoadButton($('.actionChangeStatusOrderDeal'));

      helpers.request({url:"order-deal-change-status", data: {id: $(this).data("id"), status: $(this).data("status")}}, function(data) {

         if(data["status"]){
            location.reload();
         }else{
            helpers.showNotice("error", data["answer"]);
            helpers.endProcessLoadButton($('.actionChangeStatusOrderDeal'));
         }
  
      });

      e.preventDefault();

   });

   $(document).on('click','.actionAddPaymentScoreOrderDeal', function (e) {  

      helpers.startProcessLoadButton($('.actionAddPaymentScoreOrderDeal'));

      helpers.request({url:"order-deal-add-payment-score", data: {score: $("input[name=payment_score]").val(), order_id: $("input[name=deal_order_id]").val()}}, function(data) {

         if(data["status"]){
            location.reload();
         }else{
            helpers.showNotice("error", data["answer"]);
            helpers.endProcessLoadButton($('.actionAddPaymentScoreOrderDeal'));
         }
  
      });

      e.preventDefault();

   });

   $(document).on('click','.actionCancelOrderDeal', function (e) {  

      helpers.startProcessLoadButton($('.actionCancelOrderDeal'));

      helpers.request({url:"order-deal-cancel", data: {reason: $("textarea[name=deal_reason_cancel]").val(), order_id: $(this).data("id")}}, function(data) {

         if(data["status"]){
            location.reload();
         }else{
            helpers.showNotice("error", data["answer"]);
            helpers.endProcessLoadButton($('.actionCancelOrderDeal'));
         }
  
      });

      e.preventDefault();

   });

   $(document).on('click','.actionOpenDisputeOrderDeal', function (e) {  

      helpers.startProcessLoadButton($('.actionOpenDisputeOrderDeal'));

      helpers.request({url:"order-deal-dispute-add", data: $(".order-deal-dispute-form").serialize()}, function(data) {

         if(data["status"]){
            location.reload();
         }else{
            helpers.showNotice("error", data["answer"]);
            helpers.endProcessLoadButton($('.actionOpenDisputeOrderDeal'));
         }
  
      });

      e.preventDefault();

   });

   $(document).on('click','.actionCloseDisputeOrderDeal', function (e) {  

      helpers.startProcessLoadButton($('.actionCloseDisputeOrderDeal'));

      helpers.request({url:"order-deal-dispute-close", data: {id: $(this).data("id")}}, function(data) {

         location.reload();
  
      });

      e.preventDefault();

   });

   $(document).on('submit','.order-buy-delivery-recipient-form', function (e) {  

      helpers.startProcessLoadButton($('.actionSaveDeliveryRecipient'));

      $('.order-buy-delivery-recipient-form .form-label-error').hide();

      helpers.request({url:"order-delivery-save-recipient", data: $(this).serialize()}, function(data) {

         if(data["status"]){
            $(".order-buy-delivery-recipient-data").html( `<div>` + $(".order-buy-delivery-recipient-form input[name=delivery_recipient_name]").val()+' '+$(".order-buy-delivery-recipient-form input[name=delivery_recipient_patronymic]").val()+' '+$(".order-buy-delivery-recipient-form input[name=delivery_recipient_surname]").val()+' <br> '+$(".order-buy-delivery-recipient-form input[name=delivery_recipient_phone]").val()+' <br> '+$(".order-buy-delivery-recipient-form input[name=delivery_recipient_email]").val() + `</div>`);
            helpers.hideModal("orderDeliveryRecipientModal");
         }else{
            helpers.formNoticeManager($('.order-buy-delivery-recipient-form'), data);
         }

         helpers.endProcessLoadButton($('.actionSaveDeliveryRecipient'));

      });

      e.preventDefault();

   });

   $(document).on('click','.actionCloseSidebarMapDelivery', function () {
        
        $(".delivery-points-map-sidebar-modal").hide();    
      
   });

   $(document).on('click','.actionBuyChangeDelivery', function (e) {  

      $(".actionBuyChangeDelivery").removeClass("active");
      $(".actionBuyChangeDelivery[data-id="+$(this).data("id")+"]").addClass("active");

      if($(this).data("id") != "0"){
          $(".order-buy-delivery-recipient").show();
          $(".order-buy-card-info").hide();
      }else{
          $(".order-buy-card-info").show();
          $(".order-buy-delivery-recipient").hide();
          $(".order-buy-delivery-point").hide();
          $(".order-buy-delivery-point-data").html("");
          $("input[name=delivery_point_id]").val("0");
          $(".order-buy-card-delivery-list-box").hide();
          $(".order-buy-card-total-amount").html(helpers.amount($(".order-buy-card-total-amount").data("total-amount")));
      }

      e.preventDefault();

   });

   $(document).on('click','.actionChangePointMapDelivery', function () {
        
        $(".delivery-points-map-sidebar-modal").hide();    
        helpers.hideModal("deliveryPointsModal");

        $(".order-buy-delivery-point").show();
        $(".order-buy-delivery-point-data").html($(this).data("point"));
        $("input[name=delivery_point_id]").val($(this).data("id"));

        if($(this).data("delivery-amount") != undefined){
           $(".order-buy-card-delivery-list-box").show();
           $(".order-buy-card-delivery-total-amount").html(helpers.amount($(this).data("delivery-amount")));
           $(".order-buy-card-total-amount").html(helpers.amount($(".order-buy-card-total-amount").data("total-amount") + $(this).data("delivery-amount")));
        }
      
   });

});