$(document).ready(function () {

   var helpers = new window.Helpers();

   $(document).on('click','.uni-select-name', function () {
      var parent = $(this).parent();
      $(".uni-select").not(parent).removeClass("uni-select-open").attr("data-status",0);
      if( $(this).parent().attr("data-status") == 0 ){
          $(this).parent().toggleClass("uni-select-open").attr("data-status",1);
      }else{
          $(this).parent().removeClass("uni-select-open").attr("data-status",0);
      }
   });

   $(document).on('click', function(e) {
      if (!$(e.target).closest(".uni-select").length) {
        $(".uni-select").removeClass("uni-select-open").attr("data-status",0);
      }
      e.stopPropagation();
   });

   $(document).on('click','.uni-select-content-item', function () {

      var input = $(this).find("input");
      var parent = $(this).parents(".uni-select-content-container");
      var name = $(this).parents(".uni-select").find(".uni-select-name");

      if(input.attr("type") == "radio"){

         parent.find("input").not(input).prop("checked", false);
         
         name.html($(this).find("span").html());
         parent.find(".uni-select-content-item").removeClass("uni-select-item-active");
         $(this).addClass("uni-select-item-active");
         $(".uni-select").removeClass("uni-select-open").attr("data-status",0);

      }else{

         if ($(input).prop("checked") == true){
             $(this).addClass("uni-select-item-active");
         }else{
             $(this).removeClass("uni-select-item-active");
         }

         var count = parent.find("input:checked").length;

         if(!count){
            name.html( name.data("default-name") );
         }else if(count == 1){
            name.html( parent.find(".uni-select-item-active span").html());
         }else if(count > 1){
            name.html(helpers.translate.content("tr_c8775dcb5146e06356e352b69bb89764")+" ("+count+")");
         }else{
            name.html(name.data("name"));
         }

      }

   });

   $(document).on('input','.uni-select-content-input input', function () {

      var parent = $(this).parents(".uni-select-content-input");
      var name = $(this).parents(".uni-select").find(".uni-select-name");

      if(parent.find("input[data-type=from]").val() && parent.find("input[data-type=to]").val()){
         name.html(helpers.translate.content("tr_996b125bc9bba860718d999df2ecc61d")+" "+parent.find("input[data-type=from]").val()+" "+helpers.translate.content("tr_538dc63d3c6db1a1839cafbaf359799b")+" "+parent.find("input[data-type=to]").val());
      }else if(parent.find("input[data-type=from]").val()){
         name.html(helpers.translate.content("tr_996b125bc9bba860718d999df2ecc61d")+" "+parent.find("input[data-type=from]").val());
      }else if(parent.find("input[data-type=to]").val()){
         name.html(helpers.translate.content("tr_c2aa9c0cecea49717bb2439da36a7387")+" "+parent.find("input[data-type=to]").val());
      }else if(parent.find("input[data-type=text]").val()){
         name.html(parent.find("input[data-type=text]").val());
      }else{
         name.html(name.data("default-name"));
      }

   });

   $(document).on('input','.uni-select-content-search input', function () {
      
      var str = $(this).val().toLowerCase();
      var el = $(this).parents(".uni-select-content").find('.uni-select-content-item');

      el.show();
      
      el.each(function(){
        if ($(this).find("span").text().toLowerCase().indexOf(str) < 0){
            $(this).hide();
        }
      });  
        
   });


});