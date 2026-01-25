
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   helpers.loadBody(null,function() {
     loadReports();
   });
   
   $(document).on('submit','.formAddUser', function (e) {  

      $('.formAddUser .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddUser'));
      
      helpers.request({url:"dashboard-user-add", data: $('.formAddUser').serialize(), button: $('.buttonAddUser')}, function(data) {

         if(data["status"] == true){

            if(data["admin"] == true){
              $(".user-login").html($(".formAddUser input[name=email]").val());
              $(".user-pass").html($(".formAddUser input[name=password]").val());
              helpers.hideModal("addUserModal");
              helpers.openModal("addUserSuccessModal");
            }else{
              location.reload();
            }

         }else{
            helpers.formNoticeManager($('.formAddUser'), data);
         }

         helpers.endProcessLoadButton($('.buttonAddUser'));

      });

      e.preventDefault();

   });   

   $(document).on('submit','.formEditUser', function (e) {  

      $('.formEditUser .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditUser'));
      
      helpers.request({url:"dashboard-user-edit", data: $('.formEditUser').serialize(), button: $('.buttonSaveEditUser')}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditUser'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditUser'));

      });

      e.preventDefault();

   });

   $(document).on('click','.deleteUser', function (e) {  

      helpers.deleteByAlert("dashboard-user-delete",{user_id: $(this).data("id")});

      e.preventDefault();

   });
   
   $(document).on('click','.actionUsersMultiDelete', function (e) {  

      helpers.showUiLoadingScreen();

      helpers.request({url:"dashboard-users-multi-delete", data: $(".formItemsList").serialize()}, function(data) {

         location.reload();

      });

      e.preventDefault();

   });

   $(document).on('click','.sendEmailAccessUser', function (e) {  

      $('.formAddUser .form-label-error').hide();

      helpers.startProcessLoadButton($('.sendEmailAccessUser'));

      helpers.request({url:"dashboard-user-send-access", data: $(".formAddUser").serialize(), button: $('.sendEmailAccessUser')}, function(data) {
         location.reload();
      });

      e.preventDefault();

   });

   $(document).on('change','.select-status-user', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val() == "2"){
         $('.container-change-reason-blocking').show();
      }else{
         $('.container-change-reason-blocking').hide();
      }

   });

   $(document).on('change','.select-role-user', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.data("chief") == "1"){
         $('.container-privileges-user').hide();
      }else{
        if(selected.val() == ""){
          $('.container-privileges-user').hide();
        }else{
          $('.container-privileges-user').show();
        }
      }

   });

   $(document).on('click','.loadEditUser', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-user-load-edit", data: {user_id: $(this).data("id")}}, function(data) {

        $("#loadContentModal .load-content-container").html(data["content"]);
        helpers.initCountryPhoneInput();

      });

      e.preventDefault();

   });

   $(document).on('click','.buttonBalanceEdit', function (e) {  

      $('.formBalanceEdit .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonBalanceEdit'));
      
      helpers.request({url:"dashboard-user-edit-balance", data: $(".formBalanceEdit").serialize(), button: $('.buttonBalanceEdit')}, function(data) {

        if(data["status"] == true){
            helpers.hideModal("balanceEditModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);
         }else{
            helpers.formNoticeManager($('.formBalanceEdit'), data);
         }

         helpers.endProcessLoadButton($('.buttonBalanceEdit'));

      });

      e.preventDefault();

   }); 

   $(document).on('click','.deleteAuthSessionUser', function (e) {  

      helpers.deleteByAlert("dashboard-user-delete-auth-session",{auth_id: $(this).data("auth-id"), user_id: $(this).data("user-id")});

      e.preventDefault();

   });

   $(document).on('click','.clearAuthUser', function (e) {  

      helpers.deleteByAlert("dashboard-user-delete-auth-history",{user_id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.administatorGenerateAccessKey', function (e) {  

      helpers.startProcessLoadButton($('.administatorGenerateAccessKey'));

      helpers.request({url:"dashboard-user-generate-access-key", data: {user_id: $(this).data("id")}}, function(data) {
         location.reload();
      });

   });

   $(document).on('click','.administatorDeleteAccessKey', function (e) {  

      helpers.startProcessLoadButton($('.administatorDeleteAccessKey'));

      helpers.request({url:"dashboard-user-delete-access-key", data: {user_id: $(this).data("id")}}, function(data) {
         location.reload();
      });

   });

   $(document).on('click','.authProfileUser', function (e) {  

      helpers.request({url:"dashboard-user-profile-auth", data: {user_id:$(this).data("id")}, button: $('.authProfileUser')}, function(data) {
         window.open(data["link"], '_blank');
      });

      e.preventDefault();

   });

   $(document).on('click','.actionUserChangeStatusVerification', function (e) { 

       helpers.request({url:"dashboard-user-verification-change-status", data: {id: $(this).data("id"), status: $(this).data("status")}}, function(data) {

          location.reload();

       });

      e.preventDefault();

   });

   $(document).on('click','.deleteOrder', function (e) {

      helpers.deleteByAlert("dashboard-transaction-delete",{id:$(this).data("id")});  

      e.preventDefault();

   });

   $(document).on('click','.deleteDeal', function (e) {  

      helpers.deleteByAlert("dashboard-deal-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   function loadReports(){

      if($('#weeklyUsersReports').length || $('#monthUsersReports').length){

        helpers.request({url:"dashboard-users-load-data-chart", checkAccess: false}, function(data) {

           var weeklyUsersReportsConfig = {
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

           const weeklyUsersReports = new ApexCharts(document.querySelector('#weeklyUsersReports'), weeklyUsersReportsConfig);
           weeklyUsersReports.render();

           var monthUsersReportsConfig = {
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

          var monthUsersReports = new ApexCharts(document.querySelector("#monthUsersReports"), monthUsersReportsConfig);
          monthUsersReports.render();

        });

      }

   }

   $(document).on('submit','.userNotificationsForm', function (e) {  

      $('.userNotificationsForm .form-label-error').hide();

      helpers.startProcessLoadButton($('.actionUserNotificationsSave'));
      
      helpers.request({url:"dashboard-user-edit-notifications", data: $('.userNotificationsForm').serialize()}, function(data) {

         helpers.formNoticeManager($('.userNotificationsForm'), data);

         helpers.endProcessLoadButton($('.actionUserNotificationsSave'));

      });

      e.preventDefault();

   });

   $(document).on('submit','.formSendMessageUser', function (e) {  

      $('.formSendMessageUser .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSendMessageUser'));
      
      helpers.request({url:"dashboard-user-send-message", data: $('.formSendMessageUser').serialize(), button: $('.buttonSendMessageUser')}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("userChatMessageModal");

         }

         helpers.formNoticeManager($('.formSendMessageUser'), data);

         helpers.endProcessLoadButton($('.buttonSendMessageUser'));

      });

      e.preventDefault();

   });

   $(document).on('click','.actionUserDeleteTariff', function (e) {  

      helpers.deleteByAlert("dashboard-user-delete-tariff",{user_id: $(this).data("user-id")}); 
      
      e.preventDefault();

   });

});
