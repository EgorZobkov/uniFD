import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   var currentDatesBookingCalendar = [];
   var datesDisabledBookingCalendar = [];
   var startDateBookingCalendar;
   var endDateBookingCalendar;

   bookingCalendarLoadData();

   if($('.content-info-box-swiper').length){
      new Swiper(document.querySelector('.content-info-box-swiper'), {
         loop: false,
         slidesPerView: "auto",
         spaceBetween: 10,
      });
   }

   if($('.ad-card-media-slider-swiper').length){
      var cardImagesSlider = new Swiper(document.querySelector('.ad-card-media-slider-swiper'), {
         loop: false,
         slidesPerView: "auto",
         spaceBetween: 10,        
         navigation: {
           nextEl: '.ad-card-media-slider-nav-right',
           prevEl: '.ad-card-media-slider-nav-left',
         },
      });
   }

   if($('.ad-card-media-slider-miniatures').length){

      if($('.ad-card-media-slider-item').length > 3){
         $('.ad-card-media-slider-item').each(function (index, element) {

           $('.ad-card-media-slider-miniatures .swiper-wrapper').append('<div data-index="'+index+'" class="swiper-slide" ><img class="image-autofocus" src="'+$(element).attr('href')+'"></div>');  

         });
      }

      new Swiper(document.querySelector('.ad-card-media-slider-miniatures'), {
         loop: false,
         slidesPerView: "auto",
         spaceBetween: 10,
      });

      $(document).on('click','.ad-card-media-slider-miniatures .swiper-slide', function (e) {  
         
         cardImagesSlider.slideTo($(this).data("index"),300,false);

         e.preventDefault();

      });

      $('.ad-card-media-slider-miniatures').css("visibility", "visible");

   }

   $(document).on('click','.actionAdShowContacts', function (e) {  
      
      helpers.startProcessLoadButton($('.actionAdShowContacts'));

      helpers.request({url:"ad-card-show-contacts", data: {id:$(this).data("id")}, precheck: true, button: $('.actionAdShowContacts')}, function(data) {

         $("#contactModal .contact-container").html(data["content"]);
         helpers.openModal("contactModal");
         helpers.endProcessLoadButton($('.actionAdShowContacts'));

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionAdShowMap', function (e) {  
      
      $(".ad-card-content-geo-map").toggle();
      
      e.preventDefault();

   });

   $(document).on('click','.actionDeleteAdCard', function (e) {  

      helpers.deleteByAlert("ad-delete",{id:$(this).data("id")});
      
      e.preventDefault();

   });

   $(document).on('click','.actionExtendAdCard', function (e) {  

      helpers.startProcessLoadButton($('.actionExtendAdCard'));

      helpers.request({url:"ad-extend", data: {id:$(this).data("id")}, precheck: true, button: $('.actionExtendAdCard')}, function(data) {

         location.reload();

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionAdSold', function (e) {  
      
      helpers.startProcessLoadButton($('.actionAdSold'));

      helpers.request({url:"ad-card-status-sold", data: {id:$(this).data("id")}, precheck: true, button: $('.actionAdSold')}, function(data) {

         location.reload();

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionAdRemovePublication', function (e) {  
      
      helpers.startProcessLoadButton($('.actionAdRemovePublication'));

      helpers.request({url:"ad-card-status-publication", data: {id:$(this).data("id")}, precheck: true, button: $('.actionAdRemovePublication')}, function(data) {

         location.reload();

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionGoToPartnerLink', function (e) {  
      
      helpers.startProcessLoadButton($('.actionGoToPartnerLink'));

      helpers.request({url:"go-partner-link", data: {id:$(this).data("id")}, precheck: true, button: $('.actionGoToPartnerLink')}, function(data) {

         window.open(data["link"], "_blank");
         helpers.endProcessLoadButton($('.actionGoToPartnerLink'));

      });
      
      e.preventDefault();

   });

   function bookingCalendarLoadData(){

      helpers.request({url:"ad-card-booking-load-calendar", data: {id:$(".ad-card-booking-calendar").data("id")}}, function(data) {

         datesDisabledBookingCalendar = data["dates_disabled"];

         $(".ad-card-booking-calendar").datepicker({
             inputs: $(".ad-card-booking-calendar-range1, .ad-card-booking-calendar-range2"),
             language: "ru",
             startDate: new Date(),
             keyboardNavigation: false,
             forceParse: false,
             updateViewDate: false,
         }).on("changeDate",function(event){

              var startDate = new Date(event.date);

              $(".ad-card-booking-calendar-range1, .ad-card-booking-calendar-range2").datepicker("update", startDate);

              if(startDateBookingCalendar && endDateBookingCalendar){
                 startDateBookingCalendar = null;
                 endDateBookingCalendar = null;
              }

              if(!startDateBookingCalendar || startDateBookingCalendar >= moment(event.date).format('YYYY-MM-DD')){
                  startDateBookingCalendar = moment(event.date).format('YYYY-MM-DD');
                  endDateBookingCalendar = null;
              }else{
                  endDateBookingCalendar = moment(event.date).format('YYYY-MM-DD');
              }

              bookingCalendarUpdateData(moment(event.date).format('YYYY-MM-DD'));
              bookingCalendarLoadCalculation(moment(event.date).format('YYYY-MM-DD'));

         }).on("changeMonth",function(event){ 

              currentDatesBookingCalendar = [];

              bookingCalendarUpdateData(moment(event.date).format('YYYY-MM-DD'));

         });

         $(".ad-card-booking-calendar-range1, .ad-card-booking-calendar-range2").datepicker('setDatesDisabled', datesDisabledBookingCalendar);

         currentDatesBookingCalendar = data["content"];

         $.each(data["content"], function(index, val) { 

            var currentDate = new Date(val["date"]);  
            $(".ad-card-booking-calendar table tr td[data-date="+currentDate.getTime()+"]:not(.disabled)").append("<div class='table-label-price' >"+val["price_str"]+"</div>");

         });

      });

   }

   function bookingCalendarUpdateData(date=null){

      if(currentDatesBookingCalendar.length == 0){
         helpers.request({url:"ad-card-booking-load-calendar", data: {id:$(".ad-card-booking-calendar").data("id"), date: date}}, function(data) {

            $(".ad-card-booking-calendar table tr td div.table-label-price").remove().hide();

            currentDatesBookingCalendar = data["content"];

            $.each(data["content"], function(index, val) { 

               var currentDate = new Date(val["date"]);
               $(".ad-card-booking-calendar table tr td[data-date="+currentDate.getTime()+"]:not(.disabled)").append("<div class='table-label-price' >"+val["price_str"]+"</div>");

            });

         });
      }else{
         $.each(currentDatesBookingCalendar, function(index, val) { 

            var currentDate = new Date(val["date"]);
            $(".ad-card-booking-calendar table tr td[data-date="+currentDate.getTime()+"]:not(.disabled)").append("<div class='table-label-price' >"+val["price_str"]+"</div>");

         });
      }

   }

   function bookingCalendarLoadCalculation(date=null){

      helpers.request({url:"ad-card-booking-load-calculation", data: {id:$(".ad-card-booking-calendar").data("id"), date_start: startDateBookingCalendar, date_end: endDateBookingCalendar}}, function(data) {

         $(".ad-card-booking-calendar-button-order").html(data["content"]);
         
      });

   }

   $(document).on('submit','.modal-booking-order-form', function (e) {  
      
      $('.modal-booking-order-form .form-label-error').hide();

      helpers.startProcessLoadButton($('.actionBookingSendOrder'));

      helpers.request({url:"ad-card-booking-create-order", data: $(this).serialize(), precheck: true, button: $('.actionBookingSendOrder')}, function(data) {

         if(data["status"] == true){
            location.href = data["link"];
         }else{
            helpers.formNoticeManager($('.modal-booking-order-form',), data);
            helpers.endProcessLoadButton($('.actionBookingSendOrder'));
         }

      });
      
      e.preventDefault();

   });

   $(document).on('change','.modal-booking-order-additional-services-container input', function (e) {  

      helpers.request({url:"ad-card-booking-prices-calculation", data: $('.modal-booking-order-form').serialize()}, function(data) {

         $(".modal-booking-order-prices-container").html(data["content"]);

      });
      
      e.preventDefault();

   });

});