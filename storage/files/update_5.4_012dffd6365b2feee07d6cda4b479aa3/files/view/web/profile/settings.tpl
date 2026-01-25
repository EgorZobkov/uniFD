{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

        <h3> <strong>{{ translate("tr_c919d65bd95698af8f15fa8133bf490d") }}</strong> </h3>

        <div class="profile-settings-sections mt40" >
           <a href="{{ $template->router->getRoute('profile-settings') }}" class="{% if(!$_GET['tab']){ echo 'active'; } %}" >
             <i class="ti ti-adjustments-horizontal"></i>
             <div>{{ translate("tr_cecdd096144eccaeb28c4c2bc233ed63") }}</div>
           </a>
           <a href="{{ requestBuildVars(['tab'=>'payment']) }}" class="{% if($_GET['tab'] == 'payment'){ echo 'active'; } %}" >
             <i class="ti ti-credit-card"></i>
             <div>{{ translate("tr_e3c1f39b86bb7162bddb548e2cfd6077") }}</div>
           </a>
           {% if($template->settings->integration_delivery_services_active): %}
           <a href="{{ requestBuildVars(['tab'=>'delivery']) }}" class="{% if($_GET['tab'] == 'delivery'){ echo 'active'; } %}" >
             <i class="ti ti-truck-delivery"></i>
             <div>{{ translate("tr_b973ee86903271172c9b4f5529bc19bb") }}</div>
           </a>
           {% endif %}
        </div>

        <form class="profile-settings-form mt30" >

          <section class="profile-settings-section" >

            {% if(!$_GET["tab"]): %}

            <h5> <strong>{{ translate("tr_be8570cc6d6814eebc087695b7b27c31") }}</strong> </h5>

            <div class="profile-settings-section-item d-block d-lg-none" >

              <div class="profile-user-sidebar-avatar" >
                <div>
                  <div class="profile-user-sidebar-avatar-change actionChangeUserAvatar" ><i class="ti ti-camera-selfie"></i></div>
                  <img class="image-autofocus" src="{{ $template->user->data->avatar_src }}">
                </div>
              </div>

            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_feef0975aac3bd15d35f5279ae70d0ba") }}</label>
                 </div>
                 <div class="col-md-6" >
                  
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="user_status" value="1" id="user_status1" {% if($template->user->data->user_status == 1): %} checked="" {% endif %}>
                      <label class="form-check-label" for="user_status1">
                        {{ translate("tr_51b6f81095ef3cc7f72bf60031fd95eb") }}
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="user_status" value="2" id="user_status2"  {% if($template->user->data->user_status == 2): %} checked="" {% endif %}>
                      <label class="form-check-label" for="user_status2">
                        {{ translate("tr_1c5009c44310abcfe726e4e1b8f077c1") }}
                      </label>
                    </div>                    

                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item-organization" {% if($template->user->data->user_status == 2): %} style="display: block;" {% endif %} >
              
            <div class="profile-settings-section-item mb10" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_16c3e7e34102c34643e18ddc60acac86") }}</label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="organization_name" value="{{ $template->user->data->organization_name }}" >
                    <label class="form-label-error" data-name="organization_name"></label>
                 </div>
               </div>
            </div>

            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_d38d6d925c80a2267031f3f03d0a9070") }}</label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="name" value="{{ $template->user->data->name }}" >
                    <label class="form-label-error" data-name="name"></label>
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_a7b7df8362d60258a7208dde0a392643") }}</label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="surname" value="{{ $template->user->data->surname }}" >
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_9fdc3f131f7923e7bdd4ec60d465ae87") }}</label>
                 </div>
                 <div class="col-md-6" >
                    {{ $template->ui->outInputPhoneContact($template->user->data->phone, ["input_name"=>"phone"]) }}
                    <label class="form-label-error" data-name="phone"></label>
                    <div class="actionSendVerifyCodePhoneContainer" >
                      <span class="btn-custom-mini button-color-scheme3 actionSendVerifyCodePhone mt10" >{{ translate("tr_e2603bcce79e0b861ac1f1bd464de2b6") }}</span>
                    </div>
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d") }}</label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="email" value="{{ $template->user->data->email }}" >
                    <label class="form-label-error" data-name="email"></label>
                    <div class="actionSendVerifyCodeEmailContainer" >
                      <span class="btn-custom-mini button-color-scheme3 actionSendVerifyCodeEmail mt10" >{{ translate("tr_e2603bcce79e0b861ac1f1bd464de2b6") }}</span>
                    </div>
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_6a061313d22e51e0f25b7cd4dc065233") }}</label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="contacts[max]" value="{{ $template->user->data->contacts->max }}" >
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_c915683f3ec888b8edcc7b06bd1428ec") }}</label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="contacts[telegram]" value="{{ $template->user->data->contacts->telegram }}" >
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_8b777ebcc5034ce0fe96dd154bcb370e") }}</label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="contacts[whatsapp]" value="{{ $template->user->data->contacts->whatsapp }}" >
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_5f0ef7fba904387b273d48f4d71580f3") }}</label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="alias" value="{{ $template->user->data->alias }}" >
                    <label class="form-label-error" data-name="alias"></label>
                    <div class="mt10" > <small>{{ translate("tr_af36f41f9ec895e63ba31441add70ae0") }}</small> </div>
                 </div>
               </div>
            </div>

          </section>

          <section class="profile-settings-section" >

            <h5> <strong>{{ translate("tr_c812c9e8d05c151e233ca2560a4199b6") }}</strong> </h5>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_207a9b18465e35d751d48b4405b6722c") }}</label>
                 </div>
                 <div class="col-md-6" >
                    
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="notifications_method" value="email" id="notifications_method_email" {% if($template->user->data->notifications_method == "email"): %} checked="" {% endif %} >
                      <label class="form-check-label" for="notifications_method_email">
                        {{ translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d") }}
                      </label>
                    </div>

                    {% if($template->settings->profile_notifications_messenger_status): %}

                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="notifications_method" value="telegram" id="notifications_method_telegram" {% if($template->user->data->notifications_method == "telegram"): %} checked="" {% endif %} >
                      <label class="form-check-label" for="notifications_method_telegram">
                        {{ translate("tr_c915683f3ec888b8edcc7b06bd1428ec") }}
                      </label>
                    </div>

                    {% if(!$template->user->data->messenger_token_id): %}
                    <div class="profile-settings-section-notifications-method-telegram" {% if($template->user->data->notifications_method == "telegram"): %} style="display: block;" {% endif %} >
                      <a class="btn-custom-mini button-color-scheme3 mt15" href="{{ outUserLinkTelegramBot($template->user->data->uniq_hash) }}" target="_blank" >{{ translate("tr_539327ce0420a5d3732b9f926abc1cb3") }}</a>
                      <div class="mt10"> <small>{{ translate("tr_2cef0f08cd8777fcc23e8f09f0c439fa") }}</small> </div>
                    </div>
                    {% endif %}

                    {% endif %}

                 </div>
               </div>
            </div>

          </section>

          <section class="profile-settings-section" >

            <h5> <strong>{{ translate("tr_d2ed721d0c08f9f114598a084f24c784") }}</strong> </h5>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_7e264844e4fc7ea0a5ea239f44bc9736") }}</label>
                 </div>
                 <div class="col-md-6" >
                  
                    <label class="switch mt10">
                      <input type="checkbox" class="switch-input" name="notifications[chat]" value="1" {% if($template->user->data->notifications['chat']): %} checked="" {% endif %} >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                    </label>

                    <div class="mt10" > <small>{{ translate("tr_fa5bc234f95aec53134e69a6cd8d2c6e") }}</small> </div>

                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c") }}</label>
                 </div>
                 <div class="col-md-6" >
                  
                    <label class="switch mt10">
                      <input type="checkbox" class="switch-input" name="notifications[expiration_ads]" value="1" {% if($template->user->data->notifications['expiration_ads']): %} checked="" {% endif %} >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                    </label>

                    <div class="mt10" > <small>{{ translate("tr_200213b3d817a409f52ae54aa976ba71") }}</small> </div>

                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_c1019eb5872cd3edd615a45bf988c46a") }}</label>
                 </div>
                 <div class="col-md-6" >
                  
                    <label class="switch mt10">
                      <input type="checkbox" class="switch-input" name="notifications[expiration_tariff]" value="1" {% if($template->user->data->notifications['expiration_tariff']): %} checked="" {% endif %} >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                    </label>

                    <div class="mt10" > <small>{{ translate("tr_584431a939bff261046d0d24726dfa94") }}</small> </div>

                 </div>
               </div>
            </div>

          </section>

          <section class="profile-settings-section" >

            <h5> <strong>{{ translate("tr_3677ee79e51454e8da26eb578c6c4e5c") }}</strong> </h5>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_5ebe553e01799a927b1d045924bbd4fd") }}</label>
                 </div>
                 <div class="col-md-6" >
                    <span class="btn-custom-mini button-color-scheme2 actionOpenStaticModal" data-modal-target="profileChangePassword" >{{ translate("tr_47e2436e5560837160a70c64466ea22b") }}</span>
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <span class="btn-custom-mini button-color-scheme6 actionSettingsDeleteProfile" >{{ translate("tr_05c7740165c17bf42aa8dcfcfaea4f56") }}</span>
               <div class="mt10" ><small>{{ translate("tr_6f1d1801e7fd50410971cb5c1107225f") }}</small></div>
            </div>
            
          </section>

          <div class="row mt40 mb20" >
            <div class="col-md-4" ></div>
            <div class="col-md-4"  ><button class="btn-custom button-color-scheme1 width100 actionSettingsSaveEditProfile" >{{ translate("tr_74ea58b6a801f0dce4e5d34dbca034dc") }}</button></div>
            <div class="col-md-4" ></div>
          </div>

          {% elseif($_GET["tab"] == "payment"): %}

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_2f5c1b9ee6a5e20a9ccb24e72ff9796a") }}</label>
                 </div>
                 <div class="col-md-6" >
                  
                  {{ $template->component->profile->outUserScoreList($template->user->data->id) }}

                  {{ $template->component->profile->outMethodAddScoreUser($template->user->data->id) }}

                  <div class="mt10" > <small>{{ translate("tr_96b91c96f904e8bbae6dd55fa738933d") }}</small> </div>

                 </div>
               </div>
            </div>

          {% elseif($_GET["tab"] == "delivery" && $template->settings->integration_delivery_services_active): %}

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_b973ee86903271172c9b4f5529bc19bb") }}</label>
                 </div>
                 <div class="col-md-6" >
                  
                  <label class="switch mt10">
                    <input type="checkbox" class="switch-input" name="delivery_status" value="1" {% if($template->user->data->delivery_status): %} checked="" {% endif %} >
                    <span class="switch-toggle-slider">
                      <span class="switch-on"></span>
                      <span class="switch-off"></span>
                    </span>
                  </label>

                  <div class="mt10" > <small>{{ translate("tr_3f12c278727d86f71e49583e76c9da9d") }}</small> </div>

                 </div>
               </div>
            </div>          

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label>{{ translate("tr_2e61bbda910e51ea5e79946e41788428") }}</label>
                 </div>
                 <div class="col-md-6" >
                  
                  {{ $template->component->delivery->outDeliveryListInProfile() }}

                  <div class="profile-settings-shipping-points-list" >
                    {{ $template->component->profile->outShippingPointsList() }}
                  </div>

                  <div class="mt10" > <small>{{ translate("tr_ce5032ca9d4153b51cf80c5ae721d861") }}</small> </div>

                 </div>
               </div>
            </div>

          {% endif %}

        </form>

  </div>

</div>

</div>

{{ $template->ui->tpl('modals/profile-add-payment-score-modal.tpl')->modal("addPaymentScore", "small") }}

{% endblock %}