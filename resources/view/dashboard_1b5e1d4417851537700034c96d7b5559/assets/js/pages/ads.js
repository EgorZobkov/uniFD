
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   helpers.loadBody(null,function() {
     loadReports();
   });

   $(document).on('click','.deleteAd', function (e) {  

      helpers.deleteByAlert("dashboard-ad-delete",{id:$(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.loadAdCard', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-ad-load-card", data: {id: $(this).data("ad-id")}}, function(data) {

        $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.actionAdChangeStatus', function (e) {  

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-ad-change-status", data: {id: $(this).data("id"), status: $(this).data("status")}}, function(data) {

         location.reload();

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionAdApprove', function (e) {  

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-ad-approve", data: {id: $(this).data("id")}}, function(data) {

         location.reload();

      });
      
      e.preventDefault();

   });

   $(document).on('click','.selectAdChangeStatus', function (e) { 

      if($(this).data("status") == "4"){

         $(".ad-card-container-reason-change-status").show();

      }else{

         helpers.request({url:"dashboard-ad-change-status", data: {id: $(this).data("id"), status: $(this).data("status")}}, function(data) {

            location.reload();

         });

      }

      e.preventDefault();

   });

   $(document).on('change','.ad-card-select-reason', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val() == "other"){
         $(".ad-card-container-reason-text-status").show();
      }else{
         $(".ad-card-container-reason-text-status").hide();
      }

   });

   $(document).on('click','.buttonSaveAdReasonStatus', function (e) { 

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-ad-save-comment-status", data: $(".reason-blocking-form").serialize()}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.ad-card-container-reason-change-status'), data);
            helpers.endProcessLoadButton($('.buttonSaveAdReasonStatus'));
         }

      });

      e.preventDefault();

   });

   $(document).on('click','.actionChangeMultiStatus', function (e) {  

      helpers.showUiLoadingScreen();

      helpers.request({url:"dashboard-ad-multi-change-status", data: $(".formItemsList").serialize()+"&status="+$(this).data("status")}, function(data) {

         location.reload();

      });

      e.preventDefault();

   });

   $(document).on('click','.actionAdsMultiToExtend', function (e) {  

      helpers.showUiLoadingScreen();

      helpers.request({url:"dashboard-ad-multi-extend", data: $(".formItemsList").serialize()}, function(data) {

         location.reload();

      });

      e.preventDefault();

   });

   $(document).on('click','.actionAdsMultiDelete', function (e) {  

      helpers.showUiLoadingScreen();

      helpers.request({url:"dashboard-ad-multi-delete", data: $(".formItemsList").serialize()}, function(data) {

         location.reload();

      });

      e.preventDefault();

   });

   function loadReports(){

      if($("#monthReports").length){

         helpers.request({url:"dashboard-ad-load-data-chart", checkAccess: false}, function(data) {

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
               },
           };

           var monthReports = new ApexCharts(document.querySelector("#monthReports"), monthReportsConfig);
           monthReports.render();

         });

      }

   }

});
