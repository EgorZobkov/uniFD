
import Routes from './routes.js';
import Configs from './config.js';
let Translate = new window.Translate();

export default class Helpers {

  constructor() {

    this.timerIdProcess;
    this.timerIdNotice;
    this.configs = Configs;
    this.routes = Routes;
    this.translate = Translate;
    this.uniSelectUpdate();

  }

  config(value){
    return this.configs[value];
  }

  getUrl(){
    var path = window.location.pathname.replace(/^\/|\/$/g, '');
    var search = window.location.search.replace(/^\/|\/$/g, '');
    return path+search;
  }

  getUrlParams(){
    var result = window.location.href.split('?');
    return result[1];
  }

  urlParamValue(name){
    let params = new URLSearchParams(window.location.search);
    return params.get(name);
  }

  amount(amount=0){

    var spacing;

    var splitAmount = amount.toFixed(2).split(".");

    if(splitAmount[1] != "00"){
      amount = amount.toFixed(2);
    }

    if(this.config("system_currency_spacing")){ spacing = " "; }else{ spacing = ""; }

    if(this.config("system_currency_position") == "start"){
        return this.config("system_default_currency")+spacing+$.number(amount, 0, '.', ' ');
    }else{
        return $.number(amount, 0, '.', ' ')+spacing+this.config("system_default_currency");
    }

  }

  ajaxData(data,button){
    if(data["auth"] == false){
      this.loadModal("auth");
      if(button != undefined) this.endProcessLoadButton(button);
      return false;
    }else if(data["verification"] == false){
      this.loadModal("verificationUser");
      if(button != undefined) this.endProcessLoadButton(button);
      return false;
    }   
    return true;
  }

