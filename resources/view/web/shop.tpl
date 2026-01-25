{% extends index.tpl %}

{% block content %}

<div class="container mt20 mb50" >

<div class="row" >
  
  <div class="col-md-12" >

    {{ $template->component->shop->outStatusInCardShop($data); }}

    {% if($data->banners): %}

    <div class="personal-shop-banners personal-shop-banners-swiper" >

        <div class="personal-shop-banners-prev" ><i class="ti ti-chevron-left"></i></div>
        <div class="personal-shop-banners-next" ><i class="ti ti-chevron-right"></i></div>

        <div class="personal-shop-banners-items swiper-wrapper" >
        {% foreach($data->banners as $item): %}

          <div class="personal-shop-banners-item swiper-slide" >

            {% if($data->owner): %}
            <div class="personal-shop-banners-control-floating" >
              <span class="actionChangeShopBanner" data-id="{{ $data->shop->id }}" ><i class="ti ti-plus"></i></span>
              <span class="actionDeleteShopBanner" data-id="{{ $item["id"] }}" ><i class="ti ti-trash"></i></span>
            </div>
            {% endif %}

            <div class="personal-shop-banners-item-slide" >
              <img src="{{ $item["image"] }}" class="image-autofocus" >
            </div>

          </div>

        {% endforeach %}
        </div>
      
    </div>

    {% else: %}

        {% if($data->owner): %}
        <div class="personal-shop-banners-item personal-shop-banners-item-control" >
          <span class="actionChangeShopBanner" data-id="{{ $data->shop->id }}" ><i class="ti ti-plus"></i></span>
        </div>
        {% endif %}

    {% endif %}

    {% if($data->tariff->items->shop_page): %}
      {% if($template->component->shop->countPages($data->shop->id)): %}
      <div class="personal-shop-pages mb20 d-none d-lg-block" >
         {{ $template->component->shop->outPages($data, "btn-custom-mini button-color-scheme2 personal-shop-pages-item") }}
      </div>
      {% endif %}
    {% endif %}

  </div> 

</div>

<div class="row" >

  {% if($data->shop->status == "published"): %}

  <div class="col-md-3 mb10" >

    {% component shop-sidebar.tpl %}

    {% if($data->owner): %}
    <span class="btn-custom button-color-scheme3 mt10 width100 openModal" data-modal-id="editShopModal" >{{ translate("tr_eaab1d245ac852b2db7cbdbd8b6a5e90") }}</span>
    {% if($data->tariff->items->shop_page): %}
    <span class="btn-custom button-color-scheme3 mt5 width100 actionOpenStaticModal" data-modal-target="addPageShop" data-modal-params="{{ buildAttributeParams(["id"=>$data->shop->id]) }}" >{{ translate("tr_c1423e381b18426e6ab959551b96589a") }}</span>
    {% endif %}
    {% endif %}

  </div>

  <div class="col-md-9" >

      <div class="shop-home-catalog mb50" >

        <h2 class="font-bold mt10 mb25">{{ translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c") }}</h2>

        {% if($data->items): %}
        <div class="row row-cols-2 g-2 g-lg-3" >
          {{ $data->items }}
        </div>
        <a class="btn-custom-mini button-color-scheme3 mt10" href="{{ $template->component->shop->linkToCatalog($data->shop->alias); }}">{{ translate("tr_1cc7e7972b8c9daa5e9c8e94483acc7d") }}</a>
        {% else: %}

          <div class="mt25 not-found-title-container" >
             <div class="not-found-title-container-image" >🧐</div>
             <p>{{ translate("tr_abe40b620b33b61056d38cfd4f6e2ff2") }}</p>           
          </div>

        {% endif %}

        <h2 class="font-bold mt25">{{ translate("tr_1c3fea01a64e56bd70c233491dd537aa") }}</h2>

        {% if($data->reviews): %}

        {{ $template->component->reviews->outAllMediaByUserId($data->user->id) }}

        <div class="row row-cols-2 g-2 g-lg-3 mt25" >{{ $data->reviews }}</div>

        {% else: %}

          <div class="mt25 not-found-title-container" >
             <div class="not-found-title-container-image" >🧐</div>
             <p>{{ translate("tr_5781a644de7a7276ce1b079f9f27fafe") }}</p>           
          </div>

        {% endif %}      
        
      </div>      

  </div>

  {% else: %}

  <div class="col-md-12 text-center" >

        <div class="mt25 not-found-title-container" >
           <h4>{{ translate("tr_48c2c701ace11f20b598250c6661a922") }}</h4>
           <a class="btn-custom button-color-scheme1 mt15" href="{{ $template->component->catalog->currentAliases() }}">{{ translate("tr_eb557c3195702637b89955607c188486") }}</a>
        </div>     

  </div>

  {% endif; %}

</div>

</div>

{% if(!$data->owner): %}
<div class="shop-floating-menu d-block d-lg-none" >
  <div class="row g-2" >

     <div class="col-6" >
       <button class="btn-custom-mini button-color-scheme1 width100 actionOpenDialogueSendMessage" data-params="{{ $template->component->chat->buildParams(['whom_user_id'=>$data->user->id]) }}" >{{ translate("tr_014478b5b412ab74b6a95f968d4e413d") }}</button>
     </div>
     <div class="col-6" >
      {% if($template->component->profile->isSubscription($template->user->data->id, $data->user->id)): %}
      <button class="btn-custom-mini button-color-scheme3 width100 actionSubscribeUser" data-id="{{ $data->user->id }}" >{{ translate("tr_d2023e4c921d1cc5865f230480442d3c") }}</button>
      {% else: %}
      <button class="btn-custom-mini button-color-scheme3 width100 actionSubscribeUser" data-id="{{ $data->user->id }}" >{{ translate("tr_3b1913989f1a538261b8abf5ffc88d4b") }}</button>
      {% endif %}
     </div>

  </div>
</div>
{% endif %}

{% if($data->owner): %}
{{ $template->ui->tpl('modals/edit-shop-modal.tpl')->modal("editShop", "medium", $data->shop); }}
{% endif %}

{% endblock %}