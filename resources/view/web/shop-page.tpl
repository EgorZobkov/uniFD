{% extends index.tpl %}

{% block content %}

<div class="container mt20 mb50" >

<div class="row" >
  
  <div class="col-md-12" >

    <div>
      <a class="btn-custom-mini button-color-scheme2" href="{{ $template->component->shop->linkToShopCard($data->shop->alias) }}" ><i class="ti ti-chevron-left"></i>{{ translate("tr_2b0b0225a86bb67048840d3da9b899bc") }}</a>
    </div>

    <div class="personal-shop-pages d-none d-lg-block" >
       {{ $template->component->shop->outPages($data, "btn-custom-mini button-color-scheme2 personal-shop-pages-item"); }}
       {% if($data->owner): %}
       <span class="btn-custom-mini button-color-scheme6 personal-shop-pages-item actionDeletePageShop" data-id="{{ $data->page->id }}" >{{ translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8") }}</span>
       <span class="btn-custom-mini button-color-scheme5 personal-shop-pages-item actionEditPageShop" data-id="{{ $data->page->id }}" >{{ translate("tr_74ea58b6a801f0dce4e5d34dbca034dc") }}</span>
       {% endif %}
    </div>

    {% if($data->owner): %}
    <div class="personal-shop-pages d-block d-lg-none" >
       <span class="btn-custom-mini button-color-scheme6 personal-shop-pages-item actionDeletePageShop" data-id="{{ $data->page->id }}" >{{ translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8") }}</span>
       <span class="btn-custom-mini button-color-scheme5 personal-shop-pages-item actionEditPageShop" data-id="{{ $data->page->id }}" >{{ translate("tr_74ea58b6a801f0dce4e5d34dbca034dc") }}</span>
    </div>
    {% endif %}

  </div> 

</div>

<div class="row mt20 mb20" >

  <div class="col-md-3 mb10" >

    {% component shop-sidebar.tpl %}

  </div>

  <div class="col-md-9" >

      <h1 class="font-bold mt10 mb30">{{ $data->page->name }}</h1>

      {% if($data->owner): %}
      <div id="InlineEditor" >{{ $data->page->text ?: translate("tr_0a1c2e2e8d0056e6e5df18cc94fc968c") }}</div>
      {% else: %}
      <div class="textEditor" >{{ outTextWithLinks($data->page->text, false) }}</div>
      {% endif %}

  </div>

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

{% endblock %}