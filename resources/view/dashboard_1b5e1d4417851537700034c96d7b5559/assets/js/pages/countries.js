
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   helpers.loadBody(null,function() {
   });

   $(document).on('submit','.formAddCountry', function (e) {  

      $('.formAddCountry .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddCountry'));
      
      var form = new FormData($(".formAddCountry")[0]);

      helpers.request({url:"dashboard-country-add", data: form, contentType: false, processData: false, button: $('.buttonAddCountry')}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.formAddCountry'), data);
            helpers.endProcessLoadButton($('.buttonAddCountry'));
         }

      });

      e.preventDefault();

   });

   $(document).on('submit','.formAddRegion', function (e) {  

      $('.formAddRegion .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddRegion'));
      
      helpers.request({url:"dashboard-country-region-add", data: $(".formAddRegion").serialize(), button: $('.buttonAddRegion')}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.formAddRegion'), data);
            helpers.endProcessLoadButton($('.buttonAddRegion'));
         }

      });

      e.preventDefault();

   });

   $(document).on('submit','.formAddCity', function (e) {  

      $('.formAddCity .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddCity'));
      
      helpers.request({url:"dashboard-country-city-add", data: $(".formAddCity").serialize(), button: $('.buttonAddCity')}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.formAddCity'), data);
            helpers.endProcessLoadButton($('.buttonAddCity'));
         }

      });

      e.preventDefault();

   });

   $(document).on('submit','.formAddCityDistrict', function (e) {  

      $('.formAddCityDistrict .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddCityDistrict'));
      
      helpers.request({url:"dashboard-country-city-district-add", data: $(".formAddCityDistrict").serialize(), button: $('.buttonAddCityDistrict')}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.formAddCityDistrict'), data);
            helpers.endProcessLoadButton($('.buttonAddCityDistrict'));
         }

      });

      e.preventDefault();

   });

   $(document).on('submit','.formAddCityMetro', function (e) {  

      $('.formAddCityMetro .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddCityMetro'));
      
      helpers.request({url:"dashboard-country-city-metro-add", data: $(".formAddCityMetro").serialize(), button: $('.buttonAddCityMetro')}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.formAddCityMetro'), data);
            helpers.endProcessLoadButton($('.buttonAddCityMetro'));
         }

      });

      e.preventDefault();

   });

   $(document).on('click','.deleteCountry', function (e) {  

      helpers.deleteByAlert("dashboard-country-delete",{id: $(this).data("id")});

      e.preventDefault();

   });   

   $(document).on('click','.deleteCity', function (e) {  

      helpers.deleteByAlert("dashboard-country-city-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.deleteRegion', function (e) {  

      helpers.deleteByAlert("dashboard-country-region-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.deleteCityDistrict', function (e) {  

      helpers.deleteByAlert("dashboard-country-city-district-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.deleteCityMetro', function (e) {  

      helpers.deleteByAlert("dashboard-country-city-metro-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('submit','.formEditCountry', function (e) {  

      $('.formEditCountry .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditCountry'));
      
      var form = new FormData($(this)[0]);

      helpers.request({url:"dashboard-country-edit", data: form, contentType: false, processData: false, button: $('.buttonSaveEditCountry')}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditCountry'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditCountry'));

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditCity', function (e) {  

      $('.formEditCity .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditCity'));
      
      helpers.request({url:"dashboard-country-city-edit", data: $('.formEditCity').serialize(), button: $('.buttonSaveEditCity')}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditCity'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditCity'));

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditRegion', function (e) {  

      $('.formEditRegion .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditRegion'));
      
      helpers.request({url:"dashboard-country-region-edit", data: $('.formEditRegion').serialize(), button: $('.buttonSaveEditRegion')}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditRegion'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditRegion'));

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditCityDistrict', function (e) {  

      $('.formEditCityDistrict .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditCityDistrict'));
      
      helpers.request({url:"dashboard-country-city-district-edit", data: $('.formEditCityDistrict').serialize(), button: $('.buttonSaveEditCityDistrict')}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditCityDistrict'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditCityDistrict'));

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditCityMetro', function (e) {  

      $('.formEditCityMetro .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditCityMetro'));
      
      helpers.request({url:"dashboard-country-city-metro-edit", data: $('.formEditCityMetro').serialize(), button: $('.buttonSaveEditCityMetro')}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditCityMetro'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditCityMetro'));

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditCountry', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-country-load-edit", data: {id: $(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditCity', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-country-city-load-edit", data: {id: $(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditRegion', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-country-region-load-edit", data: {id: $(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditCityDistrict', function (e) {  

      helpers.openModal("loadContentModal", "small");

      helpers.request({url:"dashboard-country-city-district-load-edit", data: {id: $(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditCityMetro', function (e) {  

      helpers.openModal("loadContentModal", "small");

      helpers.request({url:"dashboard-country-city-metro-load-edit", data: {id: $(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.changeFavoriteCity', function (e) { 

      var _this = this; 

      helpers.request({url:"dashboard-country-city-change-favorite", data: {id: $(this).data("id")}}, function(data) {

         if(data["status"] == true){
            $(_this).addClass("starActive");
         }else{
            $(_this).removeClass("starActive");
         }

      });

      e.preventDefault();

   });

   $(document).on('click','.countrySystemAddCityMetro', function (e) {  

      $(".country-city-metro-container").append(`<div class="country-city-metro-item mb-2" ><div class="input-group"><input type="text" class="form-control" name="stations[add][]" value=""><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemCityMetro"><i class="ti ti-trash"></i></span></div></div>`);

   });

   $(document).on('click','.buttonDeleteItemCityMetro', function (e) {  

      $(this).parents(".country-city-metro-item").remove().fadeOut(300);

   });

   $(document).on('submit','.formAddCountryFromList', function (e) {  

      $('.formAddCountryFromList .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddCountryFromList'));
      
      helpers.request({url:"dashboard-country-add-cities-from-list", data: $(this).serialize()}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.formAddCountryFromList'), data);
            helpers.endProcessLoadButton($('.buttonAddCountryFromList'));
         }

      });

      e.preventDefault();

   });

   $(document).on('click','.actionLoadCountriesFromList', function (e) {  

      if(!$(".formAddCountryFromList select option").length){
         helpers.request({url:"dashboard-country-load-countries-list"}, function(data) {

            $(".formAddCountryFromList select").html(data["content"]).selectpicker('refresh');

         });
      }

      e.preventDefault();

   });

});
