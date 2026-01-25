{% extends index.tpl %}

{% block head %}
<meta property="og:title" content="{{ $seo->meta_title }}">
<meta property="og:url" content="{{ $template->component->ads->buildAliasesAdCard($data) }}">
<meta property="og:description" content="{{ $seo->meta_desc }}">
<meta property="og:image" content="{{ $data->media->images->first }}">
{% endblock %}

{% block content %}

<div class="container mt20 mb40" >

    <nav aria-label="breadcrumb" class="mb15" >

      <ol class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">

        <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
          <a itemprop="item" href="{{ outLink(); }}">
          <span itemprop="name">{{ translate("tr_047f5653b183292396e67f14c8750b73") }}</span></a>
          <meta itemprop="position" content="1">
        </li>

        {{ $template->component->ads->outBreadcrumb($data); }}

      </ol>

    </nav>

    {{ $template->component->ads->outStatusInCardAd($data); }}

    {{ $template->component->ads->outActiveServicesInCardAd($data); }}

    {% if($data->owner): %}
    <div class="ad-card-info-stat" >
        <div class="ad-card-info-stat-item actionOpenStaticModal" data-modal-target="infoAdStatUsers" data-modal-params="{{ buildAttributeParams(["id"=>$data->id, "view"=>"cart"]) }}" >
            <i class="ti ti-shopping-cart-plus"></i>
            <span>{{ $template->component->ads->getExtraStatCount($data->id)->cart }}</span>
        </div>
        <div class="ad-card-info-stat-item actionOpenStaticModal" data-modal-target="infoAdStatUsers" data-modal-params="{{ buildAttributeParams(["id"=>$data->id, "view"=>"favorite"]) }}" >
            <i class="ti ti-heart-plus"></i>
            <span>{{ $template->component->ads->getExtraStatCount($data->id)->favorite }}</span>
        </div>
        <div class="ad-card-info-stat-item actionOpenStaticModal" data-modal-target="infoAdStatUsers" data-modal-params="{{ buildAttributeParams(["id"=>$data->id, "view"=>"contacts"]) }}" >
            <i class="ti ti-address-book"></i>
            <span>{{ $template->component->ads->getExtraStatCount($data->id)->view_contacts }}</span>
        </div>
    </div>
    {% endif %}

    <div class="row" >

      <div class="col-md-9" >

        <h1 class="font-bold text-break-word" >{{ $seo->h1; }}</h1>

        <div class="ad-card-info-line" >
          <span>{{ $template->datetime->outLastTime($data->time_create); }}</span>
          <span><i class="ti ti-eye"></i> {{ $template->component->ads->getViews($data->id); }} ({{ $template->component->ads->getViewsToday($data->id); }} {{ translate("tr_a9705117762f35c4940a622bc9940a01") }})</span>
          <span>№{{ $data->article_number; }}</span>
        </div>

      </div>

      <div class="col-md-3 text-end" >

        {% if($data->owner): %}
        <div class="ad-card-menu-line" >
          <span class="ad-card-menu-line-item active-scale actionOpenStaticModal" data-modal-target="adShare" data-modal-params="{{ buildAttributeParams(["id"=>$data->id]) }}" ><i class="ti ti-share-3"></i></span>
        </div>
        {% else: %}
        <div class="ad-card-menu-line" >

          {% if($template->user->isAuth()): %}
          <span class="action-to-favorite actionManageFavorite ad-card-menu-line-item active-scale" data-id="{{ $data->id; }}" > {% if($data->in_favorites): %} <i class="ti ti-heart-filled"></i> {% else: %} <i class="ti ti-heart"></i> {% endif %} </span>
          <span class="ad-card-menu-line-item active-scale actionOpenStaticModal" data-modal-target="adShare" data-modal-params="{{ buildAttributeParams(["id"=>$data->id]) }}" ><i class="ti ti-share-3"></i></span>
          <span class="ad-card-menu-line-item" > 
            
            <div class="uni-dropdown">
              <span class="uni-dropdown-name"> <i class="ti ti-dots"></i> </span>  
              <div class="uni-dropdown-content uni-dropdown-content-align-right" >
               <span class="uni-dropdown-content-item actionOpenStaticModal" data-modal-target="adComplain" data-modal-params="{{ buildAttributeParams(["id"=>$data->id]) }}" >{{ translate("tr_a7d9ae0c14b6559b102994d3f798a934") }}</span>
              </div>               
            </div>

          </span>
          {% else: %}
          <span class="ad-card-menu-line-item active-scale actionOpenStaticModal" data-modal-target="adShare" data-modal-params="{{ buildAttributeParams(["id"=>$data->id]) }}" ><i class="ti ti-share-3"></i></span>
          {% endif %}

        </div>
        {% endif %}

      </div>      

      <div class="col-md-12" >
          <div class="mt30" >
              {{ $template->component->ads->outMediaGalleryInCard($data, ["height"=>"300px"]); }}
          </div>        
      </div>

    </div>

    <div class="row mt20" >
      <div class="col-md-12 col-lg-9 col-12 col-sm-12 order-lg-1 order-2" >

          <div class="ad-card-content" >

            {% if(!$data->owner): %}
            <div class="ad-card-content-info-box-container content-info-box-swiper" >
              
              <div class="swiper-wrapper" >

                {% if($data->user->verification_status): %}
                <div class="ad-card-content-info-box swiper-slide" >
                   <strong>{{ translate("tr_d166070a6ff746806290ce4eb118c519") }}</strong>
                   <p>{{ translate("tr_84e690943a800bb844348787d3822f91") }}</p>
                </div>
                {% endif %}

                {% if($data->booking_status && $template->component->ads_categories->categories[$data->category_id]["booking_action"] == "booking"): %}
                <div class="ad-card-content-info-box swiper-slide" >
                   <strong>{{ translate("tr_e01455d6488a28892a1e696ff34b2588") }}</strong>
                   <p>{{ translate("tr_8008b2f2e6f1541bfe6eb7a9780b1f16") }}</p>
                </div>
                {% endif %}

                {% if($data->online_view_status): %}
                <div class="ad-card-content-info-box swiper-slide" >
                   <strong>{{ translate("tr_b25662e0ea7b58a615d25d1dbd762766") }}</strong>
                   <p>{{ translate("tr_13ff02489fc934fa9638a0ffa1d354d5") }}</p>
                </div>
                {% endif %}

                {% if($data->delivery_status == 1 && $data->user->delivery_status): %}
                <div class="ad-card-content-info-box swiper-slide" >
                   <strong>{{ translate("tr_c62d9a9729db83c1d8f2de72211c2111") }}</strong>
                   <p>{{ translate("tr_b90bbcd6e88c43efe24b8bbf512dd596") }}</p>
                </div>
                {% endif %}

              </div>

            </div>
            {% endif %}

            {% if($data->geo): %}
            <div class="ad-card-content-item" >
              <p class="ad-card-subtitle" >{{ translate("tr_9a2f0ded92075434b49c94329297a21c") }}</p>

              <div>{{ $template->component->ads->outGeoAndAddressInAdCard($data) }}</div>
              
              {{ $template->component->ads->outGeoMetroInAdCard($data) }}

              {% if($data->address_latitude && $data->address_longitude): %}
              <div><button class="btn-custom button-color-scheme2 mt15 actionAdShowMap">{{ translate("tr_8b766767c5f658ee12f29aba7145955f") }}</button></div>
              <div class="ad-card-content-geo-map initMapAddress" id="initMapAddress" >{{ $template->component->geo->outMapPointAddressInAdCard($data->address_latitude, $data->address_longitude) }}</div>
              {% endif %}

            </div>
            {% endif %}
            
            <div class="ad-card-content-item" >
              <p class="ad-card-subtitle" >{{ translate("tr_38ca0af80cd7bd241500e81ba2e6efff") }}</p>

              <p class="text-break-word" >{{ outTextWithLinks($seo->text); }}</p>
            </div>

            {% if($data->property): %}

            <div class="ad-card-content-item" >
              <p class="ad-card-subtitle" >{{ translate("tr_d6f9a39be4b8938d8499ac3b525abea7") }}</p>

              <div class="ad-card-list-properties">
                {{ $data->property }}
              </div>

            </div>

            {% endif %}

          </div>

          <div class="ad-card-reviews-content" >
            
              <div class="my-tabs-items-big" >
                  <div data-id="1" class="my-tabs-item active" >{{ translate("tr_1c3fea01a64e56bd70c233491dd537aa") }} <span>{{ $data->count_reviews }}</span> </div>
              </div>

              <div class="my-tabs-content-container" >

                <div class="my-tabs-content-1" >
                  
                  <div class="container-reviews-list" >

                    {% if($data->count_reviews): %}

                    {{ $template->component->reviews->outAllMediaByItemId($data) }}
                      
                    {{ $template->component->reviews->outReviewsByItemId($data) }}

                    {% else: %}

                    <p>{{ translate("tr_4dda1a9f6d2523f65f37d0677839cadd") }}</p>

                    {% endif %}
                    
                  </div>                  

                </div>

              </div>

          </div>


      </div>
      <div class="col-lg-3 col-md-12 col-12 col-lg-2 order-1 mb20" >
          
          {% if($data->booking_status && !$data->owner): %}
          <div class="mb15" >

            <div class="ad-card-booking-calendar" data-id="{{ $data->id }}" >
              <div class="ad-card-booking-calendar-range1" style="display: none;" ></div>
              <div class="ad-card-booking-calendar-range2"></div>
            </div>

            <div class="ad-card-booking-calendar-button-order" >
              <span class="btn-custom button-color-scheme7 width100 mt20 mb10" >{{ translate("tr_8451e9509832d0c5d778ea3333902b06") }}</span>
            </div>

          </div>
          {% endif %}

          <div class="ad-card-sidebar" >

              <div class="ad-card-prices" >

                {{ $template->component->ads->outPrices($data) }}

                {{ $template->component->ads->outPriceDifferentCurrenciesInAdCard($data) }}

              </div>

              <div class="ad-card-action-buttons" >
                {{ $template->component->ads->outActionButtonsInAdCard($data) }}
              </div>

              <div class="ad-card-user" >
                
                <div class="ad-card-user-avatar" >
                  
                    <div>
                      <img class="image-autofocus" src="{{ $data->user->shop ? $template->storage->name($data->user->shop->image)->get() : $data->user->avatar_src }}">
                    </div>

                </div>

                <div class="ad-card-user-content" >

                    {% if($data->user->shop): %}
                    <a href="{{ $template->component->shop->linkToShopCard($data->user->shop->alias) }}">{{ $data->user->shop->title }} {{ $template->component->profile->verificationLabel($data->user->verification_status) }} </a>
                    {% else: %}
                    <a href="{{ $template->component->profile->linkUserCard($data->user->alias) }}">{{ $data->user->full_name }} {{ $template->component->profile->verificationLabel($data->user->verification_status) }} </a>
                    {% endif %}

                    <div class="container-user-rating-stars menu-user-rating-stars" >
                        {{ $template->component->profile->outStarsRating($data->user->total_rating) }}
                        <span class="user-rating-stars-count-reviews" >{{ $template->component->profile->outTotalReviews($data->user->total_reviews) }}</span>
                    </div>

                </div>

              </div>

          </div>

          {{ $template->component->ads->outActionButtonsOrderAdCard($data) }}

      </div>

    </div>

    {% if($data->similar_items): %}
    <div class="row mt40" >
      <div class="col-md-12" >

          <div class="ad-card-similar-content" >

              {% if($data->user->service_tariff->items->hiding_competitors_ads): %}

                <h1 class="font-bold" >{{ translate("tr_f6f59e47a711dada3fd8aa7bc2d393ef") }}</h1>

              {% else: %}

                <h1 class="font-bold" >{{ translate("tr_ac1eb1af525b79b5645d1fad58c4612d") }}</h1>

              {% endif %}

              <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3 mt40" >
                {{ $data->similar_items }}
              </div>

          </div>

      </div>

    </div>
    {% endif %}

</div>

{{ $template->ui->tpl('modals/contact-modal.tpl')->modal("contact", "small") }}

{% endblock %}