  request(params,callback) {

      var thisClass = this;
      var precheck = false;

      if(params["precheck"] != undefined){
        precheck = params["precheck"];
      }

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          'before-route': this.getCurrentRoute(),
        }
      });

      try {

          $.ajax({url: this.getRoute(params["url"]),type: params["type"] ? params["type"] : 'POST',data: params["data"] ? params["data"] : null,dataType: params["dataType"] ? params["dataType"] : "json", contentType: params["contentType"], processData: params["processData"],success: function(data) {
              if(precheck){
                if(thisClass.ajaxData(data,params["button"])){
                  callback(data);
                }
              }else{
                callback(data);
              }
              thisClass.uniSelectUpdate();
              thisClass.initPhoneMask();
          }});   

      } catch (error) {
          console.log(error);
      }

  }

  endTimeoutProcessLoadButton(thisButton){
    if(thisButton.prop('disabled') == true){
      thisButton.find('span.spinner-border').remove();
      thisButton.prop('disabled', false);
    }
    clearInterval(this.timerIdProcess);
  }

  startProcessLoadButton(thisButton){

    if(this.timerIdProcess){
      clearInterval(this.timerIdProcess);
    }

    this.timerIdProcess = setInterval(()=>this.endTimeoutProcessLoadButton(thisButton), 20000);

    if(thisButton.find("span.spinner-border").length == 0){
      thisButton.html('<span class="spinner-border me-1" role="status" aria-hidden="true"></span>'+$(thisButton).html());
    }
    thisButton.prop('disabled', true);

  }

  endProcessLoadButton(thisButton){

    thisButton.find('span.spinner-border').remove();
    thisButton.prop('disabled', false);

  }

  showNotice(type, text=''){

    if(this.timerIdNotice){
      clearInterval(this.timerIdNotice);
    }

    $(".splash-notification").remove();

    var body = `
      <div class="splash-notification" >
         <div class="splash-notification-container" >
          <p>`+text+`</p>
         </div>
      </div>
    `;

    $("body").append(body);

    $(".splash-notification").fadeIn(300);

    this.timerIdNotice = setInterval(()=>$(".splash-notification").fadeOut(100, function(){ $(".splash-notification").remove(); clearInterval(this.timerIdNotice); }), 5000);

  }

  openModal(idModal, size=null, element=null, params=null){

    if(size){

       if(size == "nano"){
          $('#'+idModal+' .modal-dialog').css("max-width", "450px");
       }else if(size == "small"){
          $('#'+idModal+' .modal-dialog').css("max-width", "540px");
       }else if(size == "medium"){
          $('#'+idModal+' .modal-dialog').css("max-width", "650px");
       }else if(size == "big"){
          $('#'+idModal+' .modal-dialog').css("max-width", "750px");
       }else if(size == "mega"){
          $('#'+idModal+' .modal-dialog').css("max-width", "950px");
       }else{
          $('#'+idModal+' .modal-dialog').css("max-width", size);
       }

    }

    $(".modal").modal("hide");

    if(element){
       if($(element).parents(".modal").length){
           $('#'+idModal).attr("data-parent-modal-id", $(element).parents(".modal").attr("id").replace('Modal',''));
           if(params) $('#'+idModal).attr("data-parent-modal-params", params);
       }
    }

    $('#'+idModal).modal('show');

  }

  hideModal(idModal, element=null){

    $('#'+idModal).modal('hide');

    if(element){
      if($(element).parents(".modal").attr("data-parent-modal-id") != undefined){
          this.loadModal($(element).parents(".modal").attr("data-parent-modal-id"), $(element).parents(".modal").attr("data-parent-modal-params"));
      }
    }

    $(".modal").removeAttr('data-parent-modal-id');

  }

  showNoticeAnswer(data, type="warning"){
    var text = [];
    if(data != '' && data != undefined){
      if($.isArray(data) == true){
        $.each(data,function(index,value){
          text.push(value);
        });
      }else{
        text.push(data);
      }
      this.showNotice(type, text.join("\n"));
    }
  }

  showUiLoadingScreen(){
     $(".ui-loading-screen").show();
  }

  hideUiLoadingScreen(){
     $(".ui-loading-screen").hide();
  }

  goToRoute(route=null){

    location.href=route;

  }

  loadRoute(route){
    this.request({url:route,type: "GET",cache: false}, function(data) {
      window.history.pushState({path:route},'',route);
      document.write(data);      
    });
  }

  getRoute(name=null){
      if(this.routes[name] != undefined){
         if(this.config("prefix_path")){
             return '/' + this.config("prefix_path") + this.routes[name];
         }else{
             return this.routes[name];
         }
      }
  }

  getCurrentRoute(){
      if(this.routes["current_route_name"] != undefined){
         return this.routes["current_route_name"];
      }
  }

  generateStr(length=6){
    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    var res = '';
    for (var i = 0, n = charset.length; i < length; ++i) {
      res += charset.charAt(Math.floor(Math.random() * n));
    }
    return res;
  }

  formLabelErrors(selector,data){
    var element_index = [];
    if(data != '' && data != undefined){
      $.each(data,function(index,value){
        selector.find(".form-label-error[data-name="+index+"]").html(value).show();
        element_index.push(index);
      });
      if(!selector.parents(".modal").length){
        if(selector.find(".form-label-error[data-name="+element_index[0]+"]").length && element_index.length){
            $("html,body").animate({scrollTop:selector.find(".form-label-error[data-name="+element_index[0]+"]").offset().top-200}, 200);
        }
      }
    }
  }

  formNoticeManager(selector=null,data){

    if(data["type_show"] != '' && data["type_show"] != undefined){
        if(data["type_show"] == "notice"){
          this.showNoticeAnswer(data["answer"], data["type_answer"]);
        }else if(data["type_show"] == "form"){
          this.formLabelErrors(selector,data["answer"]);
        }else{
          this.showNoticeAnswer(data["answer"]);
        }
    }else{
        this.showNoticeAnswer(data["answer"]);
    }

  }

  deleteModalAlert(_function, selector=null){

    $(".splash-notification-alert").remove();

    var body = `
      <div class="splash-notification-alert" >
         <div class="splash-notification-alert-container" >
          <p>`+this.translate.content("tr_9f9eb51b03430c96b23bb56d647d766b")+`</p>
          <div class="splash-notification-alert-buttons" >
            <span class="splash-notification-alert-yes" >`+this.translate.content("tr_e04af96afe53462f72f39331b209a810")+`</span>
            <span class="splash-notification-alert-no" >`+this.translate.content("tr_d0cd2248137f1acac2e79777d856305e")+`</span>
          </div>
         </div>
      </div>
    `;

    $("body").append(body);

    $(".splash-notification-alert").fadeIn(300);

    document.querySelector('.splash-notification-alert-yes').onclick = function() {
      $(".splash-notification-alert").fadeOut(300);
      _function();
    };

    document.querySelector('.splash-notification-alert-no').onclick = function() {
      $(".splash-notification-alert").fadeOut(300, function(){
          $(".splash-notification-alert").remove();
      });
    };

  }

  deleteByAlert(route=null,params=null){

    var thisClass = this;

    this.deleteModalAlert(() => {

        this.request({url:route, data: params}, function(data) {

          if(data["status"] == true){
              if(data["redirect"] != undefined){
                 location.href = data["redirect"];
              }else{
                 location.reload();
              }
          }

        });

    });

  }

  loadCaptcha(container){
     $(container).html('<div class="spinner-border spinner-border-sm text-primary" role="status"></div>');
     this.request({url:"captcha",dataType: "html",cache: false}, function(data) {
       $(container).html('<img src="'+data+'" >');
     });
  }

  openCaptcha(captcha_id, element=null){
     var thisClass = this;
     
     this.loadModal("captcha", {captcha_id: captcha_id}, function(data) {
         thisClass.loadCaptcha('.captchaModalImageContainer');
     },element);

  }

  copyToClipboard(value){

    navigator.clipboard.writeText(value);

    this.showNoticeAnswer(this.translate.content("tr_f70b4aef6db4db098688e67ca61c4c3c"), "success");

  }

  endingWord(number, one, two, five){

      number = number % 100;

      if ((number > 4 && number < 21) || number == 0){
          ending = five;
      }else{
          last_digit = number.substr(-1);
          if (last_digit > 1 && last_digit < 5)
              ending = two;
          else if (last_digit == 1)
              ending = one;
          else
              ending = five;
      }
      return ending;

  }

  uniSelectUpdate(){

     var _this = this;

     $('.uni-select').each(function (index, element) {
          
          if( $(element).find(".uni-select-item-active").length == 1 ){
             $(element).find(".uni-select-name").html($(element).find(".uni-select-item-active span").html());
          }else if( $(element).find(".uni-select-item-active").length > 1 ){
             $(element).find(".uni-select-name").html(_this.translate.content("tr_c8775dcb5146e06356e352b69bb89764")+" ("+$(element).find(".uni-select-item-active").length+")" );
          }else if($(element).find(".uni-select-content-input").length){

              var name = $(this).find(".uni-select-name");

              if($(element).find("input[data-type=from]").val() && $(element).find("input[data-type=to]").val()){
                 name.html(_this.translate.content("tr_996b125bc9bba860718d999df2ecc61d")+" "+$(element).find("input[data-type=from]").val()+" "+_this.translate.content("tr_538dc63d3c6db1a1839cafbaf359799b")+" "+$(element).find("input[data-type=to]").val());
              }else if($(element).find("input[data-type=from]").val()){
                 name.html(_this.translate.content("tr_996b125bc9bba860718d999df2ecc61d")+" "+$(element).find("input[data-type=from]").val());
              }else if($(element).find("input[data-type=to]").val()){
                 name.html(_this.translate.content("tr_c2aa9c0cecea49717bb2439da36a7387")+" "+$(element).find("input[data-type=to]").val());
              }else if($(element).find("input[data-type=text]").val()){
                 name.html($(element).find("input[data-type=text]").val());
              }else{
                 name.html(name.data("default-name"));
              }            

          }

     });    

  }

  checkFlashNotify(){

     var _this = this;

     _this.request({url:"check-flash-notify"}, function(data) {
        if(data != null && data != undefined){
           $.each(data,function(index,value){
             _this.showNotice(value["type"], value["message"]);
           });
        }
     });

  }

  loadModal(target=null,params=null,callback=null,element=null){

      var _this = this;

      $('.modal').modal('hide');

      if($(".modalContent").length){
          $(".modalContent").remove();
      }

      $("body").append(`
        <div class="modalContent" >
        </div>
      `);

      this.request({url:"modal-open", data: {target: target, params: params}}, function(data) {

         $(".modalContent").html(data["content"]);
         _this.openModal(target+"Modal",null,element,params);
         if(callback) callback();

      });

  }

  paramsForm(selector){
     return $.param($(selector).serializeArray().filter(function(el) {
         return $.trim(el.value);
     }));  
  }

  setParamsFormUrl(selector){
     var hashes = window.location.href.split('?');
     var params = $.param($(selector).serializeArray().filter(function(el) {
             return $.trim(el.value);
         }));
     if(params){
        history.pushState("", "", hashes[0]+"?"+params);
     }else{
        history.pushState("", "", hashes[0]);
     }
  }

  initPhoneMask(){

     if($(".phoneMask").length){

        if($(".phoneMask").attr("data-init") == undefined){

          $(".phoneMask").attr("data-init", true);

          $.mask.definitions['9'] = false;
          $.mask.definitions['_'] = "[0-9]";

          $(".phoneMask").each(function(index,item){

            if($(item).data("phone-template")){
              $(".phoneMask").mask($(item).data("phone-template"));
            }

          });
          
        }

     }

  }

  setPhoneMask(selector, template){

     if($(selector).length){

        $.mask.definitions['9'] = false;
        $.mask.definitions['_'] = "[0-9]";

        $(selector).mask(template);

     }

  }

}

window.Helpers = Helpers;