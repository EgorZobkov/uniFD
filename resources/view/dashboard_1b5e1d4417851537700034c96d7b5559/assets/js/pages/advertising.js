
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   var searchTimeout = null;

   helpers.loadBody(null,function() {
      loadReports();
   });

   $(document).on('click', function(e) { 

      if(!$(e.target).closest(".advertising-geo-search").length && !$(e.target).closest(".advertising-geo-search-results").length) {
          $(".advertising-geo-search-results").hide();
      }

      e.stopPropagation();

   });

   $(document).on('submit','.formAddAdvertising', function (e) {  

      $('.formAddAdvertising .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddAdvertising'));
      
      var form = new FormData($(this)[0]);

      form.append('code', encodeURIComponent($('.formAddAdvertising textarea[name=code]').val()));

      helpers.request({url:"dashboard-advertising-add", data: form, cache: false, contentType: false, processData: false}, function(data) {

         if(data["status"] == true){
            if(data["position"] == "page"){
              helpers.hideModal("addAdvertisingModal");
              $(".code-advertising-container").html(data["answer"]);
              helpers.openModal("codeAdvertisingModal");
              helpers.endProcessLoadButton($('.buttonAddAdvertising'));
            }else{
              location.reload();
            }
         }else{
            helpers.formNoticeManager($('.formAddAdvertising'), data);
            helpers.endProcessLoadButton($('.buttonAddAdvertising'));
         }

      });

      e.preventDefault();

   });

   $(document).on('submit','.formAddSliderAdvertising', function (e) {  

      $('.formAddSliderAdvertising .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddSliderAdvertising'));
      
      var form = new FormData($(this)[0]);

      form.append('code', encodeURIComponent($('.formAddSliderAdvertising textarea[name=code]').val()));

      helpers.request({url:"dashboard-advertising-add", data: form, cache: false, contentType: false, processData: false}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.formAddSliderAdvertising'), data);
            helpers.endProcessLoadButton($('.buttonAddSliderAdvertising'));
         }

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditAdvertising', function (e) {  

      $('.formEditAdvertising .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditAdvertising'));

      var form = new FormData($(this)[0]);

      form.append('code', encodeURIComponent($('.formEditAdvertising textarea[name=code]').val()));

      helpers.request({url:"dashboard-advertising-edit", data: form, cache: false, contentType: false, processData: false}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");

         }

         helpers.formNoticeManager($('.formEditAdvertising'), data);
         helpers.endProcessLoadButton($('.buttonSaveEditAdvertising'));

      });

      e.preventDefault();

   });

   $(document).on('click','.deleteAdvertising', function (e) {  

      helpers.deleteByAlert("dashboard-advertising-delete",{id:$(this).data("id")});

      e.preventDefault();

   });
   
   $(document).on('click','.loadEditAdvertising', function (e) {  

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-advertising-load-edit", data: {id:$(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('change','.formAddAdvertising select[name=type]', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val() == "banner"){
         $('.advertising-add-type-banner-container').show();
         $('.advertising-add-type-code-container').hide();
      }else if(selected.val() == "code"){
         $('.advertising-add-type-banner-container').hide();
         $('.advertising-add-type-code-container').show();
      }else{
         $('.advertising-add-type-banner-container').hide();
         $('.advertising-add-type-code-container').hide();
      }

   });

   $(document).on('change','.formEditAdvertising select[name=type]', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val() == "banner"){
         $('.advertising-edit-type-banner-container').show();
         $('.advertising-edit-type-code-container').hide();
      }else if(selected.val() == "code"){
         $('.advertising-edit-type-banner-container').hide();
         $('.advertising-edit-type-code-container').show();
      }else{
         $('.advertising-edit-type-banner-container').hide();
         $('.advertising-edit-type-code-container').hide();
      }

   });

   $(document).on('change','.formAddSliderAdvertising select[name=type]', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val() == "banner"){
         $('.advertising-add-type-banner-container').show();
         $('.advertising-add-type-code-container').hide();
      }else if(selected.val() == "code"){
         $('.advertising-add-type-banner-container').hide();
         $('.advertising-add-type-code-container').show();
      }else{
         $('.advertising-add-type-banner-container').hide();
         $('.advertising-add-type-code-container').hide();
      }

   });

   $(document).on('change','.formAddAdvertising select[name=position]', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val() == "results"){
         $('.advertising-add-result-index-container').show();
      }else{
         $('.advertising-add-result-index-container').hide();
      }

   });

   $(document).on('change','.formEditAdvertising select[name=position]', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val() == "results"){
         $('.advertising-edit-result-index-container').show();
      }else{
         $('.advertising-edit-result-index-container').hide();
      }

   });

   $(document).on('change','.formAddAdvertising input[name=geo_all]', function (e) {  

      if($(this).prop("checked") == true){
         $('.advertising-add-geo-container').hide();
      }else{
         $('.advertising-add-geo-container').show();
      }

   });

   $(document).on('change','.formEditAdvertising input[name=geo_all]', function (e) {  

      if($(this).prop("checked") == true){
         $('.advertising-edit-geo-container').hide();
      }else{
         $('.advertising-edit-geo-container').show();
      }

   });

   $(document).on('change','.formAddAdvertising input[name=lang_all]', function (e) {  

      if($(this).prop("checked") == true){
         $('.advertising-add-lang-container').hide();
      }else{
         $('.advertising-add-lang-container').show();
      }

   });

   $(document).on('change','.formEditAdvertising input[name=lang_all]', function (e) {  

      if($(this).prop("checked") == true){
         $('.advertising-edit-lang-container').hide();
      }else{
         $('.advertising-edit-lang-container').show();
      }

   });

   $(document).on('change','.formAddAdvertising input[name=category_all]', function (e) {  

      if($(this).prop("checked") == true){
         $('.advertising-add-category-container').hide();
      }else{
         $('.advertising-add-category-container').show();
      }

   });

   $(document).on('change','.formEditAdvertising input[name=category_all]', function (e) {  

      if($(this).prop("checked") == true){
         $('.advertising-edit-category-container').hide();
      }else{
         $('.advertising-edit-category-container').show();
      }

   });

   $(document).on('change','.formAddSliderAdvertising input[name=geo_all]', function (e) {  

      if($(this).prop("checked") == true){
         $('.advertising-add-geo-container').hide();
      }else{
         $('.advertising-add-geo-container').show();
      }

   });

   $(document).on('change','.formAddSliderAdvertising input[name=lang_all]', function (e) {  

      if($(this).prop("checked") == true){
         $('.advertising-add-lang-container').hide();
      }else{
         $('.advertising-add-lang-container').show();
      }

   });

   $(document).on('change','.formAddSliderAdvertising input[name=category_all]', function (e) {  

      if($(this).prop("checked") == true){
         $('.advertising-add-category-container').hide();
      }else{
         $('.advertising-add-category-container').show();
      }

   });

   $(document).on('input click','.advertising-geo-search', function (e) {

      var query = $(this).val();

      if (searchTimeout != null) {
        clearTimeout(searchTimeout);
      }

      if($(this).val().length != 0){
        searchTimeout = setTimeout(function() {
          searchTimeout = null; 
          helpers.request({url:"dashboard-advertising-geo-search", data: {query: query}}, function(data) {

             if(data["status"]){
                $(".advertising-geo-search-results").html(data["answer"]).fadeIn(100);
             }else{
                $(".advertising-geo-search-results").html("").hide();
             }

          });
        }, 200);
      }else{
          $(".advertising-geo-search-results").html("").hide();
      }

      e.preventDefault();

   });

   $(document).on('click','.advertising-geo-search-results-item', function (e) {

      $(".advertising-geo-search-results").hide();
      $(".advertising-geo-inputs").append(`<div class="advertising-geo-inputs-item" > <span class="advertising-geo-inputs-item-delete" ><i class="ti ti-trash"></i></span> <input type="hidden" name="geo[`+$(this).data("purpose")+`][]" value="`+$(this).data("id")+`" /> `+$(this).data("name")+` </div>`);

   });

   $(document).on('click','.advertising-geo-inputs-item-delete', function (e) {

      $(this).parents(".advertising-geo-inputs-item").remove();

   });

   $(document).on('click','.loadAddSliderAdvertising', function (e) {  

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-advertising-slider-load-add", data: {id:$(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   function loadReports(){

      if($("#monthReportsAdvertising").length){

         helpers.request({url:"dashboard-advertising-load-data-chart", checkAccess: false}, function(data) {

            var monthReportsConfig = {
                series: data,
                chart: {
                height: 270,
                type: 'area',
                 toolbar: {
                   show: false
                 }
              },
              dataLabels: {
                enabled: false
              },
              stroke: {
                curve: 'smooth',
                width: 1,
              },
              xaxis: {
                type: 'datetime',
                labels: {
                   style: {
                     colors: '#a5a3ae',
                     cssClass: 'apexcharts-yaxis-annotation-label',
                   },
                  formatter: function (value) {
                     const formatter = new Intl.DateTimeFormat(helpers.translate.locale(), { day: '2-digit', month: 'short' });
                     const formattedDate = formatter.format(value);
                     return formattedDate 
                     }, 
                 }
              },
              yaxis: {
                tickAmount: 5,
                labels: {
                   style: {
                     colors: '#a5a3ae',
                     cssClass: 'apexcharts-yaxis-annotation-label',
                   },
                   formatter: function (val) {
                       return val;
                   }
                }
              },
              legend: {
                show: false,
              },
              tooltip: {
                x: {
                      format: 'dd.MM.yyyy'
                   },  
                y: {
                       formatter: (value, { series, seriesIndex, dataPointIndex, w }) => {
                           var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
                           return data.title;
                   }
                }   
               },
           };

           var monthReports = new ApexCharts(document.querySelector("#monthReportsAdvertising"), monthReportsConfig);
           monthReports.render();

         });

      }

   }

});
