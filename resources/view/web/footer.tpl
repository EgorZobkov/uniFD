{% if($template->view->visible_footer): %}

<footer>
<div class="footer-bg" >
    <div class="container" >

        {% if($template->settings->api_app_section_download_status): %}
        <section class="section-promo-download-app">
          
          <div class="row">
             <div class="col-lg-7">
                
                <h2> <span class="color-title-accent-white">{{ translate("tr_66dbee51023e520794f125d4d842abbb") }} </span> <br> <strong>{{ $template->settings->api_app_project_name }}</strong> </h2>

                <p>{{ translate("tr_60e0bd863451c402d1f35395c4330b10") }}</p>

             </div>
          </div>

          <div class="mt20" style="position: relative; z-index: 2;">
             
             {% if($template->settings->api_app_download_only_apk): %}
             <a href="{{ $template->settings->api_app_download_link_apk }}" class="btn-custom button-color-scheme2">{{ translate("tr_2b217944b57b8ace46974d4fea5c1f98") }}</a>
             {% else: %}

                {% if($template->settings->api_app_download_links["play_market"]): %}
                <a href="{{ $template->settings->api_app_download_links["play_market"] }}" class="btn-custom button-color-scheme2 mr5">Play Market</a>
                {% endif; %}

                {% if($template->settings->api_app_download_links["app_store"]): %}
                <a href="{{ $template->settings->api_app_download_links["app_store"] }}" class="btn-custom button-color-scheme2 mr5">App Store</a>
                {% endif; %}

                {% if($template->settings->api_app_download_links["app_gallery"]): %}
                <a href="{{ $template->settings->api_app_download_links["app_gallery"] }}" class="btn-custom button-color-scheme2 mr5">AppGallery</a>
                {% endif; %}

                {% if($template->settings->api_app_download_links["ru_store"]): %}
                <a href="{{ $template->settings->api_app_download_links["ru_store"] }}" class="btn-custom button-color-scheme2">RuStore</a>
                {% endif; %}

             {% endif; %}

          </div>

          <img src="{{ $template->storage->getAssetImage("smart-app-photo-22215462343.png") }}" class="section-promo-download-app-image-device" height="460">

        </section>
        {% endif; %}

        <div class="footer-bg-box-link-inline" >
            
            <!--<a href="{{ outRoute('shops') }}" class="footer-bg-box-link-inline-item" >{{ translate("tr_cfb8af01cc910b08e8796e03cf662f5f") }}</a>-->
            <a href="{{ outRoute('blog') }}" class="footer-bg-box-link-inline-item" >{{ translate("tr_103a554114af7c598a4f835ac463722e") }}</a>
            <a href="{{ outLink('about') }}" class="footer-bg-box-link-inline-item" >{{ translate("tr_4d4b965543303cec8425b75a4a839242") }}</a>
            <a href="{{ outLink('support') }}" class="footer-bg-box-link-inline-item" >{{ translate("tr_64425f291098b47b020295a65b376177") }}</a>

        </div>  

        <div class="row mt30" >

             <div class="col-md-8" >

                <p class="footer-content-text" >
                  © {{ date("Y") }} {{ $template->settings->project_title; }}
                  <br>
                  {{ $template->settings->contact_organization_name; }}
                </p>
              
                <div class="footer-content-link-inline" >
                  <a href="{{ outLink('rules') }}">{{ translate("tr_65053ca2a9f911a081ff806e7ebd9699") }}</a>
                  <a href="{{ outLink('privacy-policy') }}">{{ translate("tr_5513903457691ab06b8c78a293889379") }}</a>
                </div>
                 
             </div>

             <div class="col-md-4" >

                 {% if($template->ui->outContactSocialLinks()): %}

                 <div class="footer-social-links" >

                    {{ $template->ui->outContactSocialLinks(); }}

                 </div>

                 {% endif; %}

             </div>

        </div>
        
    </div>
</div>
</footer>
{% endif; %}

{% if($template->router->currentRoute->name != "shop-catalog" && $template->router->currentRoute->name != "shop" && $template->router->currentRoute->name != "shop-page" && $template->router->currentRoute->name != "search-by-map"): %}

<div class="main-floating-menu d-block d-lg-none" >

    <a href="{{ outRoute('/') }}">
        <div>
            <span> <i class="ti ti-home"></i> </span>
            <span>{{ translate("tr_3343f5fb00e4115fa416881e7d3f48dc") }}</span>
        </div>
    </a>

    <a href="{{ outRoute('profile-favorites') }}">
        <div>
            <span> <i class="ti ti-heart"></i> </span>
            <span>{{ translate("tr_2fc413929104c1a09ae0a66c48ce0902") }}</span>
        </div>
    </a>

    <a href="{{ outRoute('ad-create') }}">
        <div>
            <span> <i class="ti ti-plus"></i> </span>
            <span>{{ translate("tr_5eba283b81890978e67f4aa96dde1724") }}</span>
        </div>
    </a>

    <a href="#" class="actionOpenModalChat" >
        <div>
            <span> <i class="ti ti-brand-line"></i> </span>
            <span>{{ translate("tr_c52b4c5cbc879d56c633f568acfbf205") }} <span class="label-circle-count chat-icon-counter labelChatCountMessages" ></span> </span>
        </div>
    </a>

    <a href="{{ outRoute('profile') }}">
        <div>
            <span> <i class="ti ti-mood-tongue-wink"></i> </span>
            <span>{{ translate("tr_a46c372347e02010f5ef45fe441e4349") }}</span>
        </div>
    </a>

</div>

{% endif; %}

<div class="footer-cookie-container" >
    <div>
        <h6> <strong>{{ translate("tr_f9bee2e2665098394863732ab76d7798") }}</strong> </h6>
        <p>{{ translate("tr_db44a56d204b8cc138511293df30f1f6") }}</p>
        <span class="btn-custom-mini button-color-scheme1 actionCookieHide" >{{ translate("tr_55677a568e9c2b3c6a55545a1e9b8800") }}</span>
    </div>
</div>