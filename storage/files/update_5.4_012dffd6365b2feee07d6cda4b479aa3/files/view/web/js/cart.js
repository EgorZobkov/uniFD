import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   var updateCartTimeout = null;
   var changeItemIdByDelivery = 0;

   updateCart();
   updateCount();

   $(document).on('click','.actionAddToCart', function (e) {  

      var _this = this;

      if($(_this).data("route") != undefined){

         location.href = $(_this).data("route");

      }else{

         helpers.startProcessLoadButton($(_this));

         helpers.request({url:"cart-add", data: {item_id: $(_this).data("id")}}, function(data) {

            if(data["answer"] != undefined){
               helpers.showNotice("error", data["answer"]);
            }

            if(data["label"] != undefined){
               $(_this).html(data["label"]);
            }

            if(data["route"] != undefined){
               $(_this).attr("data-route", data["route"]);
            }

            updateCount();

            helpers.endProcessLoadButton($(_this));
            
         });

      }

      e.preventDefault();

   });

   $(document).on('click','.actionDeleteItemCart', function (e) {  

      helpers.request({url:"cart-item-delete", data: {id: $(this).data("id")}}, function(data) {

         location.reload();
         
      });

      e.preventDefault();

   });

   $(document).on('change','#cart-check-all', function (e) {

       if($(this).prop("checked") == true){
          $('.cart-form input.cartCheckboxItem').prop("checked", true);
       }else{
          $('.cart-form input.cartCheckboxItem').prop("checked", false);
       }

       updateCart();

   });

   $(document).on('change','.cart-form input.cartCheckboxItem', function (e) {

       updateCart();

   });

   
   $(document).on('click','.actionMinusCountItemCart', function (e) {  

      if (updateCartTimeout != null) {
        clearTimeout(updateCartTimeout);
      }

      var _this = this;

      helpers.request({url:"cart-item-minus-count", data: {id: $(_this).data("id")}}, function(data) {

         $(_this).parents(".cart-ad-card-item").find(".quantity").html(data["count"]);
         $(_this).parents(".cart-ad-card-item").find(".cart-ad-card-item-content-prices").html(data["price"]);

         updateCartTimeout = setTimeout(function() {
            updateCart();
            updateCount();
         }, 300);

      });

      e.preventDefault();

   });

   $(document).on('click','.actionPlusCountItemCart', function (e) {  

      if (updateCartTimeout != null) {
        clearTimeout(updateCartTimeout);
      }

      var _this = this;

      helpers.request({url:"cart-item-plus-count", data: {id: $(_this).data("id")}}, function(data) {

         $(_this).parents(".cart-ad-card-item").find(".quantity").html(data["count"]);
         $(_this).parents(".cart-ad-card-item").find(".cart-ad-card-item-content-prices").html(data["price"]);

         updateCartTimeout = setTimeout(function() {
            updateCart();
            updateCount();
         }, 300);

      });

      e.preventDefault();

   });

   function updateCount(){

      helpers.request({url:"cart-update-count"}, function(data) {

         if(data["count"]){
            $(".labelCartCountItems").html(data["count"]).css("display", "inline-flex");
         }else{
            $(".labelCartCountItems").hide();
         }
         
      });

   }

   function updateCart(){

      if($(".cart-form").length){

         helpers.request({url:"cart-update", data: $(".cart-form").serialize()}, function(data) {

            if(parseInt(data["total_count"]) != 0){
               $(".cartLabelCountItems").html(data["total_count"]);
               $(".cartLabelTotalAmount").html(data["total_amount"]);
               $(".cart-sidebar-selected-items").show();
               $(".cart-sidebar-not-selected-items").hide();
            }else{
               $(".cart-sidebar-selected-items").hide();
               $(".cart-sidebar-not-selected-items").show(); 
            }
            
         });

      }

   }

   $(document).on('click','.actionCartGoCheckout', function (e) {  

      helpers.startProcessLoadButton($('.actionCartGoCheckout'));

      helpers.request({url:"cart-gocheckout", data: $(".cart-form").serialize(), precheck: true, button: $('.actionCartGoCheckout')}, function(data) {

         location.href = data["redirect"];

      });

      e.preventDefault();

   });

   $(document).on('click','.actionCartToPayment', function (e) {  

      helpers.startProcessLoadButton($('.actionCartToPayment'));

      helpers.request({url:"cart-payment", data: {session: $(this).data("session"), delivery_points: $(".cart-item-delivery-points").serialize()}, precheck: true, button: $('.actionCartToPayment')}, function(data) {

         if(data["status"]){
            if(data["link"] != undefined){
                location.href = data["link"];
            }else{
                location.reload();
            }
         }else{
            helpers.showNotice("error", data["answer"]);
            helpers.endProcessLoadButton($('.actionCartToPayment'));
         }

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

   function updateTotalAmount(){

      var delivery_total_amount = 0;

      $("input.cart-item-delivery-amount").each(function() {

         if($(this).val() != 0){
            delivery_total_amount += parseFloat($(this).val());
         }

      });

      if(delivery_total_amount){
         $(".order-buy-card-delivery-total-amount").html(helpers.amount(delivery_total_amount));
         $(".cartLabelTotalAmount").html(helpers.amount($(".cartLabelTotalAmount").data("total-amount") + delivery_total_amount));
      }else{
         $(".cartLabelTotalAmount").html(helpers.amount($(".cartLabelTotalAmount").data("total-amount")));
         $(".order-buy-card-delivery-list-box").hide();
      }

   }

   $(document).on('click','.actionCartChangeDelivery', function (e) {  

      if($(this).data("id") != "0"){
          changeItemIdByDelivery = $(this).data("item-id");
      }else{
          $(".cart-ad-card-item-"+$(this).data("item-id")+" .cart-ad-card-item-delivery-name").html($(this).data("name"));
          $(".cart-ad-card-item-"+$(this).data("item-id")+" input.cart-item-delivery-points").val("0");    
          $(".cart-ad-card-item-"+$(this).data("item-id")+" input.cart-item-delivery-amount").val("0");
          helpers.hideModal("cartChangeDeliveryModal"); 
      }

      updateTotalAmount();

      e.preventDefault();

   });

   $(document).on('click','.actionChangePointMapDelivery', function () {

        $(".delivery-points-map-sidebar-modal").hide();    
        helpers.hideModal("deliveryPointsModal");

        $(".cart-ad-card-item-"+changeItemIdByDelivery+" .cart-ad-card-item-delivery-name").html($(this).data("point"));
        $(".cart-ad-card-item-"+changeItemIdByDelivery+" input.cart-item-delivery-points").val($(this).data("id")); 

        if($(this).data("delivery-amount") != undefined){

           $(".cart-ad-card-item-"+changeItemIdByDelivery+" input.cart-item-delivery-amount").val($(this).data("delivery-amount"));

           $(".order-buy-card-delivery-list-box").show();

           updateTotalAmount();

        }

   });

});