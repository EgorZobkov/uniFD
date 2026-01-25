
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   var sortingIds = [];

   helpers.loadBody(null,function() {
      
      loadReportsServices();
      loadReportsTariffs();

      if($('.services-sorting-container').length){
         var sortable1 = Sortable.create(document.getElementById('services-sorting-container'), {
            handle: ".handle-sorting",   
            onEnd: function (evt) {

               $(".services-tr-container").each(function(){
                   sortingIds.push($(this).data("id"));
               });

               helpers.request({url:"dashboard-services-sorting", data: {ids: sortingIds.join(",")}}, function(data) {});

               sortingIds = [];

            },  
         });    
      } 

      if($('.tariffs-sorting-container').length){
         var sortable2 = Sortable.create(document.getElementById('tariffs-sorting-container'), {
            handle: ".handle-sorting",   
            onEnd: function (evt) {

               $(".tariffs-tr-container").each(function(){
                   sortingIds.push($(this).data("id"));
               });

               helpers.request({url:"dashboard-services-tariffs-sorting", data: {ids: sortingIds.join(",")}}, function(data) {});

               sortingIds = [];

            },  
         });
      }

   });

   $(document).on('submit','.formEditService', function (e) {  

      $('.formEditService .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditService'));
      
      helpers.request({url:"dashboard-services-edit", data: $('.formEditService').serialize()}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditService'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditService'));

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditService', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-services-load-edit", data: {id: $(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('change','input[name=count_day_fixed]', function (e) {  

      if($(this).prop("checked") == true){
         $('.container-services-fixed-count-day').show();
      }else{
         $('.container-services-fixed-count-day').hide();
      }

   });

   function loadReportsServices(){

      if($("#monthReports").length){

         helpers.request({url:"dashboard-services-load-data-chart", checkAccess: false}, function(data) {

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

           var monthReports = new ApexCharts(document.querySelector("#monthReports"), monthReportsConfig);
           monthReports.render();

         });

      }

   }

   function loadReportsTariffs(){

      if($("#monthReportsTariffs").length){

         helpers.request({url:"dashboard-services-tariffs-load-data-chart", checkAccess: false}, function(data) {

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

           var monthReports = new ApexCharts(document.querySelector("#monthReportsTariffs"), monthReportsConfig);
           monthReports.render();

         });

      }

   }

   $(document).on('submit','.formAddServiceTariff', function (e) { 

      $('.formAddServiceTariff .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddServiceTariff'));
      
      helpers.request({url:"dashboard-services-tariff-add", data: $('.formAddServiceTariff').serialize()}, function(data) {

         if(data["status"] == true){

            location.reload();

         }else{
            helpers.formNoticeManager($('.formAddServiceTariff'), data);
         }

         helpers.endProcessLoadButton($('.buttonAddServiceTariff'));

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditServiceTariff', function (e) {  

      $('.formEditServiceTariff .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditServiceTariff'));
      
      helpers.request({url:"dashboard-services-tariff-edit", data: $('.formEditServiceTariff').serialize()}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditServiceTariff'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditServiceTariff'));

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditServicesItemsTariff', function (e) {  

      $('.formEditServicesItemsTariff .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditServicesItemsTariff'));
      
      helpers.request({url:"dashboard-services-tariff-items-edit", data: $('.formEditServicesItemsTariff').serialize()}, function(data) {

         if(data["status"] == true){

            location.reload();

         }else{
            helpers.formNoticeManager($('.formEditServicesItemsTariff'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditServicesItemsTariff'));

      });

      e.preventDefault();

   });

   $(document).on('click','.deleteServiceTariff', function (e) {  

      helpers.deleteByAlert("dashboard-services-tariff-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.loadEditServiceTariff', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-services-tariff-load-edit", data: {id: $(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

});
