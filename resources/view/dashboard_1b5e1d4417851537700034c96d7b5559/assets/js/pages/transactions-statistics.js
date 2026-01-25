
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   var helpers = new Helpers();

   helpers.loadBody(null,function() {
     loadReports();
   });

   function loadReports(){

      helpers.request({url:"dashboard-transactions-statistics-load-data-chart", data: {month: $("input[name=month]").val(), year: $("input[name=year]").val()}, checkAccess: false}, function(data) {
      
         var monthReportsConfig = {
             series: data,
             chart: {
             height: 350,
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
                  return helpers.amount(val);
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
               formatter: function (val) {
                 return helpers.amount(val);
               }
             }      
            },
        };

        var monthReports = new ApexCharts(document.querySelector("#fullTransactionsStatistics"), monthReportsConfig);
        monthReports.render();

      });

   }


});
