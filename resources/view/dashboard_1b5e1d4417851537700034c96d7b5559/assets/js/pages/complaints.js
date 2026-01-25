
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   helpers.loadBody(null,function() {
   });

   $(document).on('click','.deleteComplaint', function (e) {  

      helpers.deleteByAlert("dashboard-complaint-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.loadCardComplaint', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-complaint-load-card", data: {id: $(this).data("id")}}, function(data) {

        $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.buttonConfirmComplaint', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-complaint-confirm", data: {id: $(this).data("id")}}, function(data) {

        location.reload();

      });

      e.preventDefault();

   });

});
