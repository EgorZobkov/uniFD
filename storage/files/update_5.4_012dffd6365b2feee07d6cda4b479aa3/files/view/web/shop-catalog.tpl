{% extends index.tpl %}

{% block content %}

<div class="container mt20 mb100" >

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

          <div class="personal-shop-banners-item-slide" >
            <img src="{{ $item["image"] }}" class="image-autofocus" >
          </div>

        </div>

      {% endforeach %}
      </div>

    </div>

    {% endif %}

    {% if($data->tariff->items->shop_page): %}
      {% if($template->component->shop->countPages($data->shop->id)): %}
      <div class="personal-shop-pages mb20 d-none d-lg-block" >
         {{ $template->component->shop->outPages($data, "btn-custom-mini button-color-scheme2 personal-shop-pages-item"); }}
      </div>
      {% endif %}
    {% endif %}

  </div> 

</div>

<div class="row" >

  {% if($data->shop->status == "published"): %}

  <div class="col-md-3 mb10" >

      {% component shop-sidebar.tpl %}

      <div class="mt20 d-none d-lg-block" >
        <form class="params-form live-filters params-form-sticky" >

          {{ $template->component->catalog->buildParamsForm($_GET, $data->category->id) }}

          <div class="params-buttons-sticky" >

            {{ $template->component->ads_filters->outButtonExtraFilters($data->category->id) }}

            <button class="btn-custom button-color-scheme1 width100 actionApplyLiveFilters" >{{ translate("tr_130bbbc068f7a58df5d47f6587ff4b43") }}</button>

            {% if($_GET["filter"]): %}
            <button class="btn-custom button-color-scheme3 width100 mt5 actionClearLiveFilters">{{ translate("tr_02d901c131a1b8c2d1dd669e1f6c88a5") }}</button>
            {% endif %}

          </div>

        </form>
      </div>

  </div>

  <div class="col-md-9 col-12" >

      <div>
        <div class="row" >
            <div class="col-lg-9 col-12 col-md-9 d-none d-lg-block" >
              
                <div class="shop-catalog-search-container" >
                  <form class="live-shop-search-form" method="get" action="{{ $template->component->shop->linkToCatalog($data->shop->alias) }}">
                      <button class="live-search-form-icon"><i class="ti ti-search"></i></button>
                      <input type="text" name="search" class="live-search-form-input" autocomplete="off" placeholder="{{ translate("tr_5466fabe16a5487db24c8e71e50cf160") }}" value="{{ $_GET['search'] }}"> 
                  </form> 
                </div>

            </div>
            <div class="col-lg-3 col-12 col-md-3" >

                <div class="uni-dropdown">

                     <button class="btn-custom button-color-scheme3 width100 action-open-uni-dropdown" >{{ translate("tr_6926e02be4135897ae84b36941554684") }}</button>

                     <div class="uni-dropdown-content uni-dropdown-content-top-50 uni-dropdown-content-custom-link uni-dropdown-content-width-300 uni-dropdown-content-align-right" >
                        <a href="{{ $template->component->shop->linkToCatalog($data->shop->alias) }}" >{{ translate("tr_53660e081bed47bc53e7d4d247f7b15d") }}</a>
                        {{ $template->component->shop->outCategoriesList($data->shop->id) }}
                     </div>   

                </div>

            </div>          
        </div> 
      </div>    

      <div class="catalog-container-options mt20" >
        
        <div class="row" >
          <div class="col-md-12 col-12 text-end" >

            <div class="catalog-container-options-links-inline" >
              <div>{{ $template->component->catalog->outLinkSorting(); }}</div>
              <div>
                <div class="catalog-container-options-view-item text-end catalog-action-change-view-item" >

                  <span {% if($template->component->catalog->getViewItems() == "grid"): %} class="active" {% endif; %} data-view="grid" > <i class="ti ti-layout-grid"></i> </span>
                  <span {% if($template->component->catalog->getViewItems() == "list"): %} class="active" {% endif; %} data-view="list" > <i class="ti ti-list-details"></i> </span>                

                </div>
              </div>
            </div>

          </div>
        </div>

        {% if($seo->h1): %}
        <h1 class="font-bold mt20">{{ $seo->h1 }}</h1>
        {% endif %}

      </div>

      <div class="shop-catalog-container mt30" >

        <div class="row row-cols-2 g-2 g-lg-3" >
          {% component items/skeleton.tpl %}
        </div>

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

{{ $template->ui->tpl('modals/extra-filters-modal.tpl')->modal("extraFilters", "medium", ["filters"=>$_GET["filter"], "category_id"=>$data->category->id]) }}

{% endblock %}