{% extends index.tpl %}

{% block head %}
<link rel="canonical" href="{{ $template->component->ads_categories->buildAliasesShops($data->category) }}"/>
{% endblock %}

{% block content %}

<div class="container mt20" >

<div class="row" >

  <div class="col-lg-12" >

    <nav aria-label="breadcrumb">

      <ol class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">

        <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
          <a itemprop="item" href="{{ outLink(); }}">
          <span itemprop="name">{{ translate("tr_047f5653b183292396e67f14c8750b73") }}</span></a>
          <meta itemprop="position" content="1">
        </li>

        <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
          <a itemprop="item" href="{{ outRoute('shops') }}">
          <span itemprop="name">{{ translate("tr_cfb8af01cc910b08e8796e03cf662f5f") }}</span></a>
          <meta itemprop="position" content="2">
        </li>

        {% if($data->category): %}
        <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
          <a itemprop="item" href="{{ $template->component->ads_categories->buildAliasesShops($data->category) }}">
          <span itemprop="name">{{ $data->category["name"] }}</span></a>
          <meta itemprop="position" content="3">
        </li>
        {% endif %}

      </ol>

    </nav>

    <div class="widget-categories-or-subcategories mt25" >
      
      <div class="widget-categories-or-subcategories-hide" >
        <div class="row" >
          {{ $template->component->ads_categories->outCategoriesByShops($data->category["id"]); }}
        </div>
      </div>

      <div class="widget-categories-or-subcategories-button-all" >
         
        <span class="btn-custom-mini button-color-scheme1">{{ translate("tr_b904c7e4dbcaafdca6a56f72c3700eb7") }}</span>

      </div>

    </div>

    <h1 class="font-bold mt25" >{{ $seo->h1; }}</h1>

    <div class="mt40" >
      
        <div class="shops-container-items" >
          
          <div class="row row-cols-2 g-2 g-lg-3" >
            {% component items/skeleton-shops.tpl %}
          </div>

        </div>

        <input type="hidden" name="shops_category_id" value="{{ $data->category ? $data->category["id"] : '0'  }}" >

    </div>

  </div>


</div>

</div>

{% endblock %}