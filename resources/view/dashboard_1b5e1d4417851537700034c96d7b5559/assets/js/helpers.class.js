/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

import Routes from './routes.js';
import Configs from './config.js';
let Translate = new window.Translate();

export default class Helpers {

  constructor() {

    this.timerId;
    this.configs = Configs;
    this.routes = Routes;
    this.translate = Translate;

  }

  config(value){
    return this.configs[value];
  }

  getUrl(){
    return window.location.pathname+window.location.search;
  }

  getUrlParams(){
    var result = window.location.href.split('?');
    return result[1];
  }

  amount(amount=0){

    var spacing;

    var splitAmount = amount.toFixed(2).split(".");

    if(splitAmount[1] != "00"){
      amount = amount.toFixed(2);
    }

    if(this.config("system_currency_spacing")){ spacing = " "; }else{ spacing = ""; }

    if(this.config("system_currency_position") == "start"){
        return this.config("system_default_currency")+spacing+amount;
    }else{
        return amount+spacing+this.config("system_default_currency");
    }

  }

  ajaxData(data,button){
    if(data["auth"] == false){
      this.goToRoute(data["route"]);
    }else if(data['access'] == false){
      this.showNoticeAnswer(this.translate.content("tr_81fbe414c925f2d4a6b0aaaceaf7ad35"), "warning");
      if(button != undefined) this.endProcessLoadButton(button);
      return false;
    }    
    return true;
  }

  request(params,callback) {

      var thisClass = this;
      var checkAccess = true;

      if(params["checkAccess"] != undefined){
        checkAccess = params["checkAccess"];
      }
      
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      try {

          $.ajax({url: this.getRoute(params["url"]),type: params["type"] ? params["type"] : 'POST',data: params["data"] ? params["data"] : null,dataType: params["dataType"] ? params["dataType"] : "json", contentType: params["contentType"], processData: params["processData"],success: function(data) {
              if(checkAccess){
                if(thisClass.ajaxData(data,params["button"])){
                  callback(data);
                }
              }else{
                callback(data);
              }
              if($(".selectpicker").length) $(".selectpicker").selectpicker("render");
              thisClass.hideUiLoadingScreen();
          }});   

      } catch (error) {
          console.log(error);
      }

  }

  loadBody(route=null, callback){
      
      var url = window.location.pathname;

      $.ajax({url: route ? route : url,type: 'POST',data: $(".app-preload-body").data("params"),dataType: "html",success: function(data) {
          $(".app-preload-body").html(data);
          if($(".selectpicker").length) $(".selectpicker").selectpicker("render");
          callback(data);
      }});

  }

  endTimeoutProcessLoadButton(thisButton){
    if(thisButton.prop('disabled') == true){
      this.showNotice('warning', helpers.translate.content("tr_591748d1823e3851eb1872326e3d8b13"));
      thisButton.find('span.spinner-border').remove();
      thisButton.prop('disabled', false);
    }
    clearInterval(this.timerId);
  }

  startProcessLoadButton(thisButton){

    if(this.timerId){
      clearInterval(this.timerId);
    }

    this.timerId = setInterval(()=>this.endTimeoutProcessLoadButton(thisButton), 20000);

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

    toastr.clear();

    toastr.options = {
      maxOpened: 1,
      autoDismiss: true,
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: true,
      positionClass: 'toast-top-center',
      preventDuplicates: false,
      onclick: null,
      rtl: false,
      hideDuration: 500,
      timeOut: 2000,
    };

    if(type == 'warning'){
      toastr.warning(text);
    }else if(type == 'success'){
      toastr.success(text);
    }else if(type == 'error'){
      toastr.error(text);
    }

  }

  openModal(idModal, size=null, element=null){

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
           $('#'+idModal).attr("data-parent-modal-id", $(element).parents(".modal").attr("id"));
       }
    }

    $('#'+idModal).modal('show');

  }

  hideModal(idModal, element=null){

    $('#'+idModal).modal('hide');

    if(element){
      if($(element).parents(".modal").attr("data-parent-modal-id") != undefined){
          this.openModal($(element).parents(".modal").attr("data-parent-modal-id"));
      }
    }

    $(".modal").removeAttr('data-parent-modal-id');

  }

  openNotifyModal(answer){

    if(answer != '' && answer != undefined){
      $('#forbiddenModal .messageForbiddenModal').html(answer);
      this.openModal("forbiddenModal");
    }

  }

  showNoticeAnswer(data, type="success"){
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
    }
  }

  formNoticeManager(selector=null,data){

    if(data["answer"] != undefined){
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
          }else{

              $('#forbiddenModal .messageForbiddenModal').html(data["answer"]);
              thisClass.openModal("forbiddenModal");            

          }

        });

    });

  }

  loadCaptcha(container){
     $(container).html('<div class="spinner-border spinner-border-sm text-primary" role="status"></div>');
     this.request({url:"dashboard-captcha",dataType: "html",cache: false}, function(data) {
       $(container).html('<img src="'+data+'" >');
     });
  }

  initCountryPhoneInput(){

    var newClass;
    var intlTel;
    var thisClass = this;

    $(".inputPhoneAllCountry").each(function(index,item){

       newClass = "phone"+thisClass.generateStr(10);
       $(item).addClass(newClass);

       intlTel = window.intlTelInput(document.querySelector("."+newClass), {
         initialCountry: $(item).data("code") != undefined && $(item).data("code") != "" ? $(item).data("code") : "ru",
         separateDialCode: true,
         formatOnDisplay: true,
         utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@21.2.7/build/js/utils.js",   
       });

       $(document).on("countrychange", "."+newClass, function(e) {
         var selectedCountryData = intlTel.getSelectedCountryData();
         $(this).parents(".containerPhoneAllCountry").find("input[name=phone_code]").val(selectedCountryData.iso2);
       });

    });

  }

  copyToClipboard(value){

    navigator.clipboard.writeText(value);

    this.showNoticeAnswer(this.translate.content("tr_f70b4aef6db4db098688e67ca61c4c3c"), "success");

  }

  checkFlashNotify(){

     var _this = this;

     _this.request({url:"dashboard-check-flash-notify"}, function(data) {
        if(data != null && data != undefined){
           $.each(data,function(index,value){
             _this.showNotice(value["type"], value["message"]);
           });
        }
     });

  }

  translite(text=null, outInput){

     this.request({url:"dashboard-translite",data: "text="+text, cache: false}, function(data) {
        outInput.val(data["result"]);
     });

  }

}

window.Helpers = Helpers;
