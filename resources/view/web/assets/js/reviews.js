import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

    var updateChangeRating = function() {

        return $(".review-add-change-rating span").each(function() {

            if (parseInt($("input[name=rating]").val()) >= parseInt($(this).data('rating'))) {
                return $(this).find("i").removeClass('ti-star').addClass('ti-star-filled');
            } else {
                return $(this).find("i").removeClass('ti-star-filled').addClass('ti-star');
            }

        });

    };

    $(document).on("click", ".review-add-change-rating span", function(e) {

        $(".review-add-form input[name=rating]").val($(this).data('rating'));

        return updateChangeRating();

    });

    $(document).on("click", ".review-add-item-container", function(e) {

        $(".review-add-item-container").removeClass("active");

        $(this).addClass("active");

        $(".review-add-form input[name=item_id]").val($(this).data('id'));

    });

   $(document).on('submit','.review-add-form', function (e) {  
      
      helpers.startProcessLoadButton($('.actionAddReview'));

      helpers.request({url:"review-create", data: $('.review-add-form').serialize(), precheck: true, button: $('.actionAddReview')}, function(data) {

         if(data["status"] == true){
            $(".review-add-form").hide();
            $(".review-add-success").show();
         }else{
            helpers.showNoticeAnswer(data["answer"]);
            helpers.endProcessLoadButton($('.actionAddReview'));
         }

      });
      
      e.preventDefault();

   });

   var searchTimeout = null;
   var searchContainer = null;

   $(document).on('input','.review-add-items-search', function (e) {  

      if (searchTimeout != null) {
        clearTimeout(searchTimeout);
      }

      if(!searchContainer){
        searchContainer = $(".review-add-items-container").html();
      }

      if($(this).val().length >= 2){
        searchTimeout = setTimeout(function() {
          searchTimeout = null;
          helpers.request({url:"review-search-user-items", data: {user_id: $(".review-add-form input[name=user_id]").val(), query: $('.review-add-items-search').val()}}, function(data) {

             $(".review-add-items-container").html(data["answer"]);

          });
        }, 200);
      }else{
        $(".review-add-items-container").html(searchContainer);
      }

      e.preventDefault();

   });




});