{% extends index.tpl %}

{% block head %}
<link rel="canonical" href="{{ $template->component->ads_categories->buildAliases((array)$template->component->catalog->data->category) }}"/>
{% endblock %}

{% block content %}

<div class="container mt20" >

<div class="row" >

  <div class="col-lg-12" >

    <nav aria-label="breadcrumb" class="mb15" >

      <ol class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">

        <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
          <a itemprop="item" href="{{ outLink(); }}">
          <span itemprop="name">{{ translate("tr_047f5653b183292396e67f14c8750b73") }}</span></a>
          <meta itemprop="position" content="1">
        </li>

        {% if($template->component->catalog->data->category): %}
        {{ $template->component->catalog->outBreadcrumb(); }}
        {% else: %}
        <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
          <span itemprop="name">{{ $seo->h1; }}</span>
          <meta itemprop="position" content="2">
        </li>
        {% endif %}

      </ol>

    </nav>

    <h1 class="font-bold" >{{ $seo->h1; }}</h1>

    <div class="widget-categories-or-subcategories mt25" >
      
      <div class="widget-categories-or-subcategories-hide" >
        <div class="row" >
          {{ $template->component->ads_categories->outCategoriesOrSubCategoriesByCatalog(); }}
        </div>
      </div>

      <div class="widget-categories-or-subcategories-button-all" >
         
        <span class="btn-custom-mini button-color-scheme1">{{ translate("tr_b904c7e4dbcaafdca6a56f72c3700eb7") }}</span>

      </div>

    </div>

    {{ $template->component->catalog->outPromoBanners() }}
    {{ $template->component->catalog->outStories() }}

    {{ $template->component->ads_filters->outFilterLinks() }}

    <div class="row mt25" >
      
      <div class="col-md-3 col-12 d-none d-lg-block" >
        
        <div class="catalog-sidebar" >

          <form class="params-form live-filters params-form-sticky" >
          {{ $template->component->catalog->buildParamsForm($_GET, $template->component->catalog->data->category->id); }}

          <div class="params-buttons-sticky" >
            
            {{ $template->component->ads_filters->outButtonExtraFilters($template->component->catalog->data->category->id) }}
            
            <button class="btn-custom button-color-scheme1 width100 actionApplyLiveFilters" >{{ translate("tr_130bbbc068f7a58df5d47f6587ff4b43") }}</button>

            {% if($_GET["filter"]): %}
            <button class="btn-custom button-color-scheme3 width100 mt5 actionClearLiveFilters">{{ translate("tr_02d901c131a1b8c2d1dd669e1f6c88a5") }}</button>
            {% endif %}

          </div>

          </form>

        </div>

      </div>

      <div class="col-md-9 col-12" >

        <div class="catalog-container-options" >
          
          <div class="row" >
            <div class="col-md-6 col-12" >

              <div class="catalog-container-links-inline" >
               {% if($template->component->profile->isSavedSearch()): %}
               <span class="actionSaveSearch catalog-container-links-inline-item" >{{ translate("tr_f6acf24dca325b44869ec3fe34ef5083") }}</span>
               {% else: %}
                <span class="actionSaveSearch catalog-container-links-inline-item" >{{ translate("tr_852be42059679d4e4fef58aad5f3fa2f") }}</span>
               {% endif %}

               {% if($template->component->catalog->data->category->change_city_status): %}
               <a class="catalog-container-links-inline-item" href="{{ $template->component->catalog->outLinkMap(); }}" >{{ translate("tr_666bf8c669656fd744a2ae5e889ca47e") }}</a>
               {% endif %}
               
              </div>

            </div>
            <div class="col-md-6 col-12 text-end" >

              <div class="catalog-container-options-links-inline catalog-container-options-links-inline-sorting" >
                <div>{{ $template->component->catalog->outLinkSorting(); }}</div>
                <div>
                  <div class="catalog-container-options-view-item text-end catalog-action-change-view-item" >

                    <span {% if($template->component->catalog->getViewItems($template->component->catalog->data->category->id) == "grid"): %} class="active" {% endif; %} data-view="grid" > <i class="ti ti-layout-grid"></i> </span>
                    <span {% if($template->component->catalog->getViewItems($template->component->catalog->data->category->id) == "list"): %} class="active" {% endif; %} data-view="list" > <i class="ti ti-list-details"></i> </span>                

                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
        
        <div class="container-load-items mt30" >
          
          <div class="row row-cols-2 g-2 g-lg-3" >
            {% component items/skeleton.tpl %}
          </div>

        </div>

      </div>

    </div>

     {% if($seo->h2): %}
         <section class="home-seo-text mt30" >
            <h2 class="font-bold mb15" >{{ $seo->h2 }}</h2>
            {{ $seo->text }}
         </section>
     {% endif %}

  </div>


</div>

</div>

{{ $template->ui->tpl('modals/extra-filters-modal.tpl')->modal("extraFilters", "medium", ["filters"=>$_GET["filter"], "category_id"=>$template->component->catalog->data->category->id]) }}

{% endblock %}