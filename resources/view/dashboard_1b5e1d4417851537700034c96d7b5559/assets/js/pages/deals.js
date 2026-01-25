
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   helpers.loadBody(null,function() {
     loadReports();
   });

   $(document).on('click','.loadPaymentCard', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-deal-payment-load-card", data: {id: $(this).data("id")}}, function(data) {

        $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.selectDealPaymentChangeStatus', function (e) {  

      if($(this).data("status") == "payment_error"){
         $(".deal-payment-card-container-error").show();
      }else{

          helpers.request({url:"dashboard-deal-payment-change-status", data: {status: $(this).data("status"), id: $(this).data("id")}}, function(data) {

             location.reload();

          });

      }

   });

   $(document).on('click','.buttonSaveDealPaymentError', function (e) { 

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-deal-payment-save-comment-error", data: $(".deal-payment-form").serialize()}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.deal-payment-card-container-error'), data);
            helpers.endProcessLoadButton($('.buttonSaveDealPaymentError'));
         }

      });

      e.preventDefault();

   });

   $(document).on('click','.buttonSaveSolutionDisputeDeal', function (e) { 

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-deal-dispute-save", data: $(".deal-card-dispute-form").serialize()}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.deal-card-dispute-form'), data);
            helpers.endProcessLoadButton($('.buttonSaveSolutionDisputeDeal'));
         }

      });

      e.preventDefault();

   });

   $(document).on('click','.deleteDeal', function (e) {  

      helpers.deleteByAlert("dashboard-deal-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   function loadReports(){

      if($("#monthReports").length){

        helpers.request({url:"dashboard-deals-load-data-chart", checkAccess: false}, function(data) {

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


});
