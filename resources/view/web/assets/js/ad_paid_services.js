import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   var copyUserItemsList = $(".ad-paid-services-ads-list").html();

   $(document).on('click','.ad-paid-services-list-item', function (e) {

      $(".ad-paid-services-action-payment").hide();
      $(".ad-paid-services-list-item").removeClass("active");
      $(this).addClass("active");

      e.preventDefault();

   });

   $(document).on('click','.ad-paid-services-list-item:not(.added)', function (e) {


      $(".ad-paid-services-form input[name=service_id]").val($(this).data("id"));
      $(".ad-paid-services-action-payment").hide();
      $(this).find(".ad-paid-services-action-payment").show();

      e.preventDefault();

   });

   $(document).on('click','.ad-paid-services-list-item-content .bt_minus', function (e) {

      var parent = $(this).parents(".ad-paid-services-list-item");

      var count = parseInt(parent.find(".ad-paid-services-list-item-count").val());

      if(count > 1){
         count = count - 1;
      }else{
         count = 1;
      }

      parent.find(".ad-paid-services-list-item-count").val(count);

      helpers.request({url:"ad-services-update-count-item", data: {service_id: $('.ad-paid-services-form input[name=service_id]').val(), count: count}}, function(data) {

        parent.find(".ad-paid-services-list-item-price-now").html(data["price_now"]);
        parent.find(".ad-paid-services-list-item-price-old").html(data["price_old"]);
        parent.find(".quantity").html(data["count"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.ad-paid-services-list-item-content .bt_plus', function (e) {

      var parent = $(this).parents(".ad-paid-services-list-item");

      var count = parseInt(parent.find(".ad-paid-services-list-item-count").val());

      count = count + 1;

      parent.find(".ad-paid-services-list-item-count").val(count);

      helpers.request({url:"ad-services-update-count-item", data: {service_id: $('.ad-paid-services-form input[name=service_id]').val(), count: count}}, function(data) {

        parent.find(".ad-paid-services-list-item-price-now").html(data["price_now"]);
        parent.find(".ad-paid-services-list-item-price-old").html(data["price_old"]);
        parent.find(".quantity").html(data["count"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.initOptionsPaymentServices', function (e) {  

      helpers.startProcessLoadButton($('.initOptionsPaymentServices'));

      helpers.request({url:"payment-load-option", data: $(".ad-paid-services-form").serialize(), precheck: true, button:$('.initOptionsPaymentServices')}, function(data) {

         $("#paymentModal .modal-payment-container").html(data["content"]);
         helpers.openModal("paymentModal");
         helpers.endProcessLoadButton($('.initOptionsPaymentServices'));
         
      });

      e.preventDefault();

   });

   $(document).on('input','.ad-paid-services-ads-container input', function (e) {  

      helpers.request({url:"ad-services-search-user-items", data: {query: $(this).val()}}, function(data) {

         if(data["status"] == true){
            $(".ad-paid-services-ads-list").html(data["answer"]);
         }else{
            $(".ad-paid-services-ads-list").html(copyUserItemsList);
         }
         
      });

      e.preventDefault();

   });

});