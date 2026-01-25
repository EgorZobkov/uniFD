
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   var helpers = new Helpers();

   helpers.loadBody(null,function() {
     loadReports();
   });

   function loadReports(){

      helpers.request({url:"dashboard-transaction-load-data-chart", checkAccess: false}, function(data) {

         var weeklyReportsConfig = {
            chart: {
              height: 210,
              parentHeightOffset: 0,
              type: 'bar',
              toolbar: {
                show: false
              }
            },
            plotOptions: {
              bar: {
                barHeight: '60%',
                columnWidth: '38%',
                startingShape: 'rounded',
                endingShape: 'rounded',
                borderRadius: 4,
                distributed: true
              }
            },
            grid: {
              show: false,
              padding: {
                top: -30,
                bottom: 0,
                left: -10,
                right: -10
              }
            },
            colors: [
              '#7367f029',
              '#7367f029',
              '#7367f029',
              '#7367f029',
              '#7367f029',
              '#7367f029',
              '#7367f029'
            ],
            dataLabels: {
              enabled: false
            },
            series: [{
              data: data["week"]
            }],
            legend: {
              show: false
            },
            xaxis: {
              categories: [helpers.translate.content("tr_2c1ec3e4ea62c1b5d31d795bcf7697e7"), helpers.translate.content("tr_714517b4191534c9afcd6f145945041b"), helpers.translate.content("tr_c6e47c918f104178ee19e6efcb592b1d"), helpers.translate.content("tr_a51f2ee4c52f5577035ae0f967f18ce1"), helpers.translate.content("tr_012388c64b115db842951c2b4d4b7953"), helpers.translate.content("tr_3a4b2ba55d5521de6d5e15e6d2c1ce4b"), helpers.translate.content("tr_4ad91dca7b97f941c86e0b9a8bd41b92")],
              axisBorder: {
                show: false
              },
              axisTicks: {
                show: false
              },
              labels: {
                style: {
                  colors: '#a5a3ae',
                  fontSize: '13px',
                  cssClass: 'apexcharts-yaxis-annotation-label',
                }
              }
            },
            tooltip: {
               custom: function({series, seriesIndex, dataPointIndex, w}) {
                  var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
               
                  return '<div class="apexcharts-tooltip-box" >'+data.title+'</div>';
               }
            },                       
            yaxis: {
              labels: {
                show: false,
                style: {
                  colors: '#a5a3ae',
                  cssClass: 'apexcharts-yaxis-annotation-label',
                }
              }
            },
            responsive: [
              {
                breakpoint: 1025,
                options: {
                  chart: {
                    height: 199
                  }
                }
              }
            ]
         };

         const weeklyReports = new ApexCharts(document.querySelector('#weeklyReports'), weeklyReportsConfig);
         weeklyReports.render();

         var monthReportsConfig = {
             series: data["month"],
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

        var monthReports = new ApexCharts(document.querySelector("#monthReports"), monthReportsConfig);
        monthReports.render();

      });

   }


   $(document).on('click','.deleteOrder', function (e) {

      helpers.deleteByAlert("dashboard-transaction-delete",{id:$(this).data("id")});  

      e.preventDefault();

   });

   $(document).on('click','.actionTransactionMultiDelete', function (e) { 

      helpers.showUiLoadingScreen();

      helpers.request({url:"dashboard-transactions-multi-delete", data: $(".formItemsList").serialize()}, function(data) {

         location.reload();

      });

      e.preventDefault();

   });

   $(document).on('click','.deleteOperation', function (e) {

      helpers.deleteByAlert("dashboard-transactions-operation-delete",{id:$(this).data("id")});  

      e.preventDefault();

   });

   $(document).on('click','.loadCardOperation', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-transactions-operation-load-card", data: {id: $(this).data("id")}}, function(data) {

        $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

});
