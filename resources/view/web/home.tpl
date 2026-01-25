{% extends index.tpl %}

{% block head %}
<meta property="og:image" content="{{ $template->storage->logo() }}">
{% endblock %}

{% block content %}

<div class="container mt15" >

<div class="row" >

 <div class="col-md-12" >

   <div class="home-widget-sections"  >

     {% foreach($template->component->settings->getFrontendHomeWidgets() as $value): %}
     
         {% if($value["code"] == "slider_categories"): %}

         <section class="widget-categories-container d-none d-lg-flex" >{{ $template->component->home->outCategories() }}</section>

         {% endif %}

         {% if($value["code"] == "promo_banners"): %}

         <section class="widget-promo-banners-container" >{{ $template->component->home->outPromoBanners() }}</section>

         {% endif %}

         {% if($value["code"] == "stories"): %}

         <section class="widget-stories-container" >{{ $template->component->home->outStories() }}</section>

         {% endif %}

         {% if($value["code"] == "shops"): %}

         <section class="widget-shops-container" >{{ $template->component->home->outShops() }}</section>

         {% endif %}

         {% if($value["code"] == "articles_blog"): %}

         <section class="widget-articles-blog-container" >{{ $template->component->home->outArticlesBlog() }}</section>

         {% endif %}

         {% if($value["code"] == "ads_categories"): %}

         <section class="widget-ads-categories-container" >{{ $template->component->home->outAdsByCategories() }}</section>

         {% endif %}

         {% if($value["code"] == "vip_ads"): %}

         <section class="widget-ads-vip-container" >{{ $template->component->home->outAdsVip() }}</section>

         {% endif %}

         {% if($value["code"] == "ads"): %}

         <section class="widget-ads-container" >

            <div class="bold-title-and-link" >
               <span>{{ translate("tr_a0825e8ab6d3fdb685be22c1c21d9ebc") }}</span>
            </div>

            <div class="container-load-items" >
                <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3" >
                  {% component items/skeleton-col5.tpl %}
                </div>
            </div>

         </section>

         {% endif %}

     {% endforeach %}

     {% if($seo->h1): %}
         <section class="home-seo-text" >
            <h1 class="font-bold mb15" >{{ $seo->h1 }}</h1>
            {{ $seo->text }}
         </section>
     {% endif %}

   </div>

 </div>

</div>

</div>

{% endblock %